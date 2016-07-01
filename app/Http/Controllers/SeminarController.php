<?php

namespace App\Http\Controllers;

use App\Seminar;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeminarController extends Controller
{

    private $registrationErrors;


    public function getSeminarScreen($slug){
        $seminar = $this->getSeminar($slug);
        if(!$seminar) return abort(404);
        return view('seminars.index', compact('seminar'));
    }

    public function getRegistrationScreen($slug){
        $seminar = $this->getSeminar($slug);
        if(!$seminar) return abort(404);
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
                ]);
            }
        }else{
            return response()->json([
                'OK' => false,
                'reason' => 'technical'
            ]);
        }

    }

    private function validateRegistrationData($participants, array $data){

        $phoneFilter = array_filter($participants, function($participant) use ($data){
           return  $data['phone'] == json_decode($participant, true)['phone'];
        });

        $emailFilter = array_filter($participants, function($participant) use ($data){
            return $data['email']  == json_decode($participant, true)['email'];
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
            'custom_email' => 'The selected email address already exists.',
            'custom_phone' => 'The selected phone number already exists.'
        ]);

        if($validator->fails()){
            $this->registrationErrors = $validator->errors();
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
