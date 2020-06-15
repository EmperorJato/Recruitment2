<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    protected $primaryKey = 'ss_id';
    protected $table = 'screening_section';
    protected $guarded = [];
    public $timestamps  = false;
}
