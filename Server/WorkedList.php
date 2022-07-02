<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
    // 서버와 DB에 접속
    // $con = mysqli_connect(host, username(id), passwd, DB명);
    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

    if($con)
    {
    echo " connect : success <br>";
    }
    else
    {
    echo "disconnect : fail<br>";
    }
    
    $response = array();
    $response1 = array();
    $response2 = array();

    $worker_email =$_POST["worker_email"];
    //$worker_email ="miney8332@naver.com";

    // 근무 날짜, 직종 코드, 현장 코드
    $selectWorked = mysqli_query($con, "SELECT JobPosting.job_code, JobPosting.jp_job_date, MyField.field_code FROM JobPosting 
    JOIN MyField ON JobPosting.jp_num = MyField.jp_num WHERE MyField.worker_email = '$worker_email' AND MyField.mf_is_choolgeun = 1 AND MyField.mf_is_toigeun = 1");
    while($row = mysqli_fetch_assoc($selectWorked)){  
        $response[] = $row;
    }

    // 직종 이름, 현장 이름
    for($i=0; $i<count($response); $i++)
    {
        $job_code[] = $response[$i]["job_code"];
        $selecJob = mysqli_query($con,"SELECT * FROM Job WHERE job_code = '$job_code[$i]'");
        while($row = mysqli_fetch_assoc($selecJob)){  
            $response1[] = $row;
        }

        $field_code[] = $response[$i]["field_code"];
        $selecField = mysqli_query($con,"SELECT * FROM Field WHERE field_code = '$field_code[$i]'");
        while($row = mysqli_fetch_assoc($selecField)){  
            $response2[] = $row;
        }

    }      

    echo json_encode($response,JSON_UNESCAPED_UNICODE);
    echo json_encode($response1,JSON_UNESCAPED_UNICODE);
    echo json_encode($response2,JSON_UNESCAPED_UNICODE);
?>