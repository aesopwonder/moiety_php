<?
require "conn.php";
$message_id="17";
$username = "amnguyen1";

	$stmt5 = $conn->prepare("SELECT user_name_1 FROM messaging WHERE message_id=?");
	$stmt5->bind_param("s", $message_id);
    $stmt5->execute();
    $stmt5->bind_result($username_1);
    $stmt5->fetch();
    $stmt5->close();
    
	if (strcmp($username, $username_1) == 0) {//Username 1, notify the other party
	$notification="1";

	$stmt6 = $conn->prepare("UPDATE messaging SET notification_2=? WHERE message_id=?");
    $stmt6->bind_param("ss",$notification,$message_id);
    $stmt6->execute();
    $stmt6->fetch();
    $stmt6->close();
	
	}
	else{//Username 2 
	$notification="1";

	$stmt6 = $conn->prepare("UPDATE messaging SET notification_1=? WHERE message_id=?");
    $stmt6->bind_param("ss",$notification,$message_id);
    $stmt6->execute();
    $stmt6->fetch();
    $stmt6->close();
	}
