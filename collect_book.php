<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 header("Location: login.php");
 exit();
}

/* 🔥 FIX — check book_id exists */
if(!isset($_GET['book_id'])){
 echo "Invalid request";
 exit();
}

$student_id = $_SESSION['student_id'];
$book_id = $_GET['book_id'];


// 🔎 Check — already issued same book?
$check = mysqli_query($conn,
"SELECT * FROM issued_books
WHERE student_id='$student_id'
AND book_id='$book_id'
AND status!='Returned'");

if(mysqli_num_rows($check) > 0){
 echo "<script>alert('❌ You already have this book'); 
       window.location='dashboard.php';</script>";
 exit();
}


// 🔎 Check — stock available?
$stock = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT quantity FROM books WHERE id='$book_id'"));

if($stock['quantity'] <= 0){
 echo "<script>alert('❌ Book not available'); 
       window.location='dashboard.php';</script>";
 exit();
}


// 📖 Issue book
$issue = date("Y-m-d");
$due = date("Y-m-d", strtotime("+5 days"));

mysqli_query($conn,
"INSERT INTO issued_books
(student_id, book_id, issue_date, due_date, status)
VALUES('$student_id','$book_id','$issue','$due','Issued')");


// ➖ Reduce stock
mysqli_query($conn,
"UPDATE books SET quantity = quantity - 1
WHERE id='$book_id'");


echo "<script>alert('✔️ Book Issed Successfully'); 
      window.location='dashboard.php';</script>";
?>
