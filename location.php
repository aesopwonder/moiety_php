<?
require "conn.php";

$username =$_POST["username"];
$location =$_POST["location"];
	$stmt = $conn->prepare("UPDATE user_info SET location=? WHERE username=?");
    $stmt->bind_param('ss', $location, $username);
    $stmt->execute();
    $stmt->close();
	echo 0;
/* close connection */
$conn->close();


?>