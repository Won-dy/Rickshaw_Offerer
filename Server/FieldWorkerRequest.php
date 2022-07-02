<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');
    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

$response1 = array();
$response2 = array();
$response3 = array();

$jp_num_MY = $_POST["jp_num"]; 


$result = mysqli_query($con, "SELECT * FROM Apply WHERE jp_num = '$jp_num_MY' AND apply_is_picked ='1' ");

while($row = mysqli_fetch_assoc($result)){  

  $response1[] = $row;
//response1에서 worker_email갖다가 검색해서 구직자들 프로필 리스트뷰에 띄우기
  
  }

//구직자들 프로필 리스트뷰에 띄우기
for($i=0; $i<count($response1);$i++)
{
$selworker_email[] = $response1[$i]["worker_email"];
$result = mysqli_query($con,"SELECT * FROM Worker WHERE worker_email = '$selworker_email[$i]'");
  while($row = mysqli_fetch_assoc($result)){  

$response2[] = $row;

  }
}


for($i=0; $i<count($response1);$i++)
{
$selworker_email[] = $response1[$i]["worker_email"];
$result = mysqli_query($con,"SELECT * FROM MyField WHERE worker_email = '$selworker_email[$i]' AND jp_num = '$jp_num_MY'");
  while($row = mysqli_fetch_assoc($result)){  

$response3[] = $row;

 }
}

echo json_encode($response2,JSON_UNESCAPED_UNICODE);
echo json_encode($response3,JSON_UNESCAPED_UNICODE);

?>