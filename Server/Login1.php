<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
    header('Content-Type: application/json; charset=utf-8');
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
   $business_reg_num = $_POST["business_reg_num"];
   $manager_pw =  $_POST["manager_pw"];
   $response = array();
   $a = false;
   

if($manager_pw == "0"){
    $data = mysqli_query($con, "SELECT kakao_email, business_reg_num FROM ManagerKakao WHERE kakao_email = '$business_reg_num'") or die(mysqli_error($con));
    
        while($row1 =mysqli_fetch_array($data)) {
            $email = $row1[1];
        }
        $data1 = mysqli_query($con, "SELECT local_code FROM Manager WHERE business_reg_num = '$email'") or die(mysqli_error($con));
        if (!empty($data1) || $data1 == true){
            while($row1 =mysqli_fetch_array($data1)) {
                $local_code1 = $row1[0];
            }
        }

        $data2 = mysqli_query($con, "SELECT local_sido, local_sigugun FROM Local WHERE local_code = '$local_code1'") or die(mysqli_error($con));
        if (!empty($data2) || $data2 == true){
            while($row1 =mysqli_fetch_array($data2)) {
                $local_sido1 = $row1[0];
                $local_sigugun1 = $row1[1];
        }
        }
        $statement = mysqli_prepare($con, "SELECT business_reg_num, manager_pw, manager_represent_name,manager_office_name, manager_office_telnum, manager_office_address, manager_name, local_code,manager_phonenum, manager_bankname, manager_office_info, manager_bankaccount FROM Manager WHERE business_reg_num = ? and manager_pw = ?");
         mysqli_stmt_bind_param($statement, "ss", $email, $manager_pw);
        mysqli_stmt_execute($statement);
        //mysqli_store_result($statement);
        mysqli_stmt_bind_result($statement, $business_reg_num, $manager_pw, $manager_represent_name, $manager_office_name, $manager_office_telnum, $manager_office_address, $manager_name, $local_code, $manager_phonenum, $manager_bankname, $manager_office_info, $manager_bankaccount );

        
    $response["tryLogin"] = false;
        while(mysqli_stmt_fetch($statement)) {  // 해당 회원 존재하면
            $response["tryLogin"] = true;
            $response["business_reg_num"] = $business_reg_num;
            $response["manager_pw"] = $manager_pw;
            $response["manager_represent_name"] = $manager_represent_name;
            $response["manager_office_name"] = $manager_office_name;
            $response["manager_office_telnum"] = $manager_office_telnum;
            $response["manager_office_address"] = $manager_office_address;
            $response["manager_name"] = $manager_name;
            $response["local_code"] = $local_code;
            $response["local_sido"] = $local_sido1;
            $response["local_sigugun"] = $local_sigugun1;
            $response["manager_phonenum"] = $manager_phonenum;
            $response["manager_bankname"] = $manager_bankname;
            $response["manager_office_info"] = $manager_office_info;
            $response["manager_bankaccount"] = $manager_bankaccount;
    
        }

    
    

}
else{


    $data = mysqli_query($con, "SELECT local_code FROM Manager WHERE business_reg_num = '$business_reg_num'") or die(mysqli_error($con));
    if (!empty($data) || $data == true){
        while($row1 =mysqli_fetch_array($data)) {
            
            $local_code1 = $row1[0];
        }
    }

    $data1 = mysqli_query($con, "SELECT local_sido, local_sigugun FROM Local WHERE local_code = '$local_code1'") or die(mysqli_error($con));
    if (!empty($data1) || $data1 == true){
        while($row1 =mysqli_fetch_array($data1)) {
            $local_sido1 = $row1[0];
            $local_sigugun1 = $row1[1];
        }
    }
    
    $statement = mysqli_prepare($con, "SELECT business_reg_num, manager_pw, manager_represent_name,manager_office_name, manager_office_telnum, manager_office_address, manager_name, local_code,manager_phonenum, manager_bankname, manager_office_info, manager_bankaccount FROM Manager WHERE business_reg_num = ? and manager_pw = ?");
     mysqli_stmt_bind_param($statement, "ss", $business_reg_num, $manager_pw);
    mysqli_stmt_execute($statement);
    //mysqli_store_result($statement);
    mysqli_stmt_bind_result($statement, $business_reg_num, $manager_pw, $manager_represent_name, $manager_office_name, $manager_office_telnum, $manager_office_address, $manager_name, $local_code, $manager_phonenum, $manager_bankname, $manager_office_info, $manager_bankaccount );
    
    
    $response["tryLogin"] = false;

    while(mysqli_stmt_fetch($statement)) {  // 해당 회원 존재하면
        $response["tryLogin"] = true;
        $response["business_reg_num"] = $business_reg_num;
        $response["manager_pw"] = $manager_pw;
        $response["manager_represent_name"] = $manager_represent_name;
        $response["manager_office_name"] = $manager_office_name;
        $response["manager_office_telnum"] = $manager_office_telnum;
        $response["manager_office_address"] = $manager_office_address;
        $response["manager_name"] = $manager_name;
        $response["local_code"] = $local_code;
        $response["local_sido"] = $local_sido1;
        $response["local_sigugun"] = $local_sigugun1;
        $response["manager_phonenum"] = $manager_phonenum;
        $response["manager_bankname"] = $manager_bankname;
        $response["manager_office_info"] = $manager_office_info;
        $response["manager_bankaccount"] = $manager_bankaccount;

    }
}
    
    echo json_encode($response ,JSON_UNESCAPED_UNICODE);
?>
