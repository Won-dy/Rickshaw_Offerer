<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
$con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");



$worker_email =$_POST["worker_email"];  
$business_reg_num = $_POST["business_reg_num"];
$wr_contents = $_POST["wr_contents"];
$jp_num = $_POST["jp_num"];

$statement = mysqli_prepare($con, "INSERT INTO WorkerReview (worker_email, business_reg_num, jp_num, wr_contents ) VALUES (?,?,?,?)");
mysqli_stmt_bind_param($statement, "ssss", $worker_email, $business_reg_num,$jp_num, $wr_contents);
mysqli_stmt_execute($statement);
echo "success";
?>