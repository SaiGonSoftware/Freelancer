<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table = "chats";
    protected $fillable = ["id", "user1", "user2", "user1_typing", "user2_typing"];
    public $timestamps= false;
}
