<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
    header('Content-Type: application/json; charset=utf-8');
    $con = mysqli_connect("localhost", "rickshaw", "capstone1!", "rickshaw");
    if($con)
    {
    echo " connect : success 성공 <br>";
    }
    else
    {
    echo "disconnect : fail <br>";
    }

    $statement = mysqli_query($con, "SELECT * FROM Job");

    $response = array();

    while($row = mysqli_fetch_array($statement)){
        array_push($response, array('job_code'=>$row[0], 'job_name'=>$row[1]));
    }

    echo json_encode(array("response"=>$response), JSON_UNESCAPED_UNICODE);

    mysqli_close($con);
?>