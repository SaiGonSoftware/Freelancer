<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {
	protected $table = "chat";
	protected $fillable = ["id", "content", "from_user", "to_user", "created_at", "view"];
	public $timestamps = false;

	public function user() {
		return $this->belongsTo('\App\User', 'from_user', 'username');
	}
}
