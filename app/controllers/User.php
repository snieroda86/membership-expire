<?php 
// User class
require_once( $_SERVER['DOCUMENT_ROOT'].'/membership/db.php');
class User extends DB{


	public function verify_email($email ){
		$sql = "SELECT * FROM users WHERE email=:email";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':email' => $email
		]);

		$count = $stmt->rowCount();

		return $count;
	}

	public function verify_login($login ){
		$sql = "SELECT * FROM users WHERE login=:login";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':login' => $login
		]);

		$count = $stmt->rowCount();

		return $count;
	}

	public function verify_password($password , $confirm_password ){
		
		if($password == $confirm_password ){
			return true;	
		}else{
			return false;
		}
		
	}

	public function getUserByLogin($login){
		$sql = "SELECT * FROM users WHERE login=:login";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':login' => $login
		]);

		$user = $stmt->fetch();

		return $user;
	}

	public function store($name , $surname , $login , $password , $email , $plan , $expire_date ){
		$sql = "INSERT INTO users(name , surname , login , password , email , plan , expire_date) 
		VALUES(:name , :surname , :login , :password , :email , :plan , :expire_date )";

		$stmt= $this->pdo->prepare($sql);
		$stmt->execute([
			':name' => $name ,
			':surname' => $surname , 
			':login' => $login , 
			':password' => $password , 
			':email' => $email , 
			':plan' => $plan , 
			':expire_date' => $expire_date , 			

		]);
	}


	public function getExpireDate($user_id ){
		$sql = "SELECT  expire_date FROM users WHERE id=:id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute([
			':id' => $user_id
		]);

		$user = $stmt->fetch();
		$expire_date = $user['expire_date'];
		return $expire_date;

	}

	// Check account expiry
	
}