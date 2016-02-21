<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
   	protected $table = "chat_messages";
   	protected $fillable = ["id", "username", "message","read","user_id"];
    public $timestamps= false;
}
