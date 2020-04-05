<?php session_start();

$host = "localhost";
$user = "alf";
$pwd = "informatica242102";
$db = "birthday";
$charset = "utf8";

$dsn = "mysql:host=$host;dbname=$db; charset=$charset";
$opt = [
    PDO:: ATTR_ERRMODE                => PDO::ERRMODE_EXCEPTION,
    PDO:: ATTR_DEFAULT_FETCH_MODE     => PDO::FETCH_ASSOC,
    PDO:: ATTR_EMULATE_PREPARES       => false,
]; 


try {
  $pdo = new PDO($dsn, $user, $pwd, $opt);
} 
catch(PDOException $e) {
  echo $e->getMessage();
}

/*  ТАК НЕ БЕЗОПАСНО:
try {

  $db = new PDO("mysql:host=$host; dbname=$db", $user, $pwd);
  $db->setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
  $db-> exec("set names utf8");  
} 
catch(PDOException $e) {
  echo $e->getMessage();
}
*/


// Класс для соединения с Бд, используя MySQLi. Нужен для функционала записи в БД Editval, column - AJAX
// переменных с координатами ячеек HTML-таблицы

class DBController {
	private $host = "localhost";
	private $user = "alf";
	private $password = "informatica242102";
	private $database = "birthday";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
	function executeUpdate($query) {
        $result = mysqli_query($this->conn,$query);        
		return $result;		
    }
}
?>
