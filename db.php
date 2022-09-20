<?php 
/*
// Connect to databas
*/

// DATABASE SETTINGS
define("DB_HOST" , 'localhost');
define("DB_NAME" , 'membership');
define("DB_USER" , 'root');
define("DB_PASS" , '');
define("DB_CHARSET" , 'utf8');


class DB{
	protected $pdo = null;

	public function __construct(){

		try {
		  $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME , DB_USER, DB_PASS);
		  // set the PDO error mode to exception
		  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION  );
		  $this->pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
		} catch(PDOException $e) {
		  echo "Connection failed: " . $e->getMessage();
		}

	}

	// Close db connection
	public function __destruct(){
		if($this->pdo !== null){
			$this->pdo = null;
		}
	}

}

session_start();