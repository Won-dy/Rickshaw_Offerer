<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');
$con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");
$response = array();
$local_code;
$business_reg_num =$_POST["business_reg_num"];  
$manager_pw = $_POST["manager_pw"];
$manager_represent_name = $_POST["manager_represent_name"];
$manager_office_name = $_POST["manager_office_name"];
$manager_office_telnum = $_POST["manager_office_telnum"];
$local_sido = $_POST["local_sido"];
$local_sigugun = $_POST["local_sigugun"];
$manager_office_address = $_POST["manager_office_address"];
$manager_name = $_POST["manager_name"];
$manager_phonenum = $_POST["manager_phonenum"];
$manager_bankaccount = $_POST["manager_bankaccount"];
$manager_bankname = $_POST["manager_bankname"];
$kakaoemail = $_POST["kakaoemail"];



	$response["local_sido"] = $local_sido;
	$response["local_sigugun"] = $local_sigugun;

	$selectstate = mysqli_prepare($con, "SELECT local_code  FROM Local WHERE local_sido = ? and local_sigugun = ?");
	mysqli_stmt_bind_param($selectstate, "ss", $local_sido , $local_sigugun);
	mysqli_stmt_execute($selectstate);
	
	mysqli_stmt_bind_result($selectstate, $local_code);

	while(mysqli_stmt_fetch($selectstate))
	{
	$response["local_code"] = $local_code;

	}


$statement = mysqli_prepare($con, "INSERT INTO Manager (business_reg_num, manager_pw, manager_represent_name, manager_office_name, manager_office_telnum, local_code, manager_office_address, manager_name, manager_phonenum, manager_bankaccount, manager_bankname) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
mysqli_stmt_bind_param($statement, "sssssssssss", $business_reg_num, $manager_pw, $manager_represent_name, $manager_office_name, $manager_office_telnum, $local_code, $manager_office_address, $manager_name, $manager_phonenum, $manager_bankaccount, $manager_bankname);
mysqli_stmt_execute($statement);

if($kakaoemail != "0"){
	$data1 =  mysqli_query($con, "INSERT INTO ManagerKakao(kakao_email, business_reg_num) VALUES ('$kakaoemail','$business_reg_num')") or die(mysqli_error($con));
}

//echo $business_reg_num;
$response["success"]=mysqli_error($con);
    echo json_encode($response,JSON_UNESCAPED_UNICODE);
?>