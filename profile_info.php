<?
require "conn.php";
$username ="amnguyen1";

if ($stmt = $conn->prepare("SELECT email, user_count, fullName, age, gender, year, bio, location
    FROM user_info WHERE username=?")) {
    $stmt->bind_param('s', $username);
    $stmt->execute();   
    /* bind variables to prepared statement */
    $stmt->bind_result($email, $user_count, $fullName, $age, $gender, $year, $bio, $location);
    $json = array();
    /* fetch values */
    if($stmt->fetch()) {
        $result = array(
    'email'=>$email,
    'user_count'=>$user_count,
    'fullName'=>$fullName,
    'age'=>$age,
    'gender'=>$gender,
    'year'=>$year,
    'bio'=>$bio,
    'location'=>$location
    );
    }else{
        $json = array('error'=>'no record found');
    }
    /* close statement */
    $stmt->close();
}
echo json_encode(array("result"=>$result));
/* close connection */
$conn->close();
?>