<?php require_once("db_connection.php");?>
<?php

	function storeUser($username, $email, $password){
		global $connection;
		
		$query = "INSERT INTO users(";
		$query .= "username, email, password) ";
		$query .= "VALUES('{$username}', '{$email}','{$password}')";

		$result = mysqli_query($connection, $query);

		if($result){
			$user = "SELECT * FROM users WHERE email = '{$email}'";
			$res = mysqli_query($connection, $user);

			while ($user = mysqli_fetch_assoc($res)){
				return $user;
			}
		}else{
				return false;
			}

	}


	function getUserByEmailAndPassword($email, $password){
		global $connection;
		$query = "SELECT * FROM `manage_std` WHERE `id_std` = '{$email}' and `password_std` = '{$password}' AND IsUse = 1;";
	
		$user = mysqli_query($connection, $query);
		
		if($user){
			while ($res = mysqli_fetch_assoc($user)){
				return $res;
			}
		}
		else{
			return false;
		}
	}


	function emailExists($email){
		global $connection;
		$query = "SELECT `id_std` FROM `manage_std` WHERE `id_std` = '{$email}' AND IsUse = 1;";

		$result = mysqli_query($connection, $query);

		if(mysqli_num_rows($result) > 0){
			return true;
		}else{
			return false;
		}
	}

?>