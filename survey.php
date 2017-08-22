<?
require "conn.php";

$username = $_POST["username"];

	$stmt = $conn->prepare("SELECT survey FROM user_info WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($active);
    while ($stmt->fetch()) {
    	echo $active;
    }
    $stmt->close();

/* close connection */
$conn->close();


?>