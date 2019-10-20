<?php

namespace view;

class RegisterView 
{
    private static $register = "RegisterView::Register";
    private static $username = "RegisterView::UserName";
    private static $registerViewMessage = "RegisterView::Message";
    private static $password = "RegisterView::Password";
	private static $passwordRepeat = "RegisterView::PasswordRepeat";
	
	private $message = '';
    
	/**
	 * Create HTTP response
	 *
	 * Should be called after a Register attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
    public function response() 
    {
		$response = $this->generateRegisterFormHTML();

		return $response;
	}
    
    public function userPressedRegister() 
    {
        if (isset($_POST[self::$register]))
        {
			return true;
		}
        return false;
    }

    public function getUserCredentials() : \model\RegisterNewUser
    {
        $username = $this->getRequestUsername();
        $password = $this->getRequestPassword();
        $passwordRepeat = $this->getRequestPasswordRepeat();

        return new \model\RegisterNewUser($username, $password, $passwordRepeat);
    }

    public function userFilledInCredentials() : bool 
    {
		return $this->userFilledInUsername() && $this->userFilledInPassword() && $this->userFilledInPasswordRepeat();
    }

    // Messages
    public function setMissingCredentialsMessage() 
    {
        $minUsernameLength = \config\Constants::minUsernameLength;
        $this->message .= "Username has too few characters, at least $minUsernameLength characters.<br>";
    }

    public function setInvalidUsernameMessage() 
    {
        $minUsernameLength = \config\Constants::minUsernameLength;
        $this->message .= "Username has too few characters, at least $minUsernameLength characters.<br>";
    }

    public function setPasswordTooShortMessage() 
    {
        $minPassworLength = \config\Constants::minPasswordLength;
        $this->message .= "Password has too few characters, at least $minPassworLength characters.<br>";
    }

    public function setUsernameExistsMessage() 
    {
        $this->message .= "User exists, pick another username.<br>";
    }

    public function setPasswordsDoNotMatchMessage() 
    {
        $this->message .= "Passwords do not match.";
    }

    // Private
    
	/**
	* Generate HTML code on the output buffer for the logout button
	* @return  void, BUT writes to standard output!
    */
    private function generateRegisterFormHTML() 
    {
        $currentUsername = "";
        $currentPassword = "";
        $currentPasswordRepeat = "";

        if ($this->userPressedRegister() === true) 
        {
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

    private function getRequestUsername() 
    {
        return $_POST[self::$username];
    }

    private function getRequestPassword() 
    {
        return $_POST[self::$password];
    }

    private function getRequestPasswordRepeat() 
    {
        return $_POST[self::$passwordRepeat];
    }

    private function userFilledInUsername() : bool 
    {
        if (isset($_POST[self::$username]) && empty($_POST[self::$username]) === false) 
        {
			return true;
		}
		return false;
	}

    private function userFilledInPassword() : bool 
    {
        if (isset($_POST[self::$password]) && empty($_POST[self::$password]) === false) 
        {
			return true;
		}
		return false;
    }

    private function userFilledInPasswordRepeat() : bool 
    {
        if (isset($_POST[self::$passwordRepeat]) && empty($_POST[self::$passwordRepeat]) === false) 
        {
			return true;
		}
		return false;
    }
}