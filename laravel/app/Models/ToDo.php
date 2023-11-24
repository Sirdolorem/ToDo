<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{

    protected $table = "todo";

    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'create_date',
        'complete_date'
    ];

    public function user(){

        return $this->belongsTo(User::class, "user_id");
    }

}
