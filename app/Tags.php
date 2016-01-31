<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
	protected $table = "tag";
	protected $fillable = ["id", "name"];
	public $timestamps= false;
}
