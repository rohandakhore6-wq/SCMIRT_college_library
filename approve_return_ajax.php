<?php
session_start();
include '../db.php';

if(!isset($_POST['id'])){
 echo "❌ Invalid Request";
 exit();
}

$id = $_POST['id'];

// 🔎 Get book info
$q = mysqli_query($conn,
"SELECT book_id, status, student_id 
FROM issued_books 
WHERE id='$id'");

if(mysqli_num_rows($q) == 0){
 echo "❌ Record not found";
 exit();
}

$data = mysqli_fetch_assoc($q);

// ❌ Already returned check
if($data['status'] == 'Returned'){
 echo "⚠️ Already Returned";
 exit();
}

$book_id = $data['book_id'];
$student_id = $data['student_id'];

// ✔️ Mark as Returned
mysqli_query($conn,
"UPDATE issued_books
SET status='Returned',
return_date = CURDATE()
WHERE id='$id'");

// ➕ Increase book quantity (FIXED)
mysqli_query($conn,
"UPDATE books 
SET quantity = quantity + 1
WHERE book_id='$book_id'");

// 🔔 Notification
$msg = "📚 Book Returned Successfully";

mysqli_query($conn,
"INSERT INTO notifications (student_id, message)
VALUES ('$student_id', '$msg')");

echo "✔️ Book Returned Successfully";
?>