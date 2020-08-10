<?php 

	Class Model{
		private $server = 'localhost';
		private $username = 'root';
		private $password = '';
		private $db = 'record';
		private $conn;

		public function __construct(){
			try {
				$this->conn = new mysqli($this->server, $this->username, $this->password, $this->db);
			} catch (Exception $e) {
				echo "Connection error " . $e->getMessage();
			}
		}

		public function insert($name, $email){
			$query = "INSERT INTO record (`name`, `email`) VALUES ('$name', '$email')";
			if ($sql = $this->conn->query($query)) {
				return true;
			}else{
				return;
			}
		}

		public function fetch(){
			$data = [];

			$query = "SELECT * FROM record";

			if ($sql = $this->conn->query($query)) {
				while ($rows = mysqli_fetch_assoc($sql)) {
					$data[] = $rows;
				}
			}

			return $data;
		}

		public function delete($id){
			$query = "DELETE FROM record WHERE `id` = '$id'";
			if ($sql = $this->conn->query($query)) {
				return true;
			}else{
				return;
			}
		}

		public function edit($id){
			$data = [];

			$query = "SELECT * FROM record WHERE `id` = '$id'";
			if ($sql = $this->conn->query($query)) {
				$row = mysqli_fetch_row($sql);
				$data = $row;
			}

			return $data;
		}

		public function update($id, $name, $email){
			$query = "UPDATE record SET `name` = '$name', `email` = '$email' WHERE `id` = '$id'";
			if ($sql = $this->conn->query($query)) {
				return true;
			}else{
				return;
			}
		}
	}

 ?>