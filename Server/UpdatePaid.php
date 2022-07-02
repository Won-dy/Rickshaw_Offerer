<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
$con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");



$worker_email =$_POST["worker_email"];  
$field_code = $_POST["field_code"];

$statement = mysqli_prepare($con, "UPDATE MyField SET mf_is_paid = '1' WHERE MyField.worker_email= ? AND MyField.field_code = ?");
mysqli_stmt_bind_param($statement,"ss",$worker_email,$field_code);

mysqli_stmt_execute($statement);
echo "success";
?>