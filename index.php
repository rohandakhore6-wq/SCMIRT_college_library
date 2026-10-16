<html>
<head>
<title>Library System</title>

<style>
body{
 background: url('images/bg.jpg') no-repeat center center/cover;
 font-family: Arial, sans-serif;
 margin:0;
 height:100vh;
 display:flex;
 flex-direction:column;
 justify-content:flex-start;
 align-items:center;
 padding-top:80px;
}

/* ===== WELCOME TEXT ===== */
.welcome{
 font-size:42px;
 margin-bottom:120px;
 font-weight:bold;
 color:white;
 animation: colorChange 6s infinite;
 text-shadow:0 0 10px rgba(0,0,0,0.8);
}

/* COLOR CHANGE ANIMATION */
@keyframes colorChange{
 0%   { color:#ffffff; }
 33%  { color:#00e5ff; }
 66%  { color:#ffd700; }
 100% { color:#ffffff; }
}

/* ===== GLASS LOGIN BOX ===== */
.box{
 background: rgba(255,255,255,0.20);
 padding:45px;
 width:360px;
 border-radius:15px;
 box-shadow:0 0 40px rgba(0,0,0,0.4);
 backdrop-filter: blur(10px);
 text-align:center;
 border:1px solid rgba(255,255,255,0.4);
}

/* LOGIN TEXT */
.login-text{
 font-size:22px;
 font-weight:bold;
 color:white;
 margin-bottom:25px;
}

/* BUTTONS */
a{
 display:block;
 margin:15px 0;
 padding:15px;
 background: rgba(255,255,255,0.25);
 color:white;
 text-decoration:none;
 border-radius:10px;
 font-size:18px;
 transition:0.3s;
 border:1px solid rgba(255,255,255,0.5);
}

/* HOVER */
a:hover{
 background: rgba(0,114,255,0.9);
 transform:scale(1.05);
}
</style>
</head>

<body>

<div class="welcome">
📚 Welcome to Suryadatta College Library
</div>

<div class="box">

<div class="login-text">Login / Register Here</div>

<a href="student/login.php">👨‍🎓 Student</a>



<a href="admin/login.php">👨‍💼 Admin</a>


</div>

</body>
</html>
