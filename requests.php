<?php
session_start();
include '../db.php';
?>

<html>
<head>
<title>Book Requests</title>

<style>
body{
 font-family:Arial;
 background:#f2f2f2;
 margin:0;
}

.container{
 padding:30px;
}

table{
 width:90%;
 background:white;
 border-collapse:collapse;
 margin:auto;
}

th,td{
 padding:12px;
 border:1px solid #ccc;
 text-align:center;
}

button{
 padding:6px 12px;
 border:none;
 border-radius:5px;
 cursor:pointer;
}

.approve{ background:#28a745; color:white; }
.reject{ background:#dc3545; color:white; }
</style>
</head>

<body>

<div class="container">

<h1 align="center">📥 Book Requests</h1>

<table>

<tr>
<th>Student Name</th>
<th>Book Title</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,
"SELECT r.*, s.student_name, b.book_name
FROM book_requests r
JOIN students s ON r.student_id = s.student_id
JOIN books b ON r.book_id = b.book_id");

if($q && mysqli_num_rows($q)>0){

while($row = mysqli_fetch_assoc($q)){

echo "<tr>
<td>{$row['student_name']}</td>
<td>{$row['book_name']}</td>
<td>{$row['status']}</td>
<td>";

if($row['status']=='Pending'){
 echo "
<form method='post' style='display:inline'>
<input type='hidden' name='id' value='{$row['id']}'>
<button name='approve' class='approve'>Approve</button>
</form>

<form method='post' style='display:inline'>
<input type='hidden' name='id' value='{$row['id']}'>
<button name='reject' class='reject'>Reject</button>
</form>";
}

echo "</td></tr>";
}

}else{
 echo "<tr><td colspan='4'>No Requests Found ❌</td></tr>";
}
?>

</table>

</div>

<?php
// ===== APPROVE =====
if(isset($_POST['approve'])){

$id = $_POST['id'];

mysqli_query($conn,
"UPDATE book_requests SET status='Approved' WHERE id='$id'");

// 📚 Full data ghe
$r = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT r.*, b.book_name 
FROM book_requests r
JOIN books b ON r.book_id = b.book_id
WHERE r.id='$id'"));

$student = $r['student_id'];
$book = $r['book_id'];
$book_name = $r['book_name'];

$issue = date("Y-m-d");
$due = date("Y-m-d", strtotime("+5 days"));

// 📖 Insert issued book
// ➖ Decrease book quantity
mysqli_query($conn,
"UPDATE books 
SET quantity = quantity - 1 
WHERE book_id='$book'");

mysqli_query($conn,
"INSERT INTO issued_books(student_id,book_id,issue_date,due_date,status)
VALUES('$student','$book','$issue','$due','Issued')");

// 🔔 Notification 1: Approved
$msg1 = "✅ Book Approved: $book_name";

mysqli_query($conn,
"INSERT INTO notifications (student_id, message)
VALUES ('$student', '$msg1')");

// 🔔 Notification 2: Issued
$msg2 = "📖 Book Issued: $book_name on ".date("d-m-Y h:i A");

mysqli_query($conn,
"INSERT INTO notifications (student_id, message)
VALUES ('$student', '$msg2')");

// 🔔 Notification 3: Return date
$msg3 = "📅 Return $book_name before $due";

mysqli_query($conn,
"INSERT INTO notifications (student_id, message)
VALUES ('$student', '$msg3')");

echo "<script>
alert('✔️ Book Approved & Issued Successfully');
window.location='requests.php';
</script>";
}


// ===== REJECT =====
if(isset($_POST['reject'])){

$id = $_POST['id'];

// 📚 data ghe
$r = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT r.*, b.book_name 
FROM book_requests r
JOIN books b ON r.book_id = b.book_id
WHERE r.id='$id'"));

$student = $r['student_id'];
$book_name = $r['book_name'];

mysqli_query($conn,
"UPDATE book_requests SET status='Rejected' WHERE id='$id'");

// 🔔 Notification: Rejected
$msg = "❌ Book Request Rejected: $book_name";

mysqli_query($conn,
"INSERT INTO notifications (student_id, message)
VALUES ('$student', '$msg')");

echo "<script>
alert('❌ Request Rejected');
window.location='requests.php';
</script>";
}
?>

</body>
</html>