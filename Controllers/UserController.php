<?php

    namespace Controllers;

    use DAO\UserDAO as UserDAO;
    use Models\User as User;
    use Controllers\HomeController as HomeController;
    use Controllers\MovieController as MovieController;

    class UserController
    {
        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }

        public function validateRegister ($firstName, $lastName, $dni, $mail, $password) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setDni($dni);
            $user->setMail($mail);
            $user->setPassword($password);
            $user->setRole(0);
            $this->userDAO->add($user);
            $_SESSION["loggedUser"] = $user;
            $this->userPath();
        }

        public function validateLogin ($mail, $password) {
            $users = $this->userDAO->getAll();
            foreach ($users as $user) {
                if ($user->getMail() == $mail && $user->getPassword() == $password) {
                    $_SESSION["loggedUser"] = $user;
                    if ($user->getRole() == 1) {
                        $this->adminPath();
                    }
                    else if ($user->getRole() == 0) {
                        $this->userPath();
                    }
                }
            }
        }

        public function adminPath () {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				require_once(VIEWS_PATH . "admin-head.php");
				require_once(VIEWS_PATH . "admin-header.php");
				require_once(VIEWS_PATH . "admin-dashboard.php");
			}
        }

        public function userPath () {
			$movieController = new MovieController();
			$movies = $movieController->showMoviesNowPlaying();
			$title = 'Now Playing';
			$img = IMG_PATH . '/w4.png';
			require_once(VIEWS_PATH . "header.php");
			require_once(VIEWS_PATH . "navbar.php");
			require_once(VIEWS_PATH . "header-s.php");
			require_once(VIEWS_PATH . "now-playing.php");
			require_once(VIEWS_PATH . "footer.php");
        }

        public function loginPath () {
			$title = "MoviePass — Login";
            $img = IMG_PATH . "w5.png";
			require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "navbar.php");
            require_once(VIEWS_PATH . "login.php");			
        }

        public function registerPath () {
			$title = 'MoviePass — Register';
            $img = IMG_PATH . '/w4.png';
            require_once(VIEWS_PATH . "header.php");
            require_once(VIEWS_PATH . "navbar.php");
            require_once(VIEWS_PATH . "register.php");			

        }

        public function logoutPath () {
            session_destroy();
            $_SESSION["loggedUser"] = null;
			$this->userPath();
        }

    }

 ?>
