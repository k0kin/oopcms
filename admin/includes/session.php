<?php 

class Session 
{
	private $signedIn = false;
	public $userId;
	public $message;

	function __construct()
	{
		session_start();
		$this->checkTheLogin();
		$this->checkMessage();
	}

	public function isSignedIn()
	{
		return $this->signedIn;
	}

	public function login($user)
	{
		if($user)
		{
			$this->userId = $_SESSION['userId'] = $user->id;
			$this->signedIn = true;
		}
	}

	public function logout()
	{
		unset($_SESSION['userId']);
		unset($this->userId);
		$this->signedIn = false;

	}

	private function checkTheLogin()
	{
		if(isset($_SESSION['userId']))
		{
			$this->userId = $_SESSION['userId'];
			$this->signedIn = true;
		} else{
			unset($this->userId);
			$this->signedIn = false;
		}
	}

	public function  message($msg="")
	{
		if(!empty($msg))
		{
			$_SESSION['message'] = $msg;
		}
		else
		{
			return $this->message;
		}
	}

	private function checkMessage()
	{
		if(isset($_SESSION['message']))
		{
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}
		else
		{
			$this->message = "";
		}
	}

}


$session = new Session();

?>