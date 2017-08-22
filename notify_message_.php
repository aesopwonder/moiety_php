<?
require "conn.php";
$message_id=$_POST["message_id"];
	$stmt = $conn->prepare("SELECT message_id FROM messaging WHERE message_id=?");
    $stmt->bind_param("s", $message_id);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
	$rows=$stmt->num_rows;
	if($rows>0){
		echo 0;
	}
$conn->close();