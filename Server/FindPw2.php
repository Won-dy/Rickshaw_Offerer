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
    $manager_pw;

    // 클라이언트로부터 전송받은 worker_email 데이터 $worker_email에 저장
    $manager_represent_name = $_POST["manager_represent_name"];
    $business_reg_num = $_POST["business_reg_num"];

    $statement = mysqli_prepare($con, "SELECT manager_pw, business_reg_num  FROM Manager WHERE business_reg_num = ? and manager_represent_name = ?");

    mysqli_stmt_bind_param($statement, "ss", $business_reg_num, $manager_represent_name);  // sql문, 형식, PHP 변수
    mysqli_stmt_execute($statement);  // 실행

    mysqli_store_result($statement);
    mysqli_stmt_bind_result($statement, $manager_pw, $business_reg_num);
        
    $response["isExist"] = false;

    while(mysqli_stmt_fetch($statement)) {  // 해당 회원이 존재하면
        $response["isExist"] = true;
        $response["manager_pw"] = $manager_pw;
        $response["business_reg_num"] = $business_reg_num;
    }

    // json코드로 클라이언트에 리턴(응답)
    echo json_encode($response);
?>