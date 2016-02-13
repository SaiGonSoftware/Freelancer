<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model {

	protected $table = "jobs";
    protected $fillable = ["id", "title", "slug","description", "content", "post_at", "day_open","deadline", "active", "allowance_min", "allowance_max", "location", "user_id"];
    public $timestamps= false;
    /**
     * Count total job posted exisit in the system
     *
     * @return number of job
    */
    public static function CountJobs()
    {
        return Job::count('id');
    }

    /**
     * Show reply of the job
     *
     * @return reply of that job
    */
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    
    /**
     * Show user post the job
     *
     * @return  user post the job
    */
    public function user() {
        return $this->BelongsTo('App\User');   
    }

    /**
         * [job show the tag of that post]
         * @return [type] [description]
         */
    public function tag(){
        return $this->hasOne('App\TagContent',"job_id","id");

    }

}
