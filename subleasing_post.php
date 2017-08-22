<?
require "conn.php";
$posting_id = "";
$time_stamp = $_POST["time_stamp"];
$contact_email = $_POST["contact_email"];
$contact_phone = $_POST["contact_phone"];
$title = $_POST["title"];
$details = $_POST["details"];
$monthly_cost = $_POST["monthly_cost"];
$image_urls ="";
$location =$_POST["location"];
$housing = $_POST["housing"];

$stmt = $conn->prepare("INSERT INTO subleasing VALUES(?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssssssssss", $posting_id, $time_stamp, $contact_email, $contact_phone, $title, $monthly_cost, $details, $image_urls, $location, $housing);
$stmt->execute();
$stmt->close();

/* close connection */
$conn->close();