<?
require "conn.php";
$message_id=$_POST["message_id"];
$username =$_POST["username"];

	$stmt3 = $conn->prepare("SELECT user_name_1 FROM messaging WHERE message_id=?");
	$stmt3->bind_param("s", $message_id);
    $stmt3->execute();
    $stmt3->bind_result($username_1);
    $stmt3->fetch();
    $stmt3->close();
    
	if (strcmp($username, $username_1) == 0) {//Username 1
	$stmt = $conn->prepare("SELECT notification_1 FROM messaging WHERE message_id=?");
    $stmt->bind_param("s", $message_id);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    
	echo $result;
	
	$notification=0;//reset notification

	$stmt2 = $conn->prepare("UPDATE messaging SET notification_1=? WHERE message_id=?");
    $stmt2->bind_param("ss",$notification,$message_id);
    $stmt2->execute();
    $stmt2->fetch();
    $stmt2->close();
	}
	
	else{//Username 2
	$stmt4 = $conn->prepare("SELECT notification_2 FROM messaging WHERE message_id=?");
    $stmt4->bind_param("s", $message_id);
    $stmt4->execute();
    $stmt4->bind_result($result2);
    $stmt4->fetch();
    $stmt4->close();
    
	echo $result2;
	
	$notification2=0;//reset notification

	$stmt5 = $conn->prepare("UPDATE messaging SET notification_2=? WHERE message_id=?");
    $stmt5->bind_param("ss",$notification2,$message_id);
    $stmt5->execute();
    $stmt5->fetch();
    $stmt5->close();
	}
	

$conn->close();