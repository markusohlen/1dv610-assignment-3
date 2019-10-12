<?php

namespace model;

class RegisterModel {
    public function usernameIsValid ($username) {
        if (strlen($username) >= 3) {
            return true;
        } 

        return false;
    }
    public function passwordsMatch ($password, $passwordRepeat) {
        if ($password === $passwordRepeat) {
            return true;
        }

        return false;
    }
    public function passwordsIsTooShort ($password, $passwordRepeat) {
        if (strlen($password) < 6 && strlen($passwordRepeat) < 6) {
            return true;
        }

        return false;
    }
}
