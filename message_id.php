<?php
require "conn.php";
$user_name_1=$_POST["user_name_1"];
$user_name_2=$_POST["user_name_2"];
$message_id="";
$notification_1=0;
$notification_2=0;
if (empty($user_name_1)||empty($user_name_2)) {
    exit;
}
//Check to see if conversation is already created or a new message needs to be continued
if ($stmt = $conn->prepare("SELECT message_id
    FROM messaging WHERE (user_name_1=? AND user_name_2=?) OR (user_name_2=? AND user_name_1=?)")) {
    $stmt->bind_param('ssss', $user_name_1,$user_name_2,$user_name_1,$user_name_2);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $stmt->bind_result($message_id);
    $stmt->fetch();
    $stmt->close();
    
    }
    echo $message_id;
	$rows=$stmt->num_rows;
	if($rows==0){
		
		//This returns the max message id so that a new message id can be incremented in the app
		$sql_query = "insert into messaging values('$message_id','$user_name_1','$user_name_2','$conversation', '$notification_1', '$notification_2');";
		if(mysqli_query($conn,$sql_query)){
			if ($stmt2 = $conn->prepare("SELECT message_id
    			FROM messaging WHERE (user_name_1=? AND user_name_2=?) OR (user_name_2=? AND user_name_1=?)")) {
    			$stmt2->bind_param('ssss', $user_name_1,$user_name_2,$user_name_1,$user_name_2);
    			$stmt2->execute();   
    			/* bind variables to prepared statement */
    			$stmt2->bind_result($message_id);
    			$stmt2->fetch();
    			$stmt2->close();
    		}
    	
    		echo $message_id;
    		exit;
    	}
    	echo $message_id;
    }