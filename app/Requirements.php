<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirements extends Model
{
    protected $primaryKey = 'rs_id';
    protected $table = 'requirements_section';
    protected $guarded = [];
    public $timestamps  = false;
}
