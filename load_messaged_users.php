<?
require "conn.php";

$username =$_POST["username"];
$location =$_POST["location"];
//Collect dealbreaker info
if ($stmt = $conn->prepare("SELECT sex, housing_type, life_stage, smoking, deleted_users, messaged_users
    FROM user_info WHERE username=?")) {
    $stmt->bind_param('s', $username);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $stmt->bind_result($user_sex, $user_housing_type, $user_life_stage, $user_smoking, $deleted_users, $messaged_users);
    $stmt->fetch();
    $stmt->close();
    }
//Get deleted users to ensure no repeats
	$trimmed =trim($deleted_users);
	if(strlen($trimmed)>1){
		$arr = explode(",", $trimmed); // array( '1', '2', '3', '4', '5', '6' );
		}
    else if(strlen($trimmed)==1){
    	$arr = array(0=>$deleted_users);
    }
    else{
    	$arr = array(0=>'-1');
    }
//Get Messaged Users 
	$trimmed2 =trim($messaged_users);
	if(strlen($trimmed2)>1){
		$arr2 = explode(",", $trimmed2); // array( '1', '2', '3', '4', '5', '6' );
		}
    else if(strlen($trimmed2)==1){
    	$arr2 = array(0=>$messaged_users);
    }
    else{
    	$arr2 = array(0=>'-1');
    }
	
//Get survey questions for comparison
if ($stmt2 = $conn->prepare("SELECT bedtime, wake_up, alcohol, drugs, party, purpose, goals, exercise, cleanliness, roommate, noise, music, weekends, relationship, eating, sharing
    FROM user_info WHERE username=?")){
    	$stmt2->bind_param('s', $username);
    	$stmt2->execute(); 
    	$stmt2->bind_result($bedtime, $wake_up, $alcohol, $drugs, $party, $purpose, $goals, $exercise, $cleanliness, $roommate, $noise, $music, $weekends, $relationship, $eating, $sharing);
    	
    	if($stmt2->fetch()) {
    	$user = array(0=>$bedtime,
    	1=>$wake_up,
    	2=>$alcohol,
    	3=>$drugs,
    	4=>$party,
    	5=>$purpose,
    	6=>$goals,
    	7=>$exercise,
    	8=>$cleanliness,
    	9=>$roommate,
    	10=>$noise,
    	11=>$music,
    	12=>$weekends,
    	13=>$relationship,
    	14=>$eating,
    	15=>$sharing
    );
    }
   
$stmt2->close();
}


//Collect viable candidates and put their survey answers in an array
	if ($stmt3 = $conn->prepare("SELECT user_count, username, fullName, age, gender, year, bio, bedtime, wake_up, alcohol, drugs, party, purpose, goals, exercise, cleanliness, roommate, noise, music, weekends, relationship, eating, sharing
    FROM user_info WHERE username!=? AND location=? AND sex=? AND housing_type=? AND life_stage=? AND smoking=?")) {
    $stmt3->bind_param('ssssss', $username, $location, $user_sex, $user_housing_type, $user_life_stage, $user_smoking);
    $stmt3->execute(); 
    $stmt3->bind_result($user_count, $match_username, $fullName2, $age2, $gender2, $year2, $bio2, $bedtime2, $wake_up2, $alcohol2, $drugs2, $party2, $purpose2, $goals2, $exercise2, $cleanliness2, $roommate2, $noise2, $music2, $weekends2, $relationship2, $eating2, $sharing2);
    $all_results=array();
    while($stmt3->fetch()) {
    	$match = array(0=>$bedtime2,
    	1=>$wake_up2,
    	2=>$alcohol2,
    	3=>$drugs2,
    	4=>$party2,
    	5=>$purpose2,
    	6=>$goals2,
    	7=>$exercise2,
    	8=>$cleanliness2,
    	9=>$roommate2,
    	10=>$noise2,
    	11=>$music2,
    	12=>$weekends2,
    	13=>$relationship2,
    	14=>$eating2,
    	15=>$sharing2
    	);
    	$deleted=0;
    	$messaged=0;
    	for($i=0;$i<count($arr); $i++){//check to see if deleted
    		$temp = trim($arr[$i]);
    		if(strcmp($user_count, $temp) == 0){
    			$deleted=1;
    		}
    		else{//not deleted
    		}
    	}
    	
    	for($i=0;$i<count($arr2); $i++){//check to see if deleted
    		$temp2 = trim($arr2[$i]);
    		if(strcmp($user_count, $temp2) == 0){
    			$messaged=1;
    		}
    		else{//not messaged
    		}
    	}
    	
    	$same=0;
    	for($i=0;$i<16;$i++){
    		if($match[$i]==$user[$i]){
    			$same++;
    		}
    	}
    	$match_percentage=(($same+4)/20)*100;
    	
    	$servername_2 = "localhost";
		$username_2 = "root";
		$password_2 = "root";

	// Create connection
	$conn2 = new mysqli($servername_2, $username_2, $password_2, "moiety_database");
    if ($stmtt = $conn2->prepare("SELECT message_id
    FROM messaging WHERE user_name_1=? AND user_name_2=? OR user_name_2=? AND user_name_1=?")){
    $stmtt->bind_param('ssss', $username, $match_username, $username, $match_username);
    $stmtt->execute();   
    /* bind variables to prepared statement */
    $stmtt->bind_result($message_id);
    $stmtt->fetch();
   }
   		$match_info = array('fullName'=>$fullName2,
    	'age'=>$age2,
    	'gender'=>$gender2,
    	'year'=>$year2,
    	'bio'=>$bio2,
    	'match_percentage' => $match_percentage,
    	'user_count'=>$user_count,
    	'username'=>$match_username,
    	'message_id'=>$message_id
    	);
    	if($deleted==0&&$messaged==1){
    	array_push($all_results, $match_info);
    	}
    	
   	 }
   	 echo json_encode(array("match"=>$all_results), JSON_PRETTY_PRINT);
   	 $stmt3->close();
} 
	
    
    //Print match info in json format
    
/* close connection */
$conn->close();
?>