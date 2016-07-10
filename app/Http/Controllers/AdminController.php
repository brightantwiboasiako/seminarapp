<?php

namespace App\Http\Controllers;

use App\Seminar;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{


    public function dashboard(){
        return view('admin.dashboard');
    }

    public function getSurveyScreen($slug){
        return $this->showScreen('survey', $slug);
    }

    public function getParticipantsScreen($slug){
        return $this->showScreen('participants', $slug);
    }


    public function showSeminarScreen($slug){
        return $this->showScreen('seminar', $slug);
    }

    private function showScreen($view, $slug){
        $seminar = Seminar::where('slug', e($slug))->first();

        if($seminar){
            return view('admin.'.$view, compact('seminar'));
        }

        return abort(404);
    }


    public function createSeminar(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:seminars,title',
            'location' => 'required',
            'date' => 'required|date',
            'registration_deadline' => 'required|date'
        ]);

        if($validator->passes()){
            Seminar::create(array_merge($request->all(), ['slug' => str_slug($request->input('title'), '-')]));
            return response()->json([
                'OK' => true
            ]);
        }else{
            return response()->json([
                'OK' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

}
