<?
require "conn.php";
$posting_id = "";
$time_stamp = $_POST["time_stamp"];
$contact_email = $_POST["contact_email"];
$contact_phone = $_POST["contact_phone"];
$title = $_POST["title"];
$details = $_POST["details"];
$image_urls ="";
$location =$_POST["location"];
$housing = $_POST["housing"];

$stmt = $conn->prepare("INSERT INTO roommate_swap VALUES(?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("sssssssss", $posting_id, $time_stamp, $contact_email, $contact_phone, $title, $details, $image_urls, $location, $housing);
$stmt->execute();
while ($stmt->fetch()) {
    	echo 0;
    }
    $stmt->close();

/* close connection */
$conn->close();