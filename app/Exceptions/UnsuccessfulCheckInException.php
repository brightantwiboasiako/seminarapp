<?php
/**
 * Created by PhpStorm.
 * User: Bright
 * Date: 15/07/2016
 * Time: 12:29
 */

namespace App\Exceptions;


class UnsuccessfulCheckInException extends \Exception
{

    public function __construct($message){
        parent::__construct($message);
    }

}