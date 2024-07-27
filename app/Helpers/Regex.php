<?php
namespace App\Helpers;
use Dotenv\Util\Regex;

class RegexValidation {
    public static function isUsernameValid($username){
        return Regex::matches("^[a-zA-Z0-9]+$", $username);
    }
}
