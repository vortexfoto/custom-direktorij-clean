<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    protected $fillable = ['form_builder', 'user_id','type', 'created_at', 'updated_at'];

}
