<?php
require "conn.php";
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['hash']; // Set hash variable
	$active = "0";
	
	$sql_query = "select user_count from user_info where email like '$email' and hash like '$hash';";
	$result = mysqli_query($conn, $sql_query);

	if(mysqli_num_rows($result)>0){
        // We have a match, activate the account
        $sql = "UPDATE user_info SET active=1 WHERE email='$email';";
        $do = mysqli_query($conn, $sql);
        echo '<div class="statusmsg">Your account has been activated, you can now login</div>';
    }else{
        // No match -> invalid url or account has already been activated.
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.</div>';
    }
                 
}
else{
    // Invalid approach
    echo '<div class="statusmsg">Invalid approach, please use the link that has been send to your email.</div>';
}

?>