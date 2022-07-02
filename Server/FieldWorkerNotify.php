<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');

    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

$response = array();

$worker_email = $_POST["worker_email"];
$field_code = $_POST["field_code"];
$result = mysqli_query($con, "SELECT * FROM MyField WHERE worker_email = '$worker_email' AND field_code = '$field_code'");

while($row = mysqli_fetch_assoc($result)){  

  $response[] = $row;
  
  }
    echo json_encode($response,JSON_UNESCAPED_UNICODE);
  
?>