<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 header("Location: login.php");
 exit();
}

$id = $_SESSION['student_id'];

/* 🔥 SAFE QUERY */
$sql = "
SELECT r.*, 
       s.student_name, 
       b.book_name
FROM book_requests r
LEFT JOIN students s 
       ON r.student_id = s.student_id
LEFT JOIN books b 
       ON r.book_id = b.book_id
WHERE r.student_id = '$id'
";

$q = mysqli_query($conn, $sql);
?>

<html>
<head>
<title>My Book Requests</title>

<style>
body{
 margin:0;
 font-family:Arial;

 background:
   linear-gradient(rgba(0,0,0,0.45),
                   rgba(0,0,0,0.45)),
   url('../images/Library%20collage.jpg');

 background-size: cover;
 background-position: center;
 background-attachment: fixed;
 color:white;
}

.container{ padding:30px; }

table{
 width:80%;
 background:rgba(255,255,255,0.95);
 color:black;
 border-collapse:collapse;
 border-radius:10px;
 overflow:hidden;
 box-shadow:0 0 20px rgba(0,0,0,0.6);
}

th{ background:#2196F3; color:white; }

th,td{
 padding:12px;
 border:1px solid #ccc;
 text-align:center;
}

.back{
 color:white;
 font-weight:bold;
 text-decoration:none;
}
</style>
</head>

<body>

<div class="container">

<h1>📥 My Book Requests</h1>

<table>

<tr>
<th>Student Name</th>
<th>Book Title</th>
<th>Status</th>
</tr>

<?php
if($q && mysqli_num_rows($q)>0){

 while($row = mysqli_fetch_assoc($q)){

  $name  = $row['student_name'] ?? 'Unknown';
  $book  = $row['book_name'] ?? 'Unknown';
  $status= $row['status'] ?? '-';

  echo "<tr>
  <td>$name</td>
  <td>$book</td>
  <td>$status</td>
  </tr>";
 }

}else{
 echo "<tr><td colspan='3'>No Requests Found ❌</td></tr>";
}
?>

</table>

<br>
<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

</div>

</body>
</html>