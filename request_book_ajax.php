<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 echo "Login Required ❌";
 exit();
}

$id = $_SESSION['student_id'];
$book_id = $_POST['book_id'];

mysqli_query($conn,
"INSERT INTO book_requests(student_id,book_id,status)
VALUES('$id','$book_id','Pending')");

echo "✔️ Book Requested Successfully";
?>
