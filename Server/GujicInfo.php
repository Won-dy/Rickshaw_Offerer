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

    $hopeJCNum;
    $worker_email =$_POST["worker_email"];
    //$worker_email ="squirrel1109@naver.com";

    $selectWorker = mysqli_query($con, "SELECT * FROM Worker WHERE worker_email = '$worker_email'");
    while($row = mysqli_fetch_assoc($selectWorker)){  
        $response[] = $row;
    }
      

    $loadJC = mysqli_query($con, "SELECT * FROM HopeJob WHERE worker_email = '$worker_email'");
    while($row = mysqli_fetch_assoc($loadJC)){  
        $response1[] = $row;
    }
      
    for($i=0; $i<count($response1);$i++)
    {
        $job_code[] = $response1[$i]["job_code"];
        $selecJob = mysqli_query($con,"SELECT * FROM Job WHERE job_code = '$job_code[$i]'");
        while($row = mysqli_fetch_assoc($selecJob)){  
            $response2[] = $row;
        }
    }   

    echo json_encode($response,JSON_UNESCAPED_UNICODE);
    echo json_encode($response1,JSON_UNESCAPED_UNICODE);
    echo json_encode($response2,JSON_UNESCAPED_UNICODE);
?>