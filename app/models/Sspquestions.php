<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class Sspquestions extends Eloquent implements UserInterface, RemindableInterface {

      
	use UserTrait, RemindableTrait, SoftDeletingTrait;

        protected $primaryKey = 'id';
        
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sspquestions';
        
        protected $softDelete = true;
        protected $fillable = array('sspquizz_id', 'question_number', 'type', 'question', 'answers', 'correct');
        
       

        public function quizz() {
		return $this->belongsTo('Sspquizz');
	}
        

}
