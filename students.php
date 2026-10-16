<?php
session_start();
include '../db.php';

$s = mysqli_query($conn,"SELECT * FROM students");
?>

<html>
<head>
<title>Students List</title>

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
 width:95%;
 background:white;
 border-collapse:collapse;
 margin:auto;
 box-shadow:0 0 15px rgba(0,0,0,0.3);
}

th{
 background:#2196F3;
 color:white;
}

th,td{
 padding:12px;
 border:1px solid #ccc;
 text-align:center;
}

.delete{
 background:#dc3545;
 color:white;
 padding:6px 12px;
 border:none;
 border-radius:5px;
 cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<h1 align="center">👨‍🎓 Students List</h1>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Course</th>
<th>Mobile</th>
<th>📖 Issued Books</th>
<th>🔄 Return Pending</th>
<th>💰 Pending Fine</th> <!-- 🔥 NEW COLUMN -->
<th>Action</th>
</tr>

<?php
while($row = mysqli_fetch_assoc($s)){

$id = $row['student_id'];

// 📖 Issued count
$issued_q = mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM issued_books 
WHERE student_id='$id'");

$issued = mysqli_fetch_assoc($issued_q)['total'];

// 🔄 Pending return
$pending_q = mysqli_query($conn,"
SELECT COUNT(*) as total 
FROM issued_books 
WHERE student_id='$id' AND status='Return Pending'");

$pending = mysqli_fetch_assoc($pending_q)['total'];

// 💰 CALCULATE TOTAL FINE
$fine_q = mysqli_query($conn,"
SELECT * FROM issued_books 
WHERE student_id='$id' AND return_date IS NULL
");

$total_fine = 0;
$today = date("Y-m-d");

while($f = mysqli_fetch_assoc($fine_q)){
    $due = $f['due_date'];

    if($today > $due){
        $days = floor((strtotime($today) - strtotime($due)) / (60*60*24));
        $total_fine += ($days * 5);
    }
}

echo "<tr>
<td>{$row['student_id']}</td>
<td>{$row['student_name']}</td>
<td>{$row['email']}</td>
<td>{$row['course']}</td>
<td>{$row['mobile']}</td>
<td>$issued</td>
<td style='color:red;font-weight:bold;'>$pending</td>
<td style='color:green;font-weight:bold;'>₹$total_fine</td>
<td>
<form method='post'>
<input type='hidden' name='id' value='{$row['student_id']}'>
<button name='delete' class='delete'>Delete</button>
</form>
</td>
</tr>";
}
?>

</table>

<?php
if(isset($_POST['delete'])){
$id = $_POST['id'];

mysqli_query($conn,"DELETE FROM issued_books WHERE student_id='$id'");
mysqli_query($conn,"DELETE FROM book_requests WHERE student_id='$id'");
mysqli_query($conn,"DELETE FROM notifications WHERE student_id='$id'");
mysqli_query($conn,"DELETE FROM students WHERE student_id='$id'");

echo "<script>alert('Student Deleted ✔️'); location.reload();</script>";
}
?>

<br>
<a href="dashboard.php">⬅ Back to Dashboard</a>

</div>

</body>
</html>