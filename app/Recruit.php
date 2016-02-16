<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruit extends Model
{
    protected $table = "jobs_post";
    protected $fillable = ['id', 'title', 'slug', 'content', 'experience_year', 'quantity', 'salary', 'post_at', 'location', 'user_id'];
    public $timestamps= false;
}
