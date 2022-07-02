<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');

    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

$response = array();
$response1 = array();

$business_reg_num_MY =$_POST["business_reg_num_MY"];
$result = mysqli_query($con, "SELECT * FROM JobPosting WHERE business_reg_num = $business_reg_num_MY");

while($row = mysqli_fetch_assoc($result)){  

  $response[] = $row;
  
  }
for($i=0; $i<count($response);$i++)
{
$seljp_num[] = $response[$i]["jp_num"];

$result = mysqli_query($con,"SELECT * FROM Field WHERE jp_num = $seljp_num[$i]");
  while($row = mysqli_fetch_assoc($result)){  

$response1[] = $row;

  }
}
    echo json_encode($response,JSON_UNESCAPED_UNICODE);
    echo json_encode($response1,JSON_UNESCAPED_UNICODE);
?>