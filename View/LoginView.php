<?php

namespace view;

class LoginView 
{
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $showRegister = 'register';

	private $db;
	private $sm;

	private $message = "";

	public function __construct(\view\CalendarView $cv, \model\SessionModel $sm) 
	{
		$this->db = new \model\DatabaseModel();
		$this->cv = $cv;
		$this->sm = $sm;
	}

	/**
	* Generate HTML code for the login view
	*
	* @return String - A html page as a string
	*/
	public function response(bool $isLoggedIn) : string 
	{
		if ($isLoggedIn === true) 
		{
			$response = $this->generateLogoutButtonHTML();
			$response .= $this->cv->response();
		}
		else 
		{
			$response = $this->generateLoginFormHTML();
		}

		return $response;
	}

	public function userPressedLogin() : bool 
	{
		if (isset($_POST[self::$login])) 
		{
			return true;
		}
		return false;
	}

	public function userPressedLogout() : bool 
	{
		if (isset($_POST[self::$logout])) 
		{
			return true;
		}
		return false;
	}

	public function userWantsToShowRegisterForm() : bool
	{
		if (isset($_GET[self::$showRegister])) 
		{
			return true;
		}
		return false;
	}

	public function getUserCredentials() : \model\User
	{
		$username = $this->getRequestUsername();
		$password = $this->getRequestPassword();

		return new \model\User($username, $password);
	}

	public function setMissingUsernameMessage() : void
	{
		$this->message = "Username is missing";
	}

	public function setMissingPasswordMessage() : void
	{
		$this->message = "Password is missing";
	}

	public function setIncorrectCredentialsMessage() : void 
	{
		$this->message = "Wrong name or password <br>";
	}

	public function setWelcomeMessage() : void 
	{
		$this->message = "Welcome";
	}

	public function setLogoutMessage() : void 
	{
		$this->message = "Bye bye!";
	}

	public function setNewlyRegisteredMessage()
	{
		$this->message = "Registered new user.";
	}

	/**
    * Generate HTML code for the logout component
    *
	* @return String - A html page as a string
	*/
	private function generateLogoutButtonHTML() : string 
	{
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
			
		';
	}
	
	/**
    * Generate HTML code for the login form
    *
	* @return String - A html page as a string
	*/
	private function generateLoginFormHTML() : string 
	{
		$currentUsername = "";
		if ($this->sm->usernameIsSet() === true)
		{
			$currentUsername = $this->sm->getUsername();
			$this->sm->unsetUsername();
		}
		if ($this->userPressedLogin() === true) 
		{
			$currentUsername = $this->getRequestUsername();
		}

		return '
		<a href="?' . self::$showRegister . '">Register a new user</a>
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $currentUsername .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	private function getRequestUsername() : string 
	{
		return $_POST[self::$name];
	}

	private function getRequestPassword() : string 
	{
		return $_POST[self::$password];
	}
}