<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 exit();
}

$id = $_SESSION['student_id'];

$q = mysqli_query($conn,
"SELECT * FROM issued_books
WHERE student_id='$id'
AND status='Returned'
AND return_date = CURDATE()");

if(mysqli_num_rows($q) > 0){
 echo "updated";
}
?>
