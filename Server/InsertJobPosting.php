<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

    if($con)
    {
    echo " connect : success <br>";
    }
    else
    {
    echo "disconnect : fail <br>";
    }
    $response = array();

    $key = $_POST["key"];
    $jp_num = $_POST["jp_num"];
    $business_reg_num = $_POST["business_reg_num"];
    $jp_title = $_POST["jp_title"];
    $jp_job_cost = $_POST["jp_job_cost"];
    $jp_job_tot_people = $_POST["jp_job_tot_people"];
    $jp_job_date = $_POST["jp_job_date"];
    $jp_contents = $_POST["jp_contents"];
    $field_name = $_POST["field_name"];
    $field_address = $_POST["field_address"];
    $jp_is_urgency = $_POST["jp_is_urgency"];
    $job_code = $_POST["job_code"];
    $jp_job_start_time = $_POST["jp_job_start_time"];
    $jp_job_finish_time = $_POST["jp_job_finish_time"];

//구인글생성
if($key=='0')
{

    // 매니저 활동지역 JobPosting local_code에 넣기위한 검색
    $local = explode(" ", $field_address); 
    $statement3 = mysqli_query($con, "SELECT local_code FROM Local WHERE local_sido = '$local[1]' AND local_sigugun='$local[2]'");
    while($row = mysqli_fetch_array($statement3)){  
        $local_code = $row[0];
    }
    

    $statement = mysqli_prepare($con, "INSERT INTO JobPosting(business_reg_num, local_code, job_code, jp_title, jp_contents, jp_job_cost, jp_job_tot_people, jp_job_date, jp_job_start_time, jp_job_finish_time, jp_is_urgency) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($statement, "sssssssssss", $business_reg_num, $local_code, $job_code, $jp_title, $jp_contents, $jp_job_cost, $jp_job_tot_people, $jp_job_date, $jp_job_start_time, $jp_job_finish_time, $jp_is_urgency);
    mysqli_stmt_execute($statement);

//값이 잘 드갔으면
//if(mysqli_stmt_fetch($statement))
//{
   $result = mysqli_query($con, "SELECT jp_num FROM `JobPosting` ORDER BY jp_num DESC LIMIT 1");
	$row = mysqli_fetch_assoc($result);
	$jp_num = $row["jp_num"];

    $statement2 = mysqli_prepare($con, "INSERT INTO Field(jp_num, field_name, field_address) VALUES (?,?,?)");
    mysqli_stmt_bind_param($statement2, "sss", $jp_num, $field_name, $field_address);
    mysqli_stmt_execute($statement2);
//}
    $worker=[];
    $token=[];
   $local_code1 = substr($local_code,0,2);

   $k=0;
   if($jp_is_urgency == "1"){
        $data2 = mysqli_query($con, "SELECT worker_email FROM HopeLocal WHERE local_code LIKE '{$local_code1}%'");
        while($row = mysqli_fetch_array($data2)){  
            $worker[] = $row[0];
            $k++;
        }
      
        for($i=0; $i<$k; $i++){
            $data1 =  mysqli_query($con, "SELECT Token FROM Users WHERE id='$worker[$i]'") or die(mysqli_error($con));
            while($row = mysqli_fetch_array($data1)){  
             array_push($response,array('token'=>$row[0]));
            }
          
        }
   }
   
  



    echo json_encode(array('response'=>$response));
}//구인글 생성 if문 끝

//구인글 수정
else if($key=='1')
{

 $local_code;

 $local = explode(" ", $field_address); 
 $statement3 = mysqli_query($con, "SELECT local_code FROM Local WHERE local_sido = '$local[1]' AND local_sigugun='$local[2]'");
 while($row = mysqli_fetch_array($statement3)){  
     $local_code = $row[0];
 }

 $statement = mysqli_prepare($con, "UPDATE JobPosting SET business_reg_num =? , local_code =?, job_code=?, jp_title=?, jp_contents=?, jp_job_cost=?, jp_job_tot_people=?, jp_job_date=?, jp_job_start_time=?, jp_job_finish_time=?, jp_is_urgency=? WHERE jp_num = ?");
 mysqli_stmt_bind_param($statement, "ssssssssssss", $business_reg_num, $local_code, $job_code, $jp_title, $jp_contents, $jp_job_cost, $jp_job_tot_people, $jp_job_date, $jp_job_start_time, $jp_job_finish_time, $jp_is_urgency, $jp_num);
    mysqli_stmt_execute($statement);

 $statement2 = mysqli_prepare($con, "UPDATE Field SET field_name =?, field_address=? WHERE jp_num = ?");
    mysqli_stmt_bind_param($statement2, "sss", $field_name, $field_address, $jp_num);
    mysqli_stmt_execute($statement2);

    $response["success"] = true;

    echo json_encode($response);
}
?>