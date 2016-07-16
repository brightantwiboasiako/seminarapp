<?php
/**
 * Created by PhpStorm.
 * User: Bright
 * Date: 6/29/2016
 * Time: 2:16 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Seminar;

class SeminarController extends Controller
{

    public function all(){
        return Seminar::all()->toJson();
    }

    public function comments($slug){
        return $this->getSeminarBySlug($slug)->commentsAsJson();
    }

    public function survey($slug){
        return $this->getSeminarBySlug($slug)->preparedSurveyResponsesAsJson();
    }
    
    public function participants($slug){
        return json_encode($this->getSeminarBySlug($slug)->getParticipants(), true);
    }

    private function getSeminarBySlug($slug){
        $seminar = Seminar::where('slug', e($slug))->first();

        if($seminar) return $seminar;

        return new Seminar();
    }

}