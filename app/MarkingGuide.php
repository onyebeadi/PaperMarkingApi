<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class MarkingGuide extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'subject_name', 'answers',
    ];


}
