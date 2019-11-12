<?php

    namespace DAO;

	use \Exception as Exception;
	use DAO\Connection as Connection;
    use Models\Cinema as Cinema;

    class CinemaDAO {

        private $cinemaList = array();
		private $connection;
		private $tableName = "cinemas";

        public function add(Cinema $cinema) {
			try {
				$query = "INSERT INTO " . $this->tableName . " (name, capacity, address, ticket_value) VALUES (:name, :capacity, :address, :ticket_value);";
				$parameters["name"] = $cinema->getName();
				$parameters["address"] = $cinema->getAddress();
				$parameters["capacity"] = $cinema->getCapacity();
				$parameters["ticket_value"] = $cinema->getPrice();
                $this->connection = Connection::getInstance();
				$this->connection->executeNonQuery($query, $parameters);
			}
			catch (Exception $e) {
				throw $e;
			}
        }

        public function getAll() {
			try {								
				$query = "CALL cinemas_GetAll()";
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, array(), QueryType::StoredProcedure);
				foreach($results as $row) {
					$cinema = new Cinema();
					$cinema->setId($row["id"]);
					$cinema->setName($row["name"]);
					$cinema->setAddress($row["address"]);
					$cinema->setCapacity($row["capacity"]);
					$cinema->setPrice($row["ticket_value"]);
					array_push ($this->cinemaList, $cinema);
				}				
				return $this->cinemaList;
			}
			catch(Exception $e) {
				throw $e;
			}
		}

		public function deleteById($id) {
			try {
				$query = "CALL cinemas_deleteById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function getById($id) {
			try {
				$query = "CALL cinemas_getById(?)";
				$parameters ["id"] = $id;
				$this->connection = Connection::GetInstance();
				$results = $this->connection->Execute($query, $parameters, QueryType::StoredProcedure);
				var_dump($results);
				$cinema = new Cinema();
				foreach($results as $row) {
					$cinema->setId($row["id"]);
					$cinema->setName($row["name"]);
					$cinema->setAddress($row["address"]);
					$cinema->setCapacity($row["capacity"]);
					$cinema->setPrice($row["ticket_value"]);
				}
				return $cinema;
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		public function modify(Cinema $cinema) {
			try {
				$query = "CALL cinemas_modify(?, ?, ?, ?, ?)";
				$parameters["id"] = $cinema->getId();
				$parameters["name"] = $cinema->getName();
				$parameters["capacity"] = $cinema->getCapacity();
				$parameters["address"] = $cinema->getAddress();
				$parameters["ticket_value"] = $cinema->getPrice();
				$this->connection = Connection::getInstance();
				$this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
			}
			catch (Exception $e) {
				throw $e;
			}
		}

		//
		public function getByName(Cinema $cinema) {
			try {								
				$query = "CALL cinemas_getByName(?)";
				$parameters["name"] = $cinema->getName();
				$this->connection = Connection::GetInstance();
				$results = $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);				

				return $results;
			}
			catch (Exception $e) {
				throw $e;
			}			
		}

    }

 ?>
