<?php
require "conn.php";
$user_count="";
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$location ="";
$sex ="";
$housing_type="";
$life_stage="";
$smoking ="";
$bedtime ="";
$wake_up ="";
$alcohol ="";
$drugs ="";
$party ="";
$purpose ="";
$goals ="";
$exercise ="";
$cleanliness ="";
$roommate ="";
$noise ="";
$music ="";
$weekends ="";
$relationship="";
$eating ="";
$sharing ="";
$user_image_url="";
$full_name="";
$bio="";
$gender="";
$age="";
$year="";
$active="0";
$survey="0";
$deleted_users="";
$messaged_users="";
$hash = md5( rand(0,1000) );
$sql_query = "insert into user_info values('$user_count', '$email','$username','$password','$location','$sex','$housing_type','$life_stage','$smoking','$bedtime','$wake_up','$alcohol','$drugs','$party','$purpose','$goals', '$exercise','$cleanliness','$roommate','$noise', '$music', '$weekends','$relationship','$eating','$sharing','$user_image_url','$full_name','$bio','$gender','$age','$year','$active','$hash', '$survey', '$deleted_users', '$messaged_users');";
			
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo "Invalid email format"; 
}
else{
	// Return Success - Valid Email
	$checkUsername = "select username from user_info where username like '$username';";
	$resultCheckUsername = mysqli_query($conn, $checkUsername);
	if(mysqli_num_rows($resultCheckUsername)>0){
		echo "Username Taken";
	}
	else{
		$checkEmail = "select email from user_info where email like '$email';";
		$resultCheckEmail = mysqli_query($conn, $checkEmail);
		if(mysqli_num_rows($resultCheckEmail)>0){
			echo "An Account With That Email Already Exists";
		
		}
		else{
			if(mysqli_query($conn,$sql_query)){
			
			$to      = $email; // Send email to our user
			$subject = 'Signup | Verification'; // Give the email a subject 
			$message = '
 
			Hello user!
			Your Moiety account has been created.
			
			Please click the link below to activate your account!
			http://localhost:8888/verify.php?email='.$email
			.'&hash='.$hash.'
 
			'; // Our message above including the link
					 
			$headers = 'From:noreply@moiety.com' . "\r\n"; // Set from headers
			mail($to, $subject, $message, $headers); // Send our email
			
				
			echo "Registration Success, an email has been sent to activate your account!";
			}
			else{
				echo "Registration Failed... ".mysqli_error($conn);
			}		
/* close connection */
$conn->close();			
	
		}
	}
}



?>