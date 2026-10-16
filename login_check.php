<?php
session_start();
include '../db.php';

header('Content-Type: application/json');

$id   = trim($_POST['login_id']);
$pass = trim($_POST['pass']);

// 🔥 email OR mobile check
$query = "SELECT * FROM students WHERE email='$id' OR mobile='$id'";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0){

    $row = mysqli_fetch_assoc($result);

    // ✅ password check
    if($pass == $row['password']){

        $_SESSION['student_id']   = $row['student_id'];
        $_SESSION['student_name'] = $row['student_name'];

        echo json_encode([
            "status" => "success"
        ]);

    } else {

        echo json_encode([
            "status" => "error",
            "message" => "❌ Password Incorrect"
        ]);

    }

} else {

    echo json_encode([
        "status" => "error",
        "message" => "❌ Username Incorrect"
    ]);

}
?>