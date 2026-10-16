<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 echo "Login Required ❌";
 exit();
}

$student_id = $_SESSION['student_id'];
$id = $_POST['id'];

// 📚 Book info ghe
$q = mysqli_query($conn,
"SELECT i.*, b.book_name 
FROM issued_books i
JOIN books b ON i.book_id = b.book_id
WHERE i.id='$id'");

$row = mysqli_fetch_assoc($q);

if(!$row){
 echo "Book not found ❌";
 exit();
}

$book_name = $row['book_name'];

// 🔁 Status update
mysqli_query($conn,
"UPDATE issued_books
SET status='Return Pending'
WHERE id='$id'");

// 🔔 Notification (FIXED)
$msg = "🔁 Return request sent for $book_name";

mysqli_query($conn,
"INSERT INTO notifications (student_id, message)
 SELECT '$student_id', '$msg'
 WHERE NOT EXISTS (
   SELECT 1 FROM notifications 
   WHERE student_id='$student_id' AND message='$msg'
 )");

echo "✔️ Return Request Sent to Admin";
?>