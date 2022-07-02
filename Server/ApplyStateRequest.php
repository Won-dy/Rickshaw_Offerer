<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');
$con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");





$key = $_POST["key"];



//스피너,워커리스트 값넣기 
if($key =='0')
{
  $response = array();
  
$response1 = array();
$response2 = array();

$business_reg_num_MY =$_POST["business_reg_num"];
$jp_num_MY = $_POST["jp_num"]; 
$jp_title_MY = $_POST["jp_title"];
//내 구인글인것들 안스에서 날짜 비교해줘야함(날짜 오늘 포함 미래)
$result = mysqli_query($con, "SELECT * FROM JobPosting WHERE business_reg_num = $business_reg_num_MY");

while($row = mysqli_fetch_assoc($result)){  

  $response[] = $row;
//response에서 jp_title갖다가 스피너에 넣고
  

  }

//
$result = mysqli_query($con, "SELECT * FROM Apply WHERE jp_num = '$jp_num_MY' AND apply_is_picked ='0' ");

while($row = mysqli_fetch_assoc($result)){  

  $response1[] = $row;
//response1에서 worker_email갖다가 검색해서 구직자들 프로필 리스트뷰에 띄우기
  
  }

for($i=0; $i<count($response1);$i++)
{
$selworker_email[] = $response1[$i]["worker_email"];
$result = mysqli_query($con,"SELECT * FROM Worker WHERE worker_email = '$selworker_email[$i]'");
  while($row = mysqli_fetch_assoc($result)){  

$response2[] = $row;

  }

 
}//for문 끝
echo json_encode($response,JSON_UNESCAPED_UNICODE);
echo json_encode($response2,JSON_UNESCAPED_UNICODE);

}//if문 끝


//Apply에 apply_is_picked==>0 선발
else if($key =='1')
{

$jp_num_MY = $_POST["jp_num_MY"];
$worker_email_MY = $_POST["worker_email_MY"];

$statement = mysqli_prepare($con, "UPDATE Apply SET apply_is_picked = '1' WHERE jp_num= ? AND Apply.worker_email = ?");
mysqli_stmt_bind_param($statement,"ss",$jp_num_MY,$worker_email_MY);

mysqli_stmt_execute($statement);

$result = mysqli_query($con, "SELECT * FROM Field WHERE Field.jp_num = $jp_num_MY");

$row = mysqli_fetch_assoc($result);

$field_code = $row["field_code"];

$statement1 = mysqli_prepare($con, "INSERT INTO MyField(worker_email, field_code, jp_num, mf_is_choolgeun, mf_is_toigeun, mf_is_paid) VALUES (?,?,?,'0','0','0')");
mysqli_stmt_bind_param($statement1, "sss", $worker_email_MY, $field_code, $jp_num_MY );

mysqli_stmt_execute($statement1);
echo $field_code;

$data1 =  mysqli_query($con, "SELECT Token FROM Users WHERE id='$worker_email_MY'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($data1)){  
  $response['token'] = $row[0];
}

$data2 =  mysqli_query($con, "SELECT field_name FROM Field WHERE jp_num='$jp_num_MY'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($data2)){  
  $response['fieldname'] = $row[0];
}





echo json_encode($response,JSON_UNESCAPED_UNICODE);
//푸시알림 기능
//$tokens1=[];
//$getusertoken = mysqli_query($con, "SELECT Token FROM Users WHERE id='$worker_email_MY' or id='00'");
//while($row1 =mysqli_fetch_array($getusertoken)) {
 //   $tokens1[] = $row1[0];
//}
}//else if 끝

//스피너,워커리스트 값넣기  Pickstate
else if($key =='2')
{
  $response = array();
  
$response1 = array();
$response2 = array();

$business_reg_num_MY =$_POST["business_reg_num"];
$jp_num_MY = $_POST["jp_num"]; 
$jp_title_MY = $_POST["jp_title"];
//내 구인글인것들 안스에서 날짜 비교해줘야함(날짜 오늘 포함 미래)
$result = mysqli_query($con, "SELECT * FROM JobPosting WHERE business_reg_num = $business_reg_num_MY");

while($row = mysqli_fetch_assoc($result)){  

  $response[] = $row;
//response에서 jp_title갖다가 스피너에 넣고
  

  }

//
$result = mysqli_query($con, "SELECT * FROM Apply WHERE jp_num = '$jp_num_MY' AND apply_is_picked ='1' ");

while($row = mysqli_fetch_assoc($result)){  

  $response1[] = $row;
//response1에서 worker_email갖다가 검색해서 구직자들 프로필 리스트뷰에 띄우기
  
  }

for($i=0; $i<count($response1);$i++)
{
$selworker_email[] = $response1[$i]["worker_email"];
$result = mysqli_query($con,"SELECT * FROM Worker WHERE worker_email = '$selworker_email[$i]'");
  while($row = mysqli_fetch_assoc($result)){  

$response2[] = $row;

  }

 
}//for문 끝
echo json_encode($response,JSON_UNESCAPED_UNICODE);
echo json_encode($response2,JSON_UNESCAPED_UNICODE);

}//if문 끝



//Apply에 apply_is_picked==>0선발 취소 Pickstate
else if($key =='3')
{
$jp_num_MY = $_POST["jp_num_MY"];
$worker_email_MY = $_POST["worker_email_MY"];

$statement = mysqli_prepare($con, "UPDATE Apply SET apply_is_picked = '0' WHERE jp_num= ? AND Apply.worker_email = ?");
mysqli_stmt_bind_param($statement,"ss",$jp_num_MY,$worker_email_MY);

mysqli_stmt_execute($statement);

$statement1 = mysqli_prepare($con, "DELETE FROM MyField WHERE worker_email = ? AND jp_num = ?");
mysqli_stmt_bind_param($statement1, "ss", $worker_email_MY, $jp_num_MY);
mysqli_stmt_execute($statement1);

$data1 =  mysqli_query($con, "SELECT Token FROM Users WHERE id='$worker_email_MY'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($data1)){  
  $response['token'] = $row[0];
}

$data2 =  mysqli_query($con, "SELECT field_name FROM Field WHERE jp_num='$jp_num_MY'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($data2)){  
  $response['fieldname'] = $row[0];
}

echo json_encode($response,JSON_UNESCAPED_UNICODE);


}//else if 끝


?>