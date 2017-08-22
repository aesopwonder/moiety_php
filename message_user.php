<?
require "conn.php";

$username =$_POST["username"];
if ($stmt = $conn->prepare("SELECT messaged_users
    FROM user_info WHERE username=?")) {
    $stmt->bind_param('s', $username);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $stmt->bind_result($messaged_users);
    $stmt->fetch();
    $stmt->close();
    }
$updated_messaged_users =$messaged_users.",".$_POST["user_count"];
	
	$stmt = $conn->prepare("UPDATE user_info SET messaged_users=? WHERE username=?");
    $stmt->bind_param("ss", $updated_messaged_users, $username);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    echo 0;
    $stmt->close();

/* close connection */
$conn->close();


?>