<?php

namespace App\Http\Controllers;

use App\Exceptions\UnsuccessfulCheckInException;
use App\Seminar;

use App\Http\Requests;
use App\SeminarResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeminarController extends Controller
{

    private $registrationErrors;


    public function delete($slug){
        $seminar = $this->getSeminar($slug);

        if($seminar && $seminar->delete()){
            return response()->json([
                'OK' => true
            ]);
        }else{
            return response()->json([
                'OK' => false
            ]);
        }
    }


    public function saveFilesUrl(Request $request){

        $slug = e($request->input('slug'));
        $url = e($request->input('url'));

        $seminar = $this->getSeminar($slug);

        if($seminar){
            $seminar->update([
                'files_url' => $url
            ]);

            return response()->json([
                'OK' => true
            ]);
        }

        return response()->json([
            'OK' => 'false'
        ]);

    }


    public function downloadParticipants($slug){
        $seminar = $this->getSeminar($slug);

        $fileName = $slug.'_participants.csv';

        if($seminar){

            $seminar->participantsCsv($fileName);

            return $this->downloadCsv($fileName);
            
        }

        abort(404);
    }


    public function downloadSurveyData($slug){
        $seminar = $this->getSeminar($slug);

        $fileName = $slug.'_survey.csv';

        if($seminar){
            $seminar->surveyDataCsv($fileName);

            return $this->downloadCsv($fileName);
        }

        abort(404);

    }


    private function downloadCsv($fileName){
        return response()->download($fileName, $fileName, [
            'Content-Type' => 'text/csv'
        ]);
    }


    public function processCheckIn(Request $request, $slug){

        $seminar = $this->getSeminar($slug);

        $response = [
            'OK' => false
        ];

        if($seminar){

            try{
                $seminar->checkIn($request->input('email'));
                $response['OK'] = true;
            }catch(UnsuccessfulCheckInException $e){
                $response['OK'] = false;
                $response['message'] = $e->getMessage();
            }

        }

        return response()->json($response);

    }


    public function showCheckInScreen($slug){

        $seminar = $this->getSeminar($slug);

        if(!$seminar || !$seminar->started()) return abort(401, 'Seminar Not Started! You cannot check in.');

        return $this->showScreen('checkin', $slug);
    }

    public function showSurveyScreen($slug){

        $seminar = $this->getSeminar($slug);

        if(!$seminar->surveyOpen()) return abort(401, 'Survey not available at this time.');

        return $this->showScreen('survey', $slug);
    }

    public function processSurveyResponse(Request $request, $slug){
        $seminar = $this->getSeminar($slug);

        if($seminar){
            // save response
            SeminarResponse::create([
               'seminar_id' => $seminar->id,
                'responses' => json_encode($request->input('responses'), true),
                'type_in_response' => json_encode($request->input('type_in'), true)
            ]);
        }

        return response()->json([
            'OK' => true
        ]);
    }


    public function showDirectionsScreen($slug){
        return $this->showScreen('directions', $slug);
    }

    public function getSeminarScreen($slug){
        return $this->showScreen('index', $slug);
    }

    private function showScreen($view, $slug){
        $seminar = $this->getSeminar($slug);
        if(!$seminar) return abort(404);

        return view('seminars.'.$view, compact('seminar'));
    }

    public function getRegistrationScreen($slug){
        $seminar = $this->getSeminar($slug);
        if(!$seminar || $seminar->registrationClosed()) return abort(404);
        return view('seminars.register', compact('seminar'));
    }


    public function register(Request $request){

        $data = $request->all();

        $seminar = $this->getSeminar(e($data['slug']));

        if($seminar){
            if($this->validateRegistrationData($seminar->getParticipants(), $data)){
                unset($data['slug']);
                $seminar->register($data);

                return response()->json([
                    'OK' => true
                ]);
            }else{
                return response()->json([
                   'OK' => false,
                    'errors' => $this->registrationErrors,
                    'reason' => 'validation'
                ], 422);
            }
        }else{
            return response()->json([
                'OK' => false,
                'reason' => 'technical'
            ], 500);
        }

    }

    private function validateRegistrationData($participants, array $data){

        $phoneFilter = array_filter($participants, function($participant) use ($data){
           return  $data['phone'] == $participant['phone'];
        });

        $emailFilter = array_filter($participants, function($participant) use ($data){
            return $data['email']  == $participant['email'];
        });

        Validator::extend('custom_phone', function($attribute, $value, $parameters, $validation) use ($phoneFilter){
            return count($phoneFilter) == 0;
        });

        Validator::extend('custom_email', function($attribute, $value, $parameters, $validation) use ($emailFilter){
            return count($emailFilter) == 0;
        });

        $validator = Validator::make($data, [
            'email' => 'required|email|custom_email',
            'phone' => 'required|max:15|custom_phone',
            'gender' => 'required|in:male,female',
            'institution' => 'required',
            'completion_year' => 'required',
            'programme' => 'required',
            'surname' => 'required|max:128',
            'first_name' => 'required|max:128'
        ],[
            'custom_email' => 'Someone has registered with this email address.',
            'custom_phone' => 'This phone number already exists.',
            'institution_other.required' => 'Please specify your institution.',
            'programme_other.required' => 'Please you need to tell us the programme you studied.'
        ]);

        $validator->sometimes('institution_other', 'required|max:128', function($input) {
            return $input->institution == 'other';
        });

        $validator->sometimes('programme_other', 'required|max:128', function($input) {
            return $input->programme == 'other';
        });

        if($validator->fails()){
            $this->registrationErrors = $validator->messages();
        }

        return $validator->passes();
    }


    /**
     * @param $slug
     * @return Seminar | null
     */
    private function getSeminar($slug){
        return Seminar::where('slug', $slug)->first();
    }
}
