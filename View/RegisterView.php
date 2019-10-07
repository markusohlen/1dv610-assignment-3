<?php

namespace view;

class RegisterView {

    private static $userName = "RegisterView::UserName";
    private static $registerViewMessage = "RegisterView::Message";
    private static $password = "RegisterView::Password";
	private static $passwordRepeat = "RegisterView::PasswordRepeat";
	
	private $message = '';
	
	public function setMessage($msg) {
		$this->message = $msg;
	}
	/**
	 * Create HTTP response
	 *
	 * Should be called after a Register attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = '';
		
		$response = $this->generateRegisterFormHTML($message);
		//$response .= $this->generateLogoutButtonHTML($message);
		return $response;
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateRegisterFormHTML($message) {
		$currentUsername = "";
		if ($this->personPressedRegister() === true) {
			$currentUsername = $this->getRequestUserName();
		}
		$currentPassword = "";
		if ($this->personPressedRegister() === true) {
			$currentPassword = $this->getRequestUserName();
		}
		$currentPasswordRepeat = "";
		if ($this->personPressedRegister() === true) {
			$currentPasswordRepeat = $this->getRequestPasswordRepeat();
		}
		return '
        <a href="?">Back to Login</a><div class="container" >
          
                <h2>Register new user</h2>
                <form action="?register" method="post" enctype="multipart/form-data">
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id="' . self::$registerViewMessage . '">' . $this->message .'</p>
                        <label for="' . self::$userName . '" >Username :</label>
                        <input type="text" size="20" name="' . self::$userName . '" id="' . self::$userName . '" value="' . $currentUsername . '" />
                        <br/>
                        <label for="' . self::$password . '" >Password  :</label>
                        <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="' . $currentPassword . '" />
                        <br/>
                        <label for="' . self::$passwordRepeat . '" >Repeat password  :</label>
                        <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="' . $currentPasswordRepeat . '" />
                        <br/>
                        <input id="submit" type="submit" name="RegisterView::Register"  value="Register" />
                        <br/>
                    </fieldset>
                </form>
		';
    }
    
    private function personPressedRegister() {
        return false;
    }
}