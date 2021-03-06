<?php
namespace Copyleaks;


class LoginToken{

	public $token;
	public $timeIssued;
	public $expirationDate;
	public $tokenArr;

	public function __construct($tokenArr=array()){
		$this->config = new \ReflectionClass('Copyleaks\Config');
		$this->constants = $this->config->getConstants();

		$this->token = $tokenArr['access_token'];
		$this->timeIssued = $tokenArr['.issued'];
		$this->expirationDate = $tokenArr['.expires'];
		$this->tokenArr = $tokenArr;

	}

	public function authHeader(){
		return $this->constants['AUTHORIZATION_HEADER'].' '.$this->token;
	}

	public function validate(){
		$today = time();
		$_expirationDate = isset($this->expirationDate) ? strtotime($this->expirationDate) : 0;
		
		return isset($this->token) && strlen($this->token) > 22 && $today <= $_expirationDate;
	}
}

?>