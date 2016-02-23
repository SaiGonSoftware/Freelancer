<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
	protected $table = "chat";
	protected $fillable = ["id", "content","from_user_id","to_user_id","created_at","view"];
	public $timestamps= false;
}
