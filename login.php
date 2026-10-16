<!DOCTYPE html>
<html>
<head>
<title>Student Login</title>

<style>
body{
 margin:0;
 font-family:Arial;

 background:
   linear-gradient(rgba(0,0,0,0.55),
                   rgba(0,0,0,0.55)),
   url('../images/bg.jpg');

 background-size: cover;
 background-position: center;
 background-attachment: fixed;

 display:flex;
 justify-content:center;
 align-items:center;
 height:100vh;
}

.box{
 background:rgba(255,255,255,0.18);
 backdrop-filter: blur(12px);
 padding:35px;
 border-radius:15px;
 width:320px;
 text-align:center;
 box-shadow:0 0 30px rgba(0,0,0,0.6);
 border:1px solid rgba(255,255,255,0.4);
 color:white;
}

input{
 width:90%;
 padding:12px;
 margin:10px;
 border:none;
 border-radius:8px;
 font-size:16px;
}

button{
 width:95%;
 padding:12px;
 background:#0072ff;
 color:white;
 border:none;
 border-radius:8px;
 font-size:18px;
 cursor:pointer;
}

button:hover{
 background:#0056cc;
}

.links{
 margin-top:15px;
 font-size:14px;
}

.links a{
 color:#00e5ff;
 text-decoration:none;
 font-weight:bold;
}

.links a:hover{
 text-decoration:underline;
}

/* 🔥 MESSAGE STYLE */
#msgBox{
 display:none;
 margin-top:10px;
 font-size:14px;
 font-weight:bold;
}
</style>

</head>

<body>

<div class="box">

<h2>👨‍🎓 Student Login</h2>

<form id="loginForm">
<input type="text" name="login_id" placeholder="Email or Mobile" required>
<input type="password" name="pass" placeholder="Password" required>
<button type="submit">Login</button>
</form>

<!-- 🔥 MESSAGE -->
<div id="msgBox"></div>

<div class="links">
New Student? 👉 
<a href="register.php">Register Here</a>
</div>

</div>

<!-- 🔥 JAVASCRIPT (NO PAGE RELOAD) -->
<script>
document.getElementById("loginForm").addEventListener("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("login_check.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        let msgBox = document.getElementById("msgBox");

        if(data.status === "success"){
            window.location.href = "dashboard.php";
        } else {
            msgBox.style.display = "block";
            msgBox.style.color = "red";
            msgBox.innerText = data.message;
        }
    });
});
</script>

</body>
</html>