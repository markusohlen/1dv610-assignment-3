<?php

namespace view;

class RegisterView {
    private static $register = "RegisterView::Register";
    private static $username = "RegisterView::UserName";
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
        $currentPassword = "";
        $currentPasswordRepeat = "";
		if ($this->userPressedRegister() === true) {
            $currentUsername = $this->getRequestUsername();
            $currentPassword = $this->getRequestPassword();
            $currentPasswordRepeat = $this->getRequestPasswordRepeat();
		}

		return '
        <a href="?">Back to Login</a><div class="container" >
          
                <h2>Register new user</h2>
                <form action="?register" method="post" enctype="multipart/form-data">
                    <fieldset>
                    <legend>Register a new user - Write username and password</legend>
                        <p id="' . self::$registerViewMessage . '">' . $this->message .'</p>
                        <label for="' . self::$username . '" >Username :</label>
                        <input type="text" size="20" name="' . self::$username . '" id="' . self::$username . '" value="' . $currentUsername . '" />
                        <br/>
                        <label for="' . self::$password . '" >Password  :</label>
                        <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="' . $currentPassword . '" />
                        <br/>
                        <label for="' . self::$passwordRepeat . '" >Repeat password  :</label>
                        <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="' . $currentPasswordRepeat . '" />
                        <br/>
                        <input id="submit" type="submit" name="' . self::$register . '"  value="Register" />
                        <br/>
                    </fieldset>
                </form>
		';
    }
    
    public function userPressedRegister() {
        if (isset($_POST[self::$register]) && $_POST[self::$register] === "Register") {
			return true;
		}
        return false;
    }

    public function getRequestUsername() {
        return $_POST[self::$username];
    }

    public function getRequestPassword() {
        return $_POST[self::$password];
    }

    public function getRequestPasswordRepeat() {
        return $_POST[self::$passwordRepeat];
    }

    private function userFilledInUsername() : bool {
		if (isset($_POST[self::$username]) && empty($_POST[self::$username]) === false) {
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

    private function userFilledInPasswordRepeat() : bool {
		if (isset($_POST[self::$passwordRepeat]) && empty($_POST[self::$passwordRepeat]) === false) {
			return true;
		}
		return false;
    }
    
    public function userFilledInCredentials() : bool {
		return $this->userFilledInUsername() && $this->userFilledInPassword() && $this->userFilledInPasswordRepeat();
    }

    public function setMissingCredentialsMessage() {
        $this->message .= "Username has too few characters, at least 3 characters.<br>";
    }

    public function setInvalidUsernameMessage() {
        $this->message .= "Username has too few characters, at least 3 characters.<br>";
    }

    public function setPasswordTooShortMessage() {
        $this->message .= "Password has too few characters, at least 6 characters.<br>";
    }

    public function setUsernameExistsMessage() {
        $this->message .= "User exists, pick another username.<br>";
    }

    public function setPasswordsDoNotMatchMessage() {
        $this->message .= "Passwords do not match.";
    }
}