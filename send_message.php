<?php
require "conn.php";
$message_id=$_POST["message_id"];
$username=$_POST["username"];
$time_stamp=$_POST["time_stamp"];
if ($stmt = $conn->prepare("SELECT * FROM messaging WHERE message_id=?")) {
    /* bind parameters for markers */
    $stmt->bind_param("s", $message_id);
    /* execute query */
    $stmt->execute();
	$stmt->store_result();
	$rows=$stmt->num_rows;
	if($rows==0){
		//ERROR DO SOMETHING
	}
	else{
		if ($stmt2 = $conn->prepare("SELECT conversation
    	FROM messaging WHERE message_id=?")) {
    		$stmt2->bind_param('s', $message_id);
    		$stmt2->execute();   
    		/* bind variables to prepared statement */
    		$stmt2->bind_result($conversation);
    		$stmt2->fetch();
    		$stmt2->close();
    	}
			$updated_conversation =$conversation.base64_encode($username).".".base64_encode($time_stamp).".".base64_encode($_POST["conversation"]).",";
			$stmt3 = $conn->prepare("UPDATE messaging SET conversation=? WHERE message_id=?");
    		$stmt3->bind_param("ss", $updated_conversation, $message_id);
    		$stmt3->execute();
    		$stmt3->store_result();
    		$stmt3->close();
		
	}
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
	echo 0;
}
$conn->close();