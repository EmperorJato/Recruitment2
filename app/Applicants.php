<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicants extends Model
{
    protected $primaryKey = 'app_id';
    protected $table = 'applicants';
    protected $guarded = [];
}
