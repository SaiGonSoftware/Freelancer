<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApproved extends Model
{
    protected $table = "jobs_approved";
	protected $fillable = ["id","job_id","user_assign","user_post"];
	public $timestamps= false;

	
}
