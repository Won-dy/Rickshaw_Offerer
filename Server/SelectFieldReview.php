<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');

    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

$response = array();
$response1 =array();
$field_code = $_POST["field_code"];

$selectReview =  mysqli_query($con, "SELECT * FROM FieldReview WHERE FieldReview.field_code = '$field_code'");

 while($row = mysqli_fetch_assoc($selectReview)){  

  $response[] = $row;
  
  }
for($i=0; $i<count($response); $i++)
{
$selworker_email[] = $response[$i]["worker_email"]; 
echo $selworker_email[$i];
$result = mysqli_query($con, "SELECT * FROM Worker WHERE Worker.worker_email = '$selworker_email[$i]'");

while($row = mysqli_fetch_assoc($result))
{
$response1[] = $row;
}
} 


   echo json_encode($response,JSON_UNESCAPED_UNICODE);
   echo json_encode($response1,JSON_UNESCAPED_UNICODE);

?>