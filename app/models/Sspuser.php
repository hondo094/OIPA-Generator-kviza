<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Sspuser extends Eloquent implements UserInterface, RemindableInterface {

        protected $fillable = array('email', 'firstName', 'lastName', 'username', 'password', 'password_temp', 'code', 'member');
    
	use UserTrait, RemindableTrait;

        //protected $primaryKey = 'id';
        
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sspusers';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
        
        
        /**
         * Get the unique identifier for the user.
         *
         * @return mixed
         */
        public function getAuthIdentifier()
        {
            return $this->getKey();
        }

        /**
         * Get the password for the user.
         *
         * @return string
         */
        public function getAuthPassword()
        {
            return $this->password;
        }

        /**
         * Get the e-mail address where password reminders are sent.
         *
         * @return string
         */
        public function getReminderEmail()
        {
            return $this->email;
        }

        public function isMember()
        {
            return $this->member;
        }

}
