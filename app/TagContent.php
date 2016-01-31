<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagContent extends Model
{
	protected $table = "content_tag";
	protected $fillable = ["id", "job_id","tag_content"];
	public $timestamps= false;
}
