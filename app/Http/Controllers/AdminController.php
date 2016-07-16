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

    public function getCommentsScreen($slug){
        return $this->showScreen('comments', $slug);
    }

    public function getFilesLinkScreen($slug){
        return $this->showScreen('files', $slug);
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
        $seminar = $this->getSeminarBySlug($slug);

        if($seminar){
            return view('admin.'.$view, compact('seminar'));
        }

        return abort(404);
    }


    public function getSettingsScreen(){
        return view('admin.settings');
    }


    public function changePassword(Request $request){

        Validator::extend('auth_password', function($attribute, $value, $parameters, $validator) use ($request){

            return \Hash::check($request->input('current_password'), \Auth::user()->password);

        });

        $this->validate($request, [
            'current_password' => 'required|min:5|auth_password',
            'new_password' => 'required|min:5'
        ], [
            'auth_password' => 'Incorrect current password. Please try again.'
        ]);


        \Auth::user()->update([
            'password' => bcrypt(e($request->input('new_password')))
        ]);


        return back()->with('success', 'Password successfully changed.');


    }


    private function getSeminarBySlug($slug){
        return Seminar::where('slug', e($slug))->first();
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


    public function editSeminar(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:seminars,title,'.$request->input('id'),
            'location' => 'required',
            'date' => 'required|date',
            'registration_deadline' => 'required|date'
        ]);

        if($validator->passes()){

            $seminar = $this->getSeminarBySlug($request->input('slug'));

            $seminar->update(array_merge($request->all()));
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
