<?php
session_start();
include '../db.php';

header('Content-Type: text/html; charset=utf-8');

if(!isset($_SESSION['student_id'])){
    header("Location: login.php");
    exit();
}

$id = $_SESSION['student_id'];

/* 🔥 AJAX REQUEST HANDLE */
if(isset($_POST['action'])){

    header('Content-Type: application/json');

    if($_POST['action'] == "update_profile"){

        $name   = trim($_POST['name']);
        $course = trim($_POST['course']);
        $mobile = trim($_POST['mobile']);

        $oldData = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM students WHERE student_id='$id'"));

        $changes = [];

        if($oldData['student_name'] != $name) $changes[] = "name";
        if($oldData['course'] != $course) $changes[] = "course";
        if($oldData['mobile'] != $mobile) $changes[] = "mobile number";

        mysqli_query($conn,
        "UPDATE students SET 
        student_name='$name',
        course='$course',
        mobile='$mobile'
        WHERE student_id='$id'");

        if(count($changes) == 0){
            echo json_encode([
                "status"=>"success",
                "title"=>"No Changes",
                "message"=>"Nothing updated 😅"
            ]);
        } else {
            echo json_encode([
                "status"=>"success",
                "title"=>"Updated ✅",
                "message"=>"Updated your ".implode(", ",$changes)
            ]);
        }
        exit();
    }

    if($_POST['action'] == "change_password"){

        $old = $_POST['old'];
        $new = $_POST['new'];

        $q = mysqli_query($conn,
        "SELECT * FROM students 
        WHERE student_id='$id' AND password='$old'");

        if(mysqli_num_rows($q)>0){

            mysqli_query($conn,
            "UPDATE students SET password='$new' 
            WHERE student_id='$id'");

            echo json_encode([
                "status"=>"success",
                "title"=>"Done 🎉",
                "message"=>"Password Changed Successfully"
            ]);
        } else {
            echo json_encode([
                "status"=>"error",
                "title"=>"Error ❌",
                "message"=>"Old Password Wrong"
            ]);
        }
        exit();
    }
}

/* NORMAL LOAD */
$data = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE student_id='$id'"));
?>

<!DOCTYPE html>
<html>
<head>
<title>My Profile</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
 margin:0;
 font-family:Arial;
 background:
   linear-gradient(rgba(0,0,0,0.5),
                   rgba(0,0,0,0.5)),
   url('../images/Library%20collage.jpg');
 background-size:cover;
 color:white;
}

.container{ padding:30px; }

.box{
 background:rgba(255,255,255,0.95);
 color:black;
 padding:25px;
 width:420px;
 border-radius:15px;
 margin-bottom:25px;
 box-shadow:0 0 20px rgba(0,0,0,0.6);
}

input{
 width:95%;
 padding:12px;
 margin:8px 0;
 border-radius:8px;
 border:1px solid #ccc;
}

button{
 padding:12px;
 background:#0072ff;
 color:white;
 border:none;
 border-radius:8px;
 width:100%;
 cursor:pointer;
}

button:hover{ background:#0056cc; }
</style>
</head>

<body>

<div class="container">

<h1>👤 My Profile</h1>

<div class="box">
<h3>Edit Details</h3>

<form id="profileForm">
<input type="text" name="name" value="<?php echo $data['student_name']; ?>">
<input type="text" name="course" value="<?php echo $data['course']; ?>">
<input type="text" name="mobile" value="<?php echo $data['mobile']; ?>">
<button type="submit">Update Profile</button>
</form>
</div>

<div class="box">
<h3>Change Password</h3>

<form id="passForm">
<input type="password" name="old" placeholder="Old Password">
<input type="password" name="new" placeholder="New Password">
<button type="submit">Change Password</button>
</form>
</div>

<script>
// PROFILE UPDATE
document.getElementById("profileForm").addEventListener("submit", function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.append("action","update_profile");

    fetch("profile.php", {
        method:"POST",
        body:fd
    })
    .then(res=>res.json())
    .then(data=>{
        Swal.fire({
            icon:data.status,
            title:data.title,
            text:data.message
        });
    });
});

// PASSWORD CHANGE
document.getElementById("passForm").addEventListener("submit", function(e){
    e.preventDefault();

    let fd = new FormData(this);
    fd.append("action","change_password");

    fetch("profile.php", {
        method:"POST",
        body:fd
    })
    .then(res=>res.json())
    .then(data=>{
        Swal.fire({
            icon:data.status,
            title:data.title,
            text:data.message
        });
    });
});
</script>

</body>
</html>