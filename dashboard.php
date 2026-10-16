<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db.php';

// 🔒 LOGIN CHECK
if(!isset($_SESSION['student_id'])){
 echo "Session not found. Please login again.";
 exit();
}

$id = $_SESSION['student_id'];


// 🔎 FETCH STUDENT DATA
$q1 = mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$id'");

if(!$q1 || mysqli_num_rows($q1) == 0){
 echo "Student record not found";
 exit();
}

$data = mysqli_fetch_assoc($q1);


// 📥 PENDING REQUEST COUNT
$q2 = mysqli_query($conn,
"SELECT * FROM book_requests 
 WHERE student_id='$id' AND status='Pending'");
$req = $q2 ? mysqli_num_rows($q2) : 0;


// 📖 ISSUED BOOK COUNT
$q3 = mysqli_query($conn,
"SELECT * FROM issued_books 
 WHERE student_id='$id' AND return_date IS NULL");
$iss = $q3 ? mysqli_num_rows($q3) : 0;


// 🔔 UNREAD NOTIFICATION COUNT
$noti = 0;
$qn = mysqli_query($conn,
"SELECT COUNT(*) as total 
 FROM notifications 
 WHERE student_id='$id' AND is_read=0");

if($qn){
 $noti = mysqli_fetch_assoc($qn)['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Dashboard</title>

<style>
body{
 margin:0;
 font-family:Arial;

 background:
   linear-gradient(rgba(0,0,0,0.55),
                   rgba(0,0,0,0.55)),
   url('../images/Library%20collage.jpg');

 background-size: cover;
 background-position: center;
 background-attachment: fixed;
 color:white;
}

/* HEADER */
.header{
 background:#0d47a1;
 color:white;
 padding:15px 25px;
 font-size:20px;
}

/* SIDEBAR */
.sidebar{
 width:220px;
 height:100vh;
 background:#1565c0;
 color:white;
 position:fixed;
 top:50px;
}

.sidebar a{
 display:block;
 padding:15px;
 color:white;
 text-decoration:none;
 position:relative;
}

.sidebar a:hover{
 background:#0d47a1;
}

/* 🔴 BADGE */
.badge{
 position:absolute;
 right:15px;
 top:15px;
 background:red;
 color:white;
 padding:3px 8px;
 border-radius:50%;
 font-size:12px;
}

/* MAIN */
.main{
 margin-left:220px;
 margin-top:50px;
 padding:30px;
}

/* CARDS */
.card{
 background:rgba(255,255,255,0.95);
 color:#333;
 padding:20px;
 margin:15px;
 border-radius:10px;
 box-shadow:0 0 15px rgba(0,0,0,0.4);
 display:inline-block;
 width:220px;
 text-align:center;
}
</style>
</head>

<body>

<div class="header">
📚 Suryadatta College Library — Student Panel
</div>

<div class="sidebar">

<a href="dashboard.php">🏠 Dashboard</a>

<a href="profile.php">👤 My Profile</a>

<a href="search_books.php">🔍 Search Books</a>

<a href="my_requests.php">
📥 My Requests 
<?php if($req > 0){ echo "<span class='badge'>$req</span>"; } ?>
</a>

<a href="issued_books.php">
📖 Issued Books 
<?php if($iss > 0){ echo "<span class='badge'>$iss</span>"; } ?>
</a>

<a href="notices.php">
📢 Notices 
<?php if($noti > 0){ echo "<span class='badge'>$noti</span>"; } ?>
</a>

<!-- 🔥 NEW PAYMENT OPTION -->
<a href="payment.php">💳 Payment</a>

<a href="logout.php">🚪 Logout</a>

</div>

<div class="main">

<h1>Welcome, <?php echo htmlspecialchars($data['student_name']); ?> 👋</h1>

<div class="card">
<h3>📥 Pending Requests</h3>
<h2><?php echo $req; ?></h2>
</div>

<div class="card">
<h3>📖 Issued Books</h3>
<h2><?php echo $iss; ?></h2>
</div>

<div class="card">
<h3>🎓 Course</h3>
<p><?php echo htmlspecialchars($data['course']); ?></p>
</div>

<div class="card">
<h3>📱 Mobile</h3>
<p><?php echo htmlspecialchars($data['mobile']); ?></p>
</div>

</div>

</body>
</html>