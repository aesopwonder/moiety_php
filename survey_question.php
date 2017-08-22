<?
require "conn.php";
$username = $_POST["username"];
$answer = $_POST["answer"];
$question =$_POST["question"];
$sql = "UPDATE user_info SET $question= '$answer' WHERE username='$username';"; 
$do = mysqli_query($conn, $sql);
?>