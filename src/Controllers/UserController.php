<?php
declare(strict_types=1);
namespace Controllers;

use Models\UserModel;
use Database\UserDAO;
use Exception;

class UserController
{
    private UserModel $userModel;
    private UserDAO $userDAO;

    public function Login(UserModel $userModel, UserDAO $userDAO, array $DataLoginFromPost) : void {
        $this->userModel = $userModel;
        $this->userDAO = $userDAO;

        if(!empty($DataLoginFromPost['username']) && !empty($DataLoginFromPost['password'])){
            if(!$this->userDAO->existsUsernameDatabase($DataLoginFromPost['username'])){
                $_SESSION['username-error'] = 'Usuário não encontrado';
                throw new Exception('Usuário não encontrado');
            }

            if(!$this->userDAO->verifyUserPassword($DataLoginFromPost['password'], $DataLoginFromPost['username'])){
                $_SESSION['password-error'] = 'Senha incorreta';
                throw new Exception('Senha incorreta');
            }

            $UserID = $this->userDAO->getUserIdByUsername($DataLoginFromPost['username']);

            if($UserID == null){
                echo 'Não foi possível carregar seus dados. Por favor, tente novamente.';
                return;
            }

            $_SESSION['user-username'] = $DataLoginFromPost['username'];
            $_SESSION['user-id'] = $UserID;

            header('Location: panel.php');
            exit();
        }
    }

    public function Create() : void{
        //sem create pois só vai existir um usuário
    }

    public function Read(UserDAO $UserDAO) : void{
        $this->userDAO = $UserDAO;
        $UserData = $this->userDAO->getAllUserDataById((int)$_SESSION['user-id']);

        if($UserData == null){
            echo 'Não foi possível carregar seus dados. Por favor, tente novamente.';
            return;
        }

        echo '
            <section class="p-3" id="update-user">
                <form method="POST" class="form poppins-regular">

                    <div class="form-group">
                        <label for="about">Sobre mim</label>
                        <textarea class="form-control" spellcheck="true" name="about" id="about" rows="4">'.$UserData['about'].'</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="studying">Estudando</label>
                        <textarea class="form-control" spellcheck="true" name="studying" id="studying" rows="2">'.$UserData['studying'].'</textarea>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input value="'.$UserData['email'].'" type="email" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group">
                        <label for="username">Usuário</label>
                        <input value="'.$UserData['username'].'" type="text" class="form-control" name="username" id="username">
                    </div>

                    <details class="p-2">
                        <summary class="text-center pt-1">
                            <h3 class="d-inline ubuntu-regular">Redes<h2>
                        </summary>

                        <div class="form-group px-2">
                            <label for="whatsapp">Whatsapp</label>
                            <input value="'.$UserData['numberWhatsapp'].'" class="form-control" name="whatsapp" id="whatsapp">
                        </div>

                        <div class="form-group px-2">
                            <label for="instagram">Usuário Instagram</label>
                            <input value="'.$UserData['userInstagram'].'" class="form-control" name="user-instagram" id="user-instagram">
                        </div>

                        <div class="form-group px-2">
                            <label for="x">Usuário X</label>
                            <input value="'.$UserData['userX'].'" class="form-control" name="user-x" id="user-x">
                        </div>

                        <div class="form-group px-2">
                            <label for="github"> Usuário Github</label>
                            <input value="'.$UserData['userGithub'].'" class="form-control" name="user-github" id="user-github">
                        </div>
                    </details>

                    <div class="form-group">
                        <label for="password" class="danger-label">Confirme a sua senha</label>
                        <input required type="password" class="form-control danger-input" name="passwordConfirmation" id="passwordConfirmation">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary mt-1 poppins-bold w-100">Atualizar</button>
                </form>
            </section>
        ';
    }

    public function ReadAboutMe(UserDAO $userDAO) : void{
        $this->userDAO = $userDAO;
        if(!$UserData = $this->userDAO->getAllUserDataById(1)){
            throw new Exception("Erro ao carregar sobre mim");
        }

        echo "
        <section class=\"p-3 text-center\" id=\"about-me\">
            <div>
                <img id=\"logo\" src=\"public/assets/images/logo.jpg\">
                <h2 class=\"ubuntu-bold mb-0\">Arthur Vieira</h2>
                <small class=\"ubuntu-regular m-0 green\"><i class=\"pulse fa-solid fa-circle fa-xs mr-2\"></i>Disponível para trabalho</small>
            </div>
            <p class=\"poppins-regular mt-1\">$UserData[about]</p>
        </section>
           <hr>
           <section class=\"p-3 text-center\" id=\"status\">
                    <a class=\"d-inline-block btn btn-primary poppins-bold w-100\" href=\"public/assets/files/curriculo.pdf\" download><i class=\"fa-solid fa-download mr-2\"></i>Currículo</a>
           </section>
            <hr>
        <section class=\"p-3 d-flex justify-content-around\" id=\"contact\">
            <a href=\"mailto:".$UserData['email']."\"><i class=\"fa-solid fa-envelope fa-lg\"></i></a>
            <a href=\"https://wa.me/".$UserData['numberWhatsapp']."\"><i class=\"fa-brands fa-whatsapp fa-xl\"></i></a>
            <a href=\"https://www.instagram.com/".$UserData['userInstagram']."\"><i class=\"fa-brands fa-instagram fa-xl\"></i></a>
            <a href=\"https://twitter.com/".$UserData['userX']."\"><i class=\"fa-brands fa-x-twitter fa-lg\"></i></a>
            <a href=\"https://github.com/".$UserData['userGithub']."\"><i class=\"fa-brands fa-github fa-xl\"></i></a>
        </section>
           <hr>
        ";

    }

    public function Update(UserModel $UserModel, UserDAO $UserDAO, array $DataUpdateFromPost) : void{
        $this->userModel = $UserModel;
        $this->userDAO = $UserDAO;

        if(!empty($DataUpdateFromPost)){
            //só vai existir um usuário então não verifico se o parametro já existe no banco de dados

            if(!$this->userModel->AuthEmail($DataUpdateFromPost['email'])){
                throw new Exception('E-mail inválido');
            }

            if(!$this->userModel->AuthLength($DataUpdateFromPost['about'], 250)){
                throw new Exception('Sobre mim muito grande (maximo 250 caracteres)');
            }

            if(!$this->userModel->AuthLength($DataUpdateFromPost['studying'], 250)){
                throw new Exception('Estudando muito grande (máximo 250 caracteres)');
            }

            if(!$this->userModel->AuthLength($DataUpdateFromPost['username'], 20)){
                throw new Exception('Username muito grande (máximo 20 caracteres)');
            }

            $passwordConfirmation = $DataUpdateFromPost['passwordConfirmation'];
            $passwordHash = $this->userDAO->getUserPasswordByID((int)$_SESSION['user-id']);

            if(!password_verify($passwordConfirmation, $passwordHash)){
                throw new Exception('Senha incorreta.');
            }

            if(!$this->userDAO->updateUserData($DataUpdateFromPost, (int)$_SESSION['user-id'])){
                throw new Exception('Erro ao atualizar dados, tente novamente.');
            }

            $_SESSION['update-success'] = true;

            header('Location: updateUser.php');
            exit();
        }
    }

    public function Delete() : void{
        //sem delete pois o único usuário nunca será excluido
    }
}