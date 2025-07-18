<?php
declare(strict_types=1);
namespace Traits;

trait AuthInputs {
    public function AuthEmail(string $email) : bool {
        $sanitizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

        if(filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

    public function AuthLength(string $input, int $maxLength) : bool {
        $bool = mb_strlen($input) > $maxLength ? false : true;
        return $bool;
    }
}
