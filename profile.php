<?
require "conn.php";

$username =$_POST["username"];
$fullName =$_POST["fullName"];
$age =$_POST["age"];
$bio =$_POST["bio"];
$gender =$_POST["gender"];
$year =$_POST["year"];
$location =$_POST["location"];
	$stmt = $conn->prepare("UPDATE user_info SET fullName=?, age=?, bio=?, gender=?, year=?, location=? WHERE username=?");
    $stmt->bind_param('sssssss', $fullName, $age, $bio, $gender, $year, $location, $username);
    $stmt->execute();
    $stmt->close();
if ($stmt->errno) {
  echo "FAILURE!!! " . $stmt->error;
}
else echo "0";

/* close connection */
$conn->close();


?>