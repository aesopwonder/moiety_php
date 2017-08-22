<?
require "conn.php";

$username =$_POST["username"];
$password =$_POST["password"];

	$stmt = $conn->prepare("SELECT active FROM user_info WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($active);
    $rows = $stmt->num_rows;
    if($rows>0){
    	while ($stmt->fetch()) {
    		if($active==1){
    		echo "Login Success";
    		}
    		else{
    			echo "Account not yet activated...";
    		}
    	}
    }
    else{
    	echo "Login Failure";
    }
    $stmt->close();

/* close connection */
$conn->close();


?>