<?php
require "conn.php";
$message_id=$_POST["message_id"];
//Collect conversation details 
if ($stmt = $conn->prepare("SELECT * FROM messaging WHERE message_id=?")) {
 	/* bind parameters for markers */
    $stmt->bind_param("s", $message_id);
    /* execute query */
    $stmt->execute();
    $stmt->bind_result($message_id, $user_name_1, $user_name_2, $conversation, $notification_1, $notification_2);
    $stmt->fetch();
    $stmt->close();
}
$conversation_lines = explode(",", $conversation);//Array amnguyen1.22:16.Hey Im Andrew
$array_size = count($conversation_lines);
$all_lines_of_conversation=array();
for($i=$array_size-1;$i>=0;$i--){
	list($user_name, $time_stamp, $conversation) = explode(".", $conversation_lines[$i]);
	$user_name=base64_decode($user_name);
	if(strlen($user_name)==0){
		continue;
	}
	else{
	$time_stamp=base64_decode($time_stamp);
	$conversation=base64_decode($conversation);
	$message_info = array('username'=>$user_name,
    	'time_stamp'=>$time_stamp,
    	'message'=>$conversation,
    	);
    array_push($all_lines_of_conversation, $message_info);
    }
}

echo json_encode(array("Conversation"=>$all_lines_of_conversation), JSON_PRETTY_PRINT);

