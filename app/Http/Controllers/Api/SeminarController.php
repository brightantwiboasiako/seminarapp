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

    public function survey($slug){
        $responses = $this->getSeminarBySlug($slug)->getSurveyResponses();

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

        $responseCategories = ['school', 'visa', 'funding', 'exams', 'tests', 'iaba', 'publicity', 'QandA'];

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

                $selections = ['Very Good', 'Good', 'Average', 'Poor', 'Very Poor'];

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
    
    public function participants($slug){
        return json_encode($this->getSeminarBySlug($slug)->getParticipants(), true);
    }

    private function getSeminarBySlug($slug){
        $seminar = Seminar::where('slug', e($slug))->first();

        if($seminar) return $seminar;

        return new Seminar();
    }

}