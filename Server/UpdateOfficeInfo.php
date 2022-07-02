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
    $key = $_POST["key"];	

    if ($key == "deleteAccnt") {  // 계좌 삭제

        $business_reg_num =$_POST["business_reg_num"];

        $deleteAccnt = mysqli_prepare($con, "UPDATE Manager SET manager_bankname = '', manager_bankaccount = '' WHERE business_reg_num = ?");

        mysqli_stmt_bind_param($deleteAccnt, "s",$business_reg_num);

        if(mysqli_stmt_execute($deleteAccnt))
            $response["deleteSuccess"] = true;
        else 
            $response["deleteSuccess"] = false;      

    } else if ($key == "accountUpdate") {  // 계좌 수정

        $business_reg_num =$_POST["business_reg_num"];
        $manager_bankname =$_POST["manager_bankname"];
        $manager_bankaccount =$_POST["manager_bankaccount"];

        $accountUpdate = mysqli_prepare($con, "UPDATE Manager SET manager_bankname = ?, manager_bankaccount = ? WHERE business_reg_num = ?");

        mysqli_stmt_bind_param($accountUpdate, "sss", $manager_bankname, $manager_bankaccount, $business_reg_num);

        if(mysqli_stmt_execute($accountUpdate))
            $response["updateSuccess3"] = true;
        else 
            $response["updateSuccess3"] = false;            

    } else if ($key == "UpdateOfficeInfo") {  // 사무소 정보 수정

        $business_reg_num =$_POST["business_reg_num"];
        $manager_office_name =$_POST["manager_office_name"];
        $manager_office_telnum =$_POST["manager_office_telnum"];
        $manager_office_address =$_POST["manager_office_address"];
        $manager_name =$_POST["manager_name"];
        $manager_phonenum =$_POST["manager_phonenum"];

        $officeInfoUpdate = mysqli_prepare($con, "UPDATE Manager SET manager_office_name = ?, manager_office_telnum = ?, manager_office_address = ?, manager_name = ?, manager_phonenum = ? WHERE business_reg_num = ?");

        mysqli_stmt_bind_param($officeInfoUpdate, "ssssss", $manager_office_name, $manager_office_telnum, $manager_office_address, $manager_name, $manager_phonenum, $business_reg_num);

        if(mysqli_stmt_execute($officeInfoUpdate))
            $response["updateSuccess2"] = true;
        else 
            $response["updateSuccess2"] = false;            

    } else if ($key == "UpdateOfficeDetailInfo") {  // 사무소 상세정보 수정

        $business_reg_num =$_POST["business_reg_num"];
        $manager_office_info =$_POST["manager_office_info"];

        $officeDetailInfoUpdate = mysqli_prepare($con, "UPDATE Manager SET manager_office_info = ? WHERE business_reg_num = ?");

        mysqli_stmt_bind_param($officeDetailInfoUpdate, "ss", $manager_office_info, $business_reg_num);

        if(mysqli_stmt_execute($officeDetailInfoUpdate))
            $response["updateSuccess"] = true;
        else 
            $response["updateSuccess"] = false;            

    } else if ($key == "UpdateLocal") {  // 활동 지역 수정
           
        $local_code;
        $business_reg_num =$_POST["business_reg_num"];
        $local_sido = $_POST["local_sido"];
        $local_sigugun = $_POST["local_sigugun"];
    
        $selectstate = mysqli_prepare($con, "SELECT local_code FROM Local WHERE local_sido = ? and local_sigugun = ?");
        mysqli_stmt_bind_param($selectstate, "ss", $local_sido , $local_sigugun);
        mysqli_stmt_execute($selectstate);
            
        mysqli_stmt_bind_result($selectstate, $local_code );
        
        while(mysqli_stmt_fetch($selectstate)) {
            $response["local_code"] = $local_code;
            $response["local_sido"] = $local_sido;
            $response["local_sigugun"] = $local_sigugun;
        }
                    
        $response["updateSuccess"] = false;
        $localUpdate = mysqli_prepare($con, "UPDATE Manager SET local_code = ? WHERE business_reg_num = ?");
        mysqli_stmt_bind_param($localUpdate, "ss", $local_code, $business_reg_num);
        if(mysqli_stmt_execute($localUpdate))
            $response["updateSuccess"] = true;
        else
            $response["updateSuccess"] = false;

    } 
    
    echo json_encode($response);
?>