<?php

namespace model;

// Register
class PasswordsDoNotMatchException extends \Exception {}

class PasswordTooShortException extends \Exception {}

class UserAlreadyExistsException extends \Exception {}

class UsernameTooShortException extends \Exception {}

class MissingAllCredentialsException extends \Exception {}

class InvalidCharactersException extends \Exception {}

// Login
class MissingUsernameException extends \Exception {}

class MissingPasswordException extends \Exception {}

class InvalidCredentialsException extends \Exception {}

// Calendar
class TitleTooShortException extends \Exception {}

class NoteTooShortException extends \Exception {}

class NoteNotFoundException extends \Exception {}