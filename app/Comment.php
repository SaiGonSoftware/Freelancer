<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $table = "comments";
    protected $fillable = ["user_id", "introduce", "completed_day", "allowance", "job_id"];
    public $timestamps= false;

    /**
     * Show user reply the job
     *
     * @return  user reply the job
    */
    public function user(){
        return $this->BelongsTo('App\User');
    }
}
