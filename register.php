<?php include '../db.php'; ?>
<html>
<head>
<title>Student Register</title>

<style>
body{
 background:url('../images/bg.jpg') no-repeat center center/cover;
 font-family:Arial;
 height:100vh;
 display:flex;
 justify-content:center;
 align-items:center;
 margin:0;
}

.box{
 background:rgba(255,255,255,0.22);
 padding:40px;
 width:380px;
 border-radius:18px;
 backdrop-filter:blur(12px);
 text-align:center;
 color:black;
}

input{
 width:90%;
 padding:12px;
 margin:10px;
 border:none;
 border-radius:8px;
}

button{
 width:95%;
 padding:12px;
 background:#28a745;
 color:white;
 border:none;
 border-radius:8px;
 font-size:18px;
 cursor:pointer;
}

.popup{
 position:fixed;
 top:0;
 left:0;
 width:100%;
 height:100%;
 background:rgba(0,0,0,0.7);
 display:none;
 justify-content:center;
 align-items:center;
}

.popup-box{
 background:white;
 padding:30px 40px;
 border-radius:12px;
 text-align:center;
 box-shadow:0 0 30px rgba(0,0,0,0.5);
}

.popup-box h2{
 color:#28a745;
}
</style>
</head>

<body>

<div class="box">

<h2>📝 Student Register</h2>

<form method="post">

<input type="text" name="name" placeholder="Username" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="pass" placeholder="Password" required>

<input type="text" name="course" placeholder="Course (e.g. BSc CS)" required>

<input type="text" name="mobile" placeholder="Mobile Number" required>

<button name="register">Register</button>

</form>

<a href="login.php" style="color:blue;">🔐 Login Here</a>

</div>

<div class="popup" id="successPopup">
  <div class="popup-box">
    <h2>✔️ Registration Successful</h2>
    <p>Your account has been created.</p>
    <button onclick="goLogin()">Login Now</button>
  </div>
</div>

<?php
if(isset($_POST['register'])){

$name=$_POST['name'];
$email=$_POST['email'];
$pass=$_POST['pass'];
$course=$_POST['course'];
$mobile=$_POST['mobile'];

mysqli_query($conn,"INSERT INTO students
(student_name,email,password,course,mobile)
VALUES('$name','$email','$pass','$course','$mobile')");

echo "<script>
document.getElementById('successPopup').style.display='flex';
</script>";

}
?>

<script>
function goLogin(){
 window.location='login.php';
}
</script>

</body>
</html>
