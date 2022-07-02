<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
 header('Content-Type: application/json; charset=utf-8');

$con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");

$business_reg_num = $_POST['business_reg_num'];
$manager_name =  $_POST['manager_name'];
$response = array();
$response['tryinquiry'] = false;

$data1 =  mysqli_query($con, "SELECT business_reg_num, manager_represent_name FROM BusinessRegistration WHERE business_reg_num='$business_reg_num' AND manager_represent_name ='$manager_name'") or die(mysqli_error($con));
while($row = mysqli_fetch_array($data1)){  
    $response['tryinquiry'] = true;
}

echo json_encode($response,JSON_UNESCAPED_UNICODE);
?>