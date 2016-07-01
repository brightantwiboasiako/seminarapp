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

}