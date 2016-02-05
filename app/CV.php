<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    protected $table = "cv";
    protected $fillable = ["id", "name","avatar", "job_name","phone","email","address", "education", "experience", "activities", "capabilities", "skill", "interests", "user_id","personal_site"];
    public $timestamps= false;

    public function cv()
    {
    	return $this->belongsTo('App\User');
    }
}
