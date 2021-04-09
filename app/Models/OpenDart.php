<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class OpenDart extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dart_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
