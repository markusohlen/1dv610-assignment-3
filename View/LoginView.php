<?php

namespace view;

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private $db;

	private $message = "";

	public function __construct() {
		$this->db = new \model\DatabaseModel();
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return string BUT writes to standard output and cookies!
	 */
	public function response(bool $isLoggedIn) : string {
		if ($isLoggedIn === true) {
			$response = $this->generateLogoutButtonHTML();
		}
		else {
			$response = $this->generateLoginFormHTML();
		}

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @return string BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML() : string {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $this->message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @return , BUT writes to standard output!
	*/
	private function generateLoginFormHTML() : string {
		$currentUsername = "";
		if ($this->userPressedLogin() === true) {
			$currentUsername = $this->getRequestUsername();
		}

		return '
		<a href="?register">Register a new user</a>
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
	
	public function getRequestUsername() : string {
		return $_POST[self::$name];
	}

	public function getRequestPassword() : string {
		return $_POST[self::$password];
	}
	
	public function userPressedLogin() : bool {
		if (isset($_POST[self::$login])) {
			return true;
		}
		return false;
	}

	public function userPressedLogout() : bool {
		if (isset($_POST[self::$logout])) {
			return true;
		}
		return false;
	}

	private function userFilledInUsername() : bool {
		if (isset($_POST[self::$name]) && empty($_POST[self::$name]) === false) {
			return true;
		}
		return false;
	}

	private function userFilledInPassword() : bool {
		if (isset($_POST[self::$password]) && empty($_POST[self::$password]) === false) {
			return true;
		}
		return false;
	}

	public function userFilledInCredentials() : bool {
		return $this->userFilledInUsername() && $this->userFilledInPassword();
	}

	public function setMissingCredentialsMessage() : void {

		if ($this->userFilledInUsername() === false) {
			$this->message = "Username is missing";
		}
		else {
			$this->message = "Password is missing";
		}
	}

	public function setIncorrectCredentialsMessage() : void {
		$this->message = "Wrong name or password <br>";
	}

	public function setWelcomeMessage() : void {
		$this->message = "Welcome";
	}

	public function setLogoutMessage() : void {
		$this->message = "Bye bye!";
	}
}