<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeminarResponse extends Model
{
    protected $table = 'seminar_responses';

    protected $fillable = ['seminar_id', 'responses'];

    public $timestamps = false;
}
