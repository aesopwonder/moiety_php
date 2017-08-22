<?
require "conn.php";
$location =$_POST["location"];
//Collect applicable feed
$all_results=array();
if ($stmt = $conn->prepare("SELECT * FROM subleasing WHERE location =?")){
    $stmt->bind_param('s', $location);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $stmt->bind_result($posting_id, $time_stamp, $contact_email, $contact_phone, $title, $monthly_cost, $details, $image_urls, $location, $housing);
    while($stmt->fetch()){
   		$match_info = array('time_stamp'=>$time_stamp,
    	'contact_email'=>$contact_email,
    	'contact_phone'=>$contact_phone,
    	'title'=>$title,
    	'monthly_cost'=>$monthly_cost,
    	'details' => $details,
    	'image_urls'=>$image_urls,
    	'housing'=>$housing,
    	'posting_id' =>$posting_id
    	);
    	array_push($all_results, $match_info);
    		
   	 }
   	 echo json_encode(array("match"=>$all_results), JSON_PRETTY_PRINT);
   	 $stmt3->close();
}
$conn->close();
?>