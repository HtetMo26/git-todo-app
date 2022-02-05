<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $table = 'todos';
    protected $fillable = ['name', 'status', 'user_id'];
}
