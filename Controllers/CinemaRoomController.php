<?php

    namespace Controllers;

    use DAO\CinemaRoomDAO as CinemaRoomDAO;
	use Models\CinemaRoom as CinemaRoom;
	use Models\Cinema as Cinema;
	use Models\Show as Show;
	use Controllers\UserController as UserController;   

    class CinemaRoomController {
		
		private $cinemaRoomDAO;			

        public function __construct() {
            $this->cinemaRoomDAO = new CinemaRoomDAO();
		}			

        public function add($id_cinema, $name, $capacity, $price) {
			if($this->validateCinemaRoomForm($id_cinema, $name, $capacity, $price)) {
				$cinemaRoom = new CinemaRoom();            
				$cinemaRoom->setName($name);
				if($this->cinemaRoomDAO->checkNameInCinema($name, $id_cinema) == NULL) {
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setName($name);
					$cinemaRoom->setCapacity($capacity);
					$cinemaRoom->setPrice($price);

					$cinema = new Cinema();
					$cinema->setId($id_cinema);

					$cinemaRoom->setCinema($cinema);

					$this->cinemaRoomDAO->add($cinemaRoom);
					return $this->addCinemaRoomPath(CINEMA_ROOM_ADDED, NULL);
				}
				return $this->addCinemaRoomPath(NULL, CINEMA_ROOM_EXIST);
			}
			return $this->addCinemaRoomPath(NULL, EMPTY_FIELDS);
		}
		
        private function validateCinemaRoomForm($id_cinema, $name, $capacity, $price) {
            if(empty($id_cinema) || empty($name) || empty($capacity) || empty($price)) {
                return FALSE;
            }
            return TRUE;
        }		

        public function addCinemaRoomPath($success = "", $alert = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {

					$cinemaController = new CinemaController();
					$cinemas = $cinemaController->getAllCinemas();

					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-room-add.php");
				}				
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
        }

		public function listCinemaRoomPath($success = "", $alert = "", $cinemaId = "") {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];								
				if($admin->getRole() == 1) {
					
					$cinemasRooms = $this->cinemaRoomDAO->getAll();

					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-room-list.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
        }

		public function remove($id) {				
			if($this->cinemaRoomHasShows($id)) {								
				return $this->listCinemaRoomPath(NULL, CINEMA_ROOM_HAS_SHOWS, $id);
			} else {								
				$cinemaRoom = new CinemaRoom();
				$cinemaRoom->setId($id);
				
				$this->cinemaRoomDAO->deleteById($cinemaRoom);
				return $this->listCinemaRoomPath(CINEMA_ROOM_REMOVE, NULL, NULL);
			}
		}

		public function forceDelete($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			$this->cinemaRoomDAO->deleteById($cinemaRoom);
			return $this->listCinemaRoomPath(CINEMA_ROOM_REMOVE, NULL, NULL);
		}

		private function cinemaRoomHasShows($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			return ($this->cinemaRoomDAO->getShowsOfCinemaRoom($cinemaRoom)) ? TRUE : FALSE;
		}

		public function modifyById($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);
			$cinemaRoom = $this->cinemaRoomDAO->getById($cinemaRoom);
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-modify.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
		}

		public function modify($id, $name, $capacity, $price) {			
			$cinemaRoom = new CinemaRoom();
            $cinemaRoom->setName($name);
            $cinemaRoom->setCapacity($capacity);
            $cinemaRoom->setPrice($price);
	        $this->cinemaRoomDAO->modify($cinemaRoom);
            return $this->listCinemaRoomPath(CINEMA_ROOM_MODIFY);
        }

		public function getCinemaRoomByShowId($id_show) {
			$show = new Show();
			$show->setId($id_show);

			return $this->cinemaRoomDAO->getByIdShow($show);
		}
		
		public function sales() {
			if (isset($_SESSION["loggedUser"])) {
				$admin = $_SESSION["loggedUser"];
				if($admin->getRole() == 1) {
					
					$rooms = $this->cinemaRoomDAO->getAll();
					
					require_once(VIEWS_PATH . "admin-head.php");
					require_once(VIEWS_PATH . "admin-header.php");
					require_once(VIEWS_PATH . "admin-cinema-room-sales.php");
				}
			} else {
                $userController = new UserController();
                return $userController->userPath();
            }
		}
		
		public function getAllCinemaRooms() {
			return $this->cinemaRoomDAO->getAll();
		}

		public function getCinemaRoomById($id) {
			$cinemaRoom = new CinemaRoom();
			$cinemaRoom->setId($id);

			return $this->cinemaRoomDAO->getById($cinemaRoom);
		}
    }

 ?>
