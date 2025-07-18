<?php
declare(strict_types=1);
namespace Models;

use Traits\AuthInputs;

class UserModel
{
    private int $id;
    private string $username;
    private string $password;
    private string $passwordConfirmation;
    private string $email;
    private string $about;
    private string $studying;
    private string $numberWhatsapp;
    private string $userInstagram;
    private string $userX;
    private string $userGithub;

    use AuthInputs;

    public function getDataLoginFromPost() : array {
        if(isset($_POST['submit'])){
            $this->username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $this->password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $this->username = htmlspecialchars($this->username);
            $this->password = htmlspecialchars($this->password);

            return array("username" => $this->username, "password" => $this->password);
        }
        return [];
    }

    public function getDataUpdateFromPost() : array {
        if(isset($_POST['submit'])){
            $this->passwordConfirmation = filter_input(INPUT_POST, 'passwordConfirmation', FILTER_SANITIZE_STRING);
            $this->about= filter_input(INPUT_POST, 'about', FILTER_SANITIZE_STRING);
            $this->studying = filter_input(INPUT_POST, 'studying', FILTER_SANITIZE_STRING);
            $this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
            $this->username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $this->numberWhatsapp = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_STRING);
            $this->userInstagram = filter_input(INPUT_POST, 'user-instagram', FILTER_SANITIZE_STRING);
            $this->userX = filter_input(INPUT_POST, 'user-instagram', FILTER_SANITIZE_STRING);
            $this->userGithub = filter_input(INPUT_POST, 'user-github', FILTER_SANITIZE_STRING);

            $data = [
                'passwordConfirmation' => $this->passwordConfirmation,
                'about' => $this->about,
                'studying' => $this->studying,
                'email' => $this->email,
                'username' => $this->username,
                'whatsapp' => $this->numberWhatsapp,
                'userInstagram' => $this->userInstagram,
                'userX' => $this->userX,
                'userGithub' => $this->userGithub,
            ];

            foreach ($data as $key => $value) {
                $data[$key] = htmlspecialchars($value);
            }

            return $data;
        }
        return [];
    }
}