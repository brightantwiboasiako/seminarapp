<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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


    public function date(){
        return (new Carbon($this->date))->format('jS M, Y');
    }

    public function time(){
        return (new Carbon($this->date))->format('H:i').'GMT';
    }

    public function location(){
        return $this->location;
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
