<?php

namespace model;

class PasswordsDoNotMatchException extends \Exception {}

class PasswordsTooShortException extends \Exception {}

class UserAlreadyExistsException extends \Exception {}

class UsernameTooShortException extends \Exception {}