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
        if (self::where('visit_date', '<', $now)) {
            $tracker = new Tracker;
            $tracker->hits = 1;
            $tracker->username = Auth::user()->username;
            $tracker->visit_date = date('Y-m-d');
            $tracker->visit_time = date('H:i:s');
            return $tracker->save();
        } else {
            $tracker = self::where('username', '=', Auth::user()->username)->first();
            if (!$tracker) {
                $tracker = new Tracker;
                $tracker->hits = 0;
            }
            $tracker->username = Auth::user()->username;
            $tracker->visit_date = date('Y-m-d');
            $tracker->visit_time = date('H:i:s');
            $tracker->hits++;
            return $tracker->save();
        }
    }
}
