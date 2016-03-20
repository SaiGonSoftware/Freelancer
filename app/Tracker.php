<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
class Tracker extends Model {
	protected $fillable = ['ip', 'visit_date','hits','visit_time'];
	protected $table = 'tracker';
	public $timestamps = false;

	public static function hit()
	{
		$ip = Request::ip();
		$tracker = self::where('ip', '=', $ip)->first();
		if (!$tracker) {
			$tracker = new Tracker;
			$tracker->hits = 0;
			$tracker->ip = $ip;
		}
		$tracker->visit_date = date('Y-m-d');
		$tracker->visit_time = date('H:i:s');
		$tracker->hits++;
		return $tracker->save();
	}
}
