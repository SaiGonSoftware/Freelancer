<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
class Tracker extends Model
{
    protected $fillable = ['visit_date', 'hits', 'visit_time', 'username'];
    protected $table = 'tracker';
    public $timestamps = false;

    public static function hit()
    {
        $now = date('Y-m-d');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $record=self::whereRaw('username =? and visit_date =? ',[ Auth::user()->username,$now] )->first();
        if (empty($record)) {
            $record = new Tracker;
            $record->hits = 1;
            $record->username = Auth::user()->username;
            $record->visit_date = date('Y-m-d');
            $record->visit_time = date('H:i:s');
            return $record->save();
        } else {
            $record->hits++;
            return $record->save();
        }
    }
}
