<?php 
header('X-Powered-By: AACANET'); 
define('TITLE', 'American Alliance of Creditor Attorneys Inc');
date_default_timezone_set('Asia/Kolkata');
// $hostname = 'localhost';
// $username = 'bidev';
// $password = 'Aaca@123#';
// $database = 'aaca_live';
$hostname = '192.168.13.101';
$username = 'phpmyadmin';
$password = 'b@dcr3dit';
$database = 'aaca_backup';
$conn = mysqli_connect($hostname,$username,$password,$database);
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}

	/*$expiry = 900 ;//session expiry required after 15 mins
    if (isset($_SESSION['LAST']) && (time() - $_SESSION['LAST'] > $expiry)) {
        session_unset();
        session_destroy();
	
	      header('Location: http://192.168.13.167/bi/');
    }
    $_SESSION['LAST'] = time();*/


?>
