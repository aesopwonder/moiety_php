<?
require "conn.php";

$username =$_POST["username"];//Username of the deleter
$deleted_user=$_POST["user_count"];//Usercount of person being deleted 
if ($stmt = $conn->prepare("SELECT deleted_users
    FROM user_info WHERE username=?")) {
    $stmt->bind_param('s', $username);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $stmt->bind_result($deleted_users);
    $stmt->fetch();
    $stmt->close();
    }
$updated_deleted_users =$deleted_users.",".$deleted_user;
	
	$stmt = $conn->prepare("UPDATE user_info SET deleted_users=? WHERE username=?");
    $stmt->bind_param("ss", $updated_deleted_users, $username);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows;
    $stmt->close();
    
if ($stmt2 = $conn->prepare("SELECT messaged_users
    FROM user_info WHERE username=?")) {
    $stmt2->bind_param('s', $username);
    $stmt2->execute();   
    /* bind variables to prepared statement */
    $stmt2->bind_result($messaged_users);
    $stmt2->fetch();
    $stmt2->close();
    $messaged_users_array = explode(",", $messaged_users);//String array of messaged users
    $array_size = count($messaged_users_array);
    $empty="";
    
    	for($i=0;$i<$array_size;$i++){
			 if(strcmp($messaged_users_array[$i], $empty)==0){
			 	unset($messaged_users_array[$i]);
			 } 
			 if(strcmp($messaged_users_array[$i], $deleted_user)==0){
			 	unset($messaged_users_array[$i]);
			 }   
    	}
    $updated_messaged_users=implode(",", $messaged_users_array);
    $stmt3 = $conn->prepare("UPDATE user_info SET messaged_users=? WHERE username=?");
    $stmt3->bind_param("ss", $updated_messaged_users, $username);
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->close();
    echo 0;
    }
    //Find deleted user username
    if ($stmt4 = $conn->prepare("SELECT username
    FROM user_info WHERE user_count=?")) {
    $stmt4->bind_param('s', $deleted_user);
    $stmt4->execute();   
    /* bind variables to prepared statement */
    $stmt4->bind_result($deleted_user_username);
    $stmt4->fetch();
    $stmt4->close();
    }
    //Remove chat thread if there is one
    if ($stmt5 = $conn->prepare("DELETE FROM messaging 
    WHERE (user_name_1=? AND user_name_2=?) OR (user_name_2=? AND user_name_1=?)")) {
    $stmt5->bind_param('ssss', $deleted_user_username, $username, $deleted_user_username, $username);
    $stmt5->execute();   
    $stmt5->fetch();
    $stmt5->close();
    }

/* close connection */
$conn->close();


?>