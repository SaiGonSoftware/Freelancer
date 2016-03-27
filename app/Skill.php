<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model {
	protected $table = "skill";
	protected $fillable = ["id", "cv_id", "skill_name","user_id"];
	public $timestamps = false;
}
