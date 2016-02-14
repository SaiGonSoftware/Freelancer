<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $table = "comments";
    protected $fillable = ["id","user_id", "introduce", "completed_day", "allowance", "job_id"];
    public $timestamps= false;

    /**
     * Show user reply the job
     *
     * @return  user reply the job
    */
    public function user(){
        return $this->BelongsTo('App\User');
    }

    /**
     * [post Show user name post the comment in user info manage]
     * @return [type] [description]
     */
    public function post(){
        return $this->BelongsTo('App\Job','job_id');
    }

    /**
     * [approved description]
     * @return [type] [description]
     */
    public function approved()
    {
        return $this->belongsTo('App\JobApproved','job_id','job_id');
    }
}
