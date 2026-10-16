<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 header("Location: login.php");
 exit();
}

$id = $_SESSION['student_id'];

// GET ISSUED BOOKS
$q = mysqli_query($conn,
"SELECT i.*, b.title, s.email
FROM issued_books i
JOIN books b ON i.book_id=b.id
JOIN students_login s ON i.student_id=s.id
WHERE i.student_id='$id' AND i.return_date IS NULL");

$today = date("Y-m-d");
?>

<html>
<head>
<title>Email Reminder</title>

<style>
body{
 font-family:Arial;
 background:#f2f2f2;
 padding:30px;
}

.box{
 background:white;
 padding:25px;
 border-radius:10px;
 width:500px;
 margin:auto;
 box-shadow:0 0 15px rgba(0,0,0,0.2);
}
</style>
</head>

<body>

<div class="box">

<h2>📧 Due Reminder</h2>

<?php
while($row = mysqli_fetch_assoc($q)){

$due = $row['due_date'];

// Check if due within 1 day
$days = (strtotime($due) - strtotime($today)) / (60*60*24);

if($days <= 1){

echo "<p>
📚 Book: <b>{$row['title']}</b><br>
📅 Due Date: {$row['due_date']}<br>
📧 Email sent to: {$row['email']}<br>
⚠️ Please return on time to avoid fine.
</p><hr>";
}
}
?>

<br>
<a href="dashboard.php">⬅ Back</a>

</div>

</body>
</html>
