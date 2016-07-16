<?php

namespace App;

use App\Exceptions\UnsuccessfulCheckInException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seminar extends Model
{
    protected $table = 'seminars';

    protected $fillable = [
        'title',
        'slug',
        'location',
        'registration_deadline',
        'date',
        'files_url',
        'participants'
    ];


    private $surveySelections = ['Very Good', 'Good', 'Average', 'Poor', 'Very Poor'];


    public function date(){
        return (new Carbon($this->date))->format('jS M, Y');
    }

    public function time(){
        return (new Carbon($this->date))->format('H:i').'GMT';
    }

    public function location(){
        return $this->location;
    }

    public function ongoing(){
        return $this->started() && !$this->closed();
    }


    public function surveyOpen(){
        return $this->ongoing();
    }


    public function filesUrl(){
        if($this->files_url == null || $this->files_url == ''){
            return 'Download link unavailable';
        }else{
            return $this->files_url;
        }
    }


    public function filesDownloadLinkAvailable(){
        return !($this->files_url == null || $this->files_url == '');
    }

    public function commentsAsJson(){
        $comments = SeminarResponse::where('seminar_id', $this->id)->pluck('type_in_response')->all();

        return json_encode($comments, true);
    }



    public function participantsCsv($fileName){
        
        $file = fopen($fileName, 'w');

        fputcsv($file, [
            'Name', 'Gender', 'Email', 'Phone', 'Institution', 'Programme', 'Completion Year', 'Attendance'
        ]);            


        $participants = $this->getParticipants();

        foreach($participants as $participant){

            fputcsv($file, [
                $participant['surname'].' '.$participant['first_name'], 
                $participant['gender'], 
                $participant['email'], 
                $participant['phone'], 
                ($participant['institution'] == 'other') ? $participant['institution_other'] : $participant['institution'], 
                ($participant['programme'] == 'other') ? $participant['programme_other'] : $participant['programme'], 
                $participant['completion_year'],
                (isset($participant['in'])) ? 'Present' : 'Upsent'
            ]);

        }

        fclose($file);
    }


    public function checkIn($email){
        $participant = $this->getParticipantByEmail($email);

        if(!empty($participant)){
            if(!isset($participant['in'])){
                $this->updateParticipant($participant, 'in', true);
            }else{
                throw new UnsuccessfulCheckInException('Multiple check-ins are disallowed!');
            }

        }else{
            throw new UnsuccessfulCheckInException('Provided information: ' . $email . ' could not be found! Have you registered?');
        }

    }


    /**
     * @param $email
     * @return int
     */
    private function getParticipantIndexByEmail($email){
        $participants = $this->getParticipants();

        foreach($participants as $key => $participant){
            if($email === $participant['email']){
                return (int)$key;
            }
        }

        return -1;
    }

    private function updateParticipant(array $participant, $key, $value){

        $participants = $this->getParticipants();

        if(($index = $this->getParticipantIndexByEmail($participant['email'])) != -1){
            $participant[$key] = $value;
            $participants[$index] = $participant;
        }

        $this->saveParticipants($participants);
    }

    public function saveParticipants(array $participants){
        $this->participants = json_encode($participants, true);
        $this->save();
    }

    public function getParticipantByEmail($email){
        return $this->filterParticipant($email, 'email');
    }

    private function filterParticipant($value, $field){
        $participants = $this->getParticipants();

        $found = array_filter($participants, function($participant) use ($field, $value){
             return $this->participantFilterRule($field, $value, $participant);
        });

        if(!empty($found)){
            return array_slice($found, 0)[0];
        }

        return [];

    }

    private function participantFilterRule($field, $value, $participant){
        switch($field){
            case 'email':
                return $participant['email'] == $value;
            case 'phone':
                return $participant['phone'] == $value;
        }
    }
    
    public function register(array $data){
        $existing = $this->getParticipants();
        $existing[] = $data;

        $this->participants = json_encode($existing, true);
        return $this->save();
    }

    public function getSurveyResponses(){
        $responses = SeminarResponse::where('seminar_id', $this->id)->get();

        if($responses->count()){
            return $responses->toArray();
        }else{
            return [];
        }
    }


    public function preparedSurveyResponses(){
        return json_decode($this->preparedSurveyResponsesAsJson(), true);
    }


    public function surveyDataCsv($fileName){
        $responses = $this->preparedSurveyResponses();

        $file = fopen($fileName, 'w');

        fputcsv($file, array_merge([' '],$this->surveySelections));

        foreach($responses as $key => $response){

            foreach($response as $anotherKey => $categories){
                fputcsv($file, [Str::upper($key).'_'.$anotherKey]);
                fputcsv($file, array_merge([' '],$categories));
            }

        }

        fclose($file);
    }


    public function preparedSurveyResponsesAsJson(){

        $responses = $this->getSurveyResponses();

        $combinedResponses = [];

        foreach($responses as $response){
            $combinedResponses[] = json_decode($response['responses'], true);
        }

        $mergedResponses = [];

        foreach($combinedResponses as $combined){
            foreach($combined as $set){
                $mergedResponses[] = $set;
            }
        }

        $responseCategories = ['school_search', 'school_application', 'visa', 'funding', 'exams', 'tests', 'iaba', 'publicity', 'QandA','overall'];

        $counts = [];

        foreach ($responseCategories as $responseCategory){
            $category = array_filter($mergedResponses, function($response) use ($responseCategory){
                return $response['id'] == $responseCategory;
            });


            $mergedQuestions = [];
            foreach($category as $categoryResponse){
                $questions = $categoryResponse['questions'];
                foreach($questions as $question){
                    $mergedQuestions[] = $question;
                }
            }


            $questionCategories = [];
            foreach($mergedQuestions as $merged){
                $questionCategories[] = $merged['id'];
            }

            $questionCategories = array_unique($questionCategories);

            foreach($questionCategories as $category){
                $categoryQuestions = array_filter($mergedQuestions, function($question) use ($category){
                    return $question['id'] == $category;
                });

                $selections = $this->surveySelections;

                $selectionsCount = [];

                foreach($selections as $selection){
                    $selectionsCount[] = count(array_filter($categoryQuestions, function($question) use ($selection){
                        return $question['selected'] == $selection;
                    }));
                }

                $counts[$responseCategory][$category] = $selectionsCount;
            }
        }

        return json_encode($counts, true);
    }



    public function getTotalResponses(){
        return count($this->getSurveyResponses());
    }


    public function getParticipants(){

        if($this->participants == null || $this->participants == ''){
            return [];
        }

        return json_decode($this->participants, true);
    }

    /**
     * @return bool
     */
    public function started(){
        return (new Carbon($this->date))->lt(Carbon::now());
    }

    public function registrationClosed(){
        return (new Carbon($this->registration_deadline))->lt(Carbon::now());
    }

    public function closed(){
        return (new Carbon($this->date))->addDay()->lt(Carbon::now());
    }

    public function getTotalParticipants(){
        return count($this->getParticipants());
    }

}
