<?php
include('db_config.php');

$mobile_no = $_POST['mobile_no'];
$password = $_POST['password'];
//$mobile_no = '9876543210';
//$password = 'yuvraj';
$result = mysqli_query($con,"SELECT mobile_no FROM accounts where mobile_no='$mobile_no' and password='$password'");
$row = mysqli_fetch_array($result);
$data = $row[0];

if($data){
echo 'success';
}
mysqli_close($con);
?>