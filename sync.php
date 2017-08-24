<?php

include('db_config.php');
if(isset($_POST["jsonArray"]))
	{
	$jsonArray=$_POST["jsonArray"];
	}
////
////echo $jsonArray;
//// saving received json data into a file
$file = 'c://jsonArrayProRecSyncData.json';
file_put_contents($file, $jsonArray);
// retrieving json data from a file
$json_read = file_get_contents("c://jsonArrayProRecSyncData.json");
$json_dec = json_decode($json_read, true);

$mobile_no = "";
$lat = "";
$lng = "";
$pincode = "";
$salary = "";
$age = "";
$calllogs = "";
$contacts = "";
$facebook = "";
$accelerometer = "";
$magnetometer = "";
$jsonIterator = new RecursiveIteratorIterator(
        new RecursiveArrayIterator($json_dec), RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    if (is_array($val)) {   //support for latest android mobiles eg Android 5.0
//      echo "$key:";
        echo "<br>";

        if (strpos($key, "0") !== false) {
//          echo "test<br>";

            $jsonIterator1 = new RecursiveIteratorIterator(
                    new RecursiveArrayIterator($val), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($jsonIterator1 as $key => $val) {
                if ($val) {   //support for latest android mobiles eg Android 5.0
//                    echo "$key : $val";
//                    echo "<br>";

                    if (strpos($key, "mobile") !== false) {
                        $mobile_no = $val;
                    } else if (strpos($key, "lat") !== false) {
                        $lat = $val;
                    } else if (strpos($key, "lng") !== false) {
                        $lng = $val;
                    } else if (strpos($key, "pincode") !== false) {
                        $pincode = $val;
                    } else if (strpos($key, "salary") !== false) {
                        $salary = $val;
                    } else if (strpos($key, "age") !== false) {
                        $age = $val;
                    } else if (strpos($key, "calllogs") !== false) {
                        $calllogs = $val;
                    } else if (strpos($key, "contacts") !== false) {
                        $contacts = $val;
                    } else if (strpos($key, "facebook") !== false) {
                        $facebook = $val;
                    } else if (strpos($key, "accelerometer") !== false) {
                        $accelerometer = $val;
                    } else if (strpos($key, "magnetometer") !== false) {
                        $magnetometer = $val;
                    }
                }
            }

            //location infos
            $qry = "INSERT INTO location_infos VALUES ('$mobile_no', '$lat', '$lng', '','$pincode')";
            $result = mysqli_query($con, $qry);

            
            //extra infos
            $result1 = mysqli_query($con, "SELECT * FROM other_infos where mobile_no='$mobile_no'");
            $row = mysqli_fetch_array($result1);
            $data = $row[0];
            
            if($data){
                $qry2 = "UPDATE other_infos SET salary='$salary',age='$age',call_logs='$calllogs',contacts='$contacts',facebook='$facebook',accelerometer='$accelerometer',magnetometer='$magnetometer' WHERE mobile_no='$mobile_no'";
                $result2 = mysqli_query($con, $qry2);
//                echo "1".$qry2;
            } else {
                $qry3 = "INSERT INTO other_infos VALUES ('$mobile_no', '$contacts', '$calllogs', '$facebook', '$accelerometer','$magnetometer', '$salary','$age')";
                $result2 = mysqli_query($con, $qry3);
//                echo "2".$qry3;
            }

            
            if ($result && $result2) {
                echo "Success";
            } else {
                echo "Error: " . $qry . "<br>" . mysqli_error($con);
            }

            mysqli_close($con);
        }
    }
}

?>