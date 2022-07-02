<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<?php
    ini_set("memory_limit",-1);
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
    $response = array();

        $business_reg_num = $_POST['business_reg_num'];
        $key = $_POST['k'];
        if($key==0){  // 구인자가 구직자에게 쓰는 리뷰

            $job_date=[];
            $field_name=[];
            $worker_name=[];
            $worker_email=[];
            $wr_datetime=[];
            $jp_num=[];
            $a=0;
            $k=0;

            $getreview = mysqli_query($con, "SELECT jp_num, worker_email, wr_datetime FROM WorkerReview WHERE business_reg_num='$business_reg_num'");
            while($row1 =mysqli_fetch_array($getreview)) {
                $jp_num[] = $row1[0];
                $worker_email[] = $row1[1];
                $wr_datetime[] = $row1[2];
                $a++;
            }
            for($i=0; $i<$a; $i++){
            $get_name =  mysqli_query($con, "SELECT worker_name FROM Worker Where worker_email='$worker_email[$i]'");
            while($row1 =mysqli_fetch_array($get_name)) {
                $worker_name[] = $row1[0];
            }

            $get_fieldinfo = mysqli_query($con, "SELECT JobPosting.jp_job_date, Field.field_name FROM JobPosting JOIN Field ON JobPosting.jp_num = Field.jp_num Where JobPosting.jp_num='$jp_num[$i]'");
            while($row1 =mysqli_fetch_array($get_fieldinfo)) {
                $job_date[] = $row1[0];
                $field_name[] = $row1[1];
            }

        }

            $getreview1 = mysqli_query($con, "SELECT wr_contents FROM WorkerReview WHERE business_reg_num='$business_reg_num'");
            while($row1 =mysqli_fetch_array($getreview1)) {
                array_push($response, array('name'=>$worker_name[$k],'contents'=>$row1[0],'date'=>$job_date[$k],'fieldname'=>$field_name[$k],'workerEmail'=>$worker_email[$k], 'jpNum'=>$jp_num[$k], 'wr_datetime'=>$wr_datetime[$k]));
                $k++;
            }

        }
        if($key==1){
            $worker_name1=[];
            $getnickname = mysqli_query($con, "SELECT Worker.worker_name FROM OfficeReview JOIN Worker ON OfficeReview.worker_email=Worker.worker_email WHERE OfficeReview.business_reg_num='$business_reg_num'");
            while($row1 =mysqli_fetch_array($getnickname)) {
                $worker_name1[] = $row1[0];
            }
            $i=0;
            $getWorkerreview3 =  mysqli_query($con, "SELECT or_contents, or_datetime FROM OfficeReview WHERE business_reg_num='$business_reg_num'");
            while($row =mysqli_fetch_array($getWorkerreview3)) {
                array_push($response, array('name'=>$worker_name1[$i],'contents'=>$row[0],'datetime'=>$row[1]));
                $i++;
            }
            
        }
        if($key==2){  // 구직자 리뷰
            $getWorkerReview = mysqli_query($con, "SELECT Manager.manager_office_name, WorkerReview.wr_contents, WorkerReview.wr_datetime FROM WorkerReview JOIN Manager ON Manager.business_reg_num=WorkerReview.business_reg_num WHERE WorkerReview.worker_email='$business_reg_num'");
            while($row2 =mysqli_fetch_array($getWorkerReview)) {
                array_push($response, array('office_name'=>$row2[0], 'contents'=>$row2[1], 'datetime'=>$row2[2]));
            }            
        }

        echo json_encode(array('response'=>$response), JSON_UNESCAPED_UNICODE);
?>