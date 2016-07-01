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
    
    public function register(array $data){
        $existing = $this->getParticipants();
        $existing[] = json_encode($data, true);

        $this->participants = json_encode($existing, true);
        return $this->save();
    }

    public function getParticipants(){

        if(!$this->participants){
            return [];
        }

        return json_decode($this->participants, true);
    }
}
