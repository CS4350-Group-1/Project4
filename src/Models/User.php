<?php
namespace Models;

class User {
	protected 	$username;			//string
	private 	$password; 			//string
	protected 	$firstName;			//string
	protected 	$lastName;			//string
	protected 	$email;				//string
	protected 	$twittername;		//string
	protected 	$registrationDate;	//string

	public function __construct ($param_username, $param_password) {
		$this->username = $param_username;
		$this->password = $param_password;
	}
	public function getUsername () {
		return $this->username;
	}

	public function getPassword () {
		return $this->password;
	}

	public function getFirstName () {
		return $this->firstName;
	}

	public function setFirstName ($param_firstName) {
		$this->firstName = $param_firstName;
	}

	public function getLastName () {
		return $this->firstName;
	}

	public function setEmail ($param_email) {
		$this->email = $param_email;
	}

	public function getEmail () {
		return $this->email;
	}

	public function setTwitterName($param_twittername) {
		$this->twittername = $param_twittername;
	}

	public function getTwitterName () {
		return $this->twittername;
	}

	public function setLastName ($param_lastName) {
		$this->lastName = $param_lastName;
	}

	public function getRegistrationDate () {
		return $this->registrationDate;
	}



	public function setRegistrationDate($param_registrationDate) {
		$this->registrationDate = $param_registrationDate;
	}


}

