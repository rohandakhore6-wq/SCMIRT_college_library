<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 header("Location: login.php");
 exit();
}

$id = $_SESSION['student_id'];
?>

<html>
<head>
<title>Library Notices</title>

<style>
body{
 margin:0;
 font-family:Arial;
 background:#f4f6f9;
}

/* HEADER */
.header{
 background:#0d47a1;
 color:white;
 padding:18px;
 font-size:28px;
 text-align:center;
}

/* MAIN */
.container{
 padding:40px;
 text-align:center;
}

/* 🔥 NOTICE BOX */
.notice{
 background:white;
 padding:35px;
 margin:25px auto;
 border-radius:15px;
 width:80%;
 box-shadow:0 0 20px rgba(0,0,0,0.2);
}

/* 🔥 COLOR TEXT */
.notice-text{
 font-size:30px;
 font-weight:bold;
 animation: colorChange 5s infinite;
}

/* DATE */
.date{
 margin-top:15px;
 color:#777;
 font-size:16px;
}

/* ✅ FIXED ANIMATION */
@keyframes colorChange{
 0%   { color:#e53935; }
 25%  { color:#1e88e5; }
 50%  { color:#43a047; }
 75%  { color:#fb8c00; }
 100% { color:#e53935; }
}

/* BACK BUTTON */
.back{
 display:inline-block;
 margin-top:30px;
 padding:12px 22px;
 background:#2196F3;
 color:white;
 text-decoration:none;
 border-radius:8px;
 font-size:18px;
}

.back:hover{
 background:#0d47a1;
}
</style>
</head>

<body>

<div class="header">
📢 Library Notices
</div>

<div class="container">

<?php
// 🔥 GET ALL NOTIFICATIONS FOR STUDENT
$n = mysqli_query($conn,
"SELECT * FROM notifications 
WHERE student_id='$id'
ORDER BY id DESC");

if($n && mysqli_num_rows($n) > 0){

 while($row = mysqli_fetch_assoc($n)){
  echo "<div class='notice'>
  <div class='notice-text'>
  {$row['message']}
  </div>
  <div class='date'>
  📅 ".date("d-m-Y h:i A", strtotime($row['created_at']))."
  </div>
  </div>";
 }

}else{
 echo "<h2>No notifications available 📭</h2>";
}
?>

<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

</div>

</body>
</html>