<?php

    namespace DAO;

	use \Exception as Exception;
    use Models\Show as Show;
    use Models\Movie as Movie;
	use Models\Cinema as Cinema;
	use Models\CinemaRoom as CinemaRoom;
	use DAO\IShowDAO as IShowDAO;
	use DAO\MovieDAO as MovieDAO;
	use DAO\QueryType as QueryType;
	use DAO\Connection as Connection;

    class ShowDAO implements IShowDAO {

        private $showList = array();
        private $moviesOnShowList = array();
		private $tableName = "shows";
		private $movieDAO;
		private $connection;

		public function __construct () {
			$this->movieDAO = new MovieDAO();
		}

        public function add(Show $show) {
			try {							
				$query = "CALL shows_add(?, ?, ?, ?, ?, ?)";
				$parameters["FK_id_cinemaRoom"] = $show->getCinemaRoom()->getId();
				$parameters["FK_id_movie"] = $show->getMovie()->getId();
				$parameters["date_start"] = $show->getDateStart();
				$parameters["time_start"] = $show->getTimeStart();
				$parameters["date_end"] = $show->getDateEnd();
				$parameters["time_end"] = $show->getTimeEnd();
				$this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters, QueryType::StoredProcedure);	
				return true;			
			}
			catch (Exception $e) {
				return false;
			}
        }
		
		public function getByMovieId(Show $show) {
			try {
				$query = "CALL shows_getByMovieId (?)";
				$parameters ["id_movie"] = $show->getMovie()->getId();
				$this->connection = Connection::GetInstance();
				return $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function getByCinemaRoomId(Show $show) {
			try {
				$query = "CALL shows_getByCinemaRoomId (?)";
				$parameters ["id_cinemaRoom"] = $show->getCinemaRoom()->getId();
				$this->connection = Connection::GetInstance();
				return $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				return false;
			}
		}

        public function getAll() {
			try {
				$query = "CALL shows_getAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach ($results as $row) {									
					$movie = new Movie();
					$movie->setId($row["movies_id"]);
					$movie->setTitle($row["movies_title"]);
	
					$cinema = new Cinema();
					$cinema->setId($row["cinema_id"]);
					$cinema->setName($row["cinema_name"]);
					
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setId($row["cinema_rooms_id"]);
					$cinemaRoom->setName($row["cinema_rooms_name"]);	
					$cinemaRoom->setCinema($cinema);
					
					$show = new Show();
					$show->setId($row["shows_id"]);
					$show->setDateStart($row["shows_date_start"]);
					$show->setTimeStart($row["shows_time_start"]);
					$show->setDateEnd($row["shows_date_end"]);
					$show->setTimeEnd($row["shows_time_end"]);
					$show->setMovie($movie);
					$show->setCinemaRoom($cinemaRoom);
					$show->setIsActive($row["shows_is_active"]);
					array_push ($this->showList, $show);
				}
				return $this->showList;	
			} catch (Exception $e) {
				return false;
			}
		}

        public function getAllActives() {
			try {
				$query = "CALL shows_getAllActives()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach ($results as $row) {									
					$movie = new Movie();
					$movie->setId($row["movies_id"]);
					$movie->setTitle($row["movies_title"]);
	
					$cinema = new Cinema();
					$cinema->setId($row["cinema_id"]);
					$cinema->setName($row["cinema_name"]);
					
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setId($row["cinema_rooms_id"]);
					$cinemaRoom->setName($row["cinema_rooms_name"]);	
					$cinemaRoom->setCinema($cinema);
					
					$show = new Show();
					$show->setId($row["shows_id"]);
					$show->setDateStart($row["shows_date_start"]);
					$show->setTimeStart($row["shows_time_start"]);
					$show->setDateEnd($row["shows_date_end"]);
					$show->setTimeEnd($row["shows_time_end"]);
					$show->setMovie($movie);
					$show->setCinemaRoom($cinemaRoom);
					$show->setIsActive($row["shows_is_active"]);
					array_push ($this->showList, $show);
				}
				return $this->showList;	
			} catch (Exception $e) {
				return false;
			}
		}		
				
		public function enableById(Show $show) {
			try {
				$query = "CALL shows_enableById(?)";
				$parameters ["id"] = $show->getId();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function disableById(Show $show) {
			try {
				$query = "CALL shows_disableById(?)";
				$parameters ["id"] = $show->getId();
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}
						
		public function getById(Show $show) {
			try {
				$query = "CALL shows_getById(?)";
				$parameters ["id"] = $show->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);			

				foreach ($results as $row) {
					$show = new Show();
					
					$movie = new Movie ();
					$movie->setId($row["movies_id"]);
					$movie->setTitle($row["movies_title"]);
					$movie->setBackdropPath($row["movies_backdrop_path"]);

					$cinema = new Cinema();
					$cinema->setName($row["cinema_name"]);	
					$cinema->setAddress($row["cinema_address"]);

					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setId($row["cinema_rooms_id"]);
					$cinemaRoom->setName($row["cinema_rooms_name"]);
					$cinemaRoom->setCapacity($row["cinema_rooms_capacity"]);
					$cinemaRoom->setPrice($row["cinema_rooms_price"]);
					$cinemaRoom->setCinema($cinema);

					$show->setId($row["shows_id"]);
					$show->setDateStart($row["shows_date_start"]);
					$show->setTimeStart($row["shows_time_start"]);
					$show->setDateEnd($row["shows_date_end"]);
					$show->setTimeEnd($row["shows_time_end"]);
					$show->setIsActive($row["shows_is_active"]);
					
					$show->setMovie($movie);
					$show->setCinemaRoom($cinemaRoom);
				}
				return $show;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function modify(Show $show) {
			try {
				$query = "CALL shows_modify(?, ?, ?, ?, ?, ?, ?)";
				$parameters["id"] = $show->getId();
				$parameters["id_cinemaRoom"] = $show->getCinemaRoom()->getId();
				$parameters["id_movie"] = $show->getMovie()->getId();
				$this->timeCheck($show);
				$parameters["date_start"] = $show->getDateStart();
				$parameters["time_start"] = $show->getTimeStart();
				$parameters["date_end"] = $show->getDateEnd();
				$parameters["time_end"] = $show->getTimeEnd();
				$this->connection = Connection::getInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
				return true;
			}
			catch (Exception $e) {
				return false;
			}
		}

		public function moviesOnShow() {
			$this->getAllActives();
			foreach ($this->showList as $show) {
				$id = $show->getMovie()->getId();
				if($this->getMoviesIdWithoutRepeating($id)) {
					$movieAux = new Movie();
					$movieAux->setId($id);
					$movie = $this->movieDAO->getById($movieAux);
					array_push($this->moviesOnShowList, $movie);
				}
			}
			return $this->moviesOnShowList;
		}
		
		public function getMoviesIdWithoutRepeating($id) {
			if (count ($this->moviesOnShowList) == 0) {
				return 1;
			}
			else {
				foreach ($this->moviesOnShowList as $movie) {
					if ($movie->getId() == $id) {
						return 0;
					}
				}
				return 1;
			}
		}
		
		public function getShowsOfMovie(Movie $movie) {
			$shows = array();
			try {
				$query = "CALL shows_getShowsOfMovie(?)";
				$parameters["id_movie"] = $movie->getId();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				foreach ($results as $row) {
					$show = new Show();
					$cinema = new Cinema();
					$cinema->setName($row["cinema_name"]);	
					$cinema->setAddress($row["cinema_address"]);
					$cinemaRoom = new CinemaRoom();
					$cinemaRoom->setName($row["cinema_rooms_name"]);
					$cinemaRoom->setCinema($cinema);
					$show->setId($row["show_id"]);
					$show->setDateStart($row["show_date_start"]);
					$show->setTimeStart($row["show_time_start"]); 					
					$show->setCinemaRoom($cinemaRoom);					
					array_push($shows, $show);
				}
				return $shows;
			}
			catch (Exception $e) {
				return false;
			}
		}

	}

 ?>
