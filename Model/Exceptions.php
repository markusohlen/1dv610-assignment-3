<?php

namespace model;

// Register
class PasswordsDoNotMatchException extends \Exception {}

class PasswordsTooShortException extends \Exception {}

class UserAlreadyExistsException extends \Exception {}

class UsernameTooShortException extends \Exception {}

// Login
class MissingUsernameException extends \Exception {}

class MissingPasswordException extends \Exception {}

class InvalidCredentialsException extends \Exception {}