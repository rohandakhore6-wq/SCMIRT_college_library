<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 header("Location: login.php");
 exit();
}

$id = $_SESSION['student_id'];

/* 🔥 CHECK: already issued book */
$already = mysqli_query($conn,
"SELECT * FROM issued_books
WHERE student_id='$id' AND status!='Returned'");

/* 🔔 AUTO NOTIFICATION SYSTEM */
$today = date("Y-m-d");

$q_check = mysqli_query($conn,
"SELECT i.*, b.book_name
FROM issued_books i
JOIN books b ON i.book_id = b.book_id
WHERE i.student_id='$id' AND i.status!='Returned'");

while($row_check = mysqli_fetch_assoc($q_check)){

 $book_name = $row_check['book_name'];
 $due = date("Y-m-d", strtotime($row_check['due_date']));

 if($today == date("Y-m-d", strtotime($due." -1 day"))){
  $msg = "⏰ Reminder: Return $book_name tomorrow";

  mysqli_query($conn,
  "INSERT INTO notifications (student_id, message)
   SELECT '$id', '$msg'
   WHERE NOT EXISTS (
     SELECT 1 FROM notifications 
     WHERE student_id='$id' AND message='$msg'
   )");
 }

 // 🔥 UPDATED FINE LOGIC (NO GRACE)
 if($today > $due){

  $days = floor((strtotime($today) - strtotime($due)) / (60*60*24));

  if($days > 0){

    $fine = $days * 5;

    $msg = "💸 Fine ₹$fine for $book_name (Late by $days days)";

    mysqli_query($conn,
    "INSERT INTO notifications (student_id, message)
     SELECT '$id', '$msg'
     WHERE NOT EXISTS (
       SELECT 1 FROM notifications 
       WHERE student_id='$id' AND message='$msg'
     )");
  }
 }
}

/* 📖 FETCH ISSUED BOOKS */
$q = mysqli_query($conn,
"SELECT i.*, b.book_name
FROM issued_books i
JOIN books b ON i.book_id = b.book_id
WHERE i.student_id='$id'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Issued Books</title>

<style>
body{
 font-family:Arial;
 background:#f4f6f9;
 margin:0;
}

.container{
 padding:30px;
}

.warning{
 background:#ffdddd;
 color:#d8000c;
 padding:15px;
 margin:20px auto;
 width:60%;
 text-align:center;
 border-radius:10px;
 font-weight:bold;
}

table{
 width:90%;
 margin:auto;
 border-collapse:collapse;
 background:white;
}

th,td{
 padding:12px;
 border:1px solid #ccc;
 text-align:center;
}

th{
 background:#2196F3;
 color:white;
}

button{
 padding:6px 12px;
 background:#28a745;
 color:white;
 border:none;
 border-radius:5px;
 cursor:pointer;
}

button:hover{
 background:#218838;
}

/* Popup */
.popup{
 display:none;
 position:fixed;
 top:0; left:0;
 width:100%; height:100%;
 background:rgba(0,0,0,0.6);
 justify-content:center;
 align-items:center;
}

.popup-box{
 background:white;
 padding:30px;
 border-radius:15px;
 text-align:center;
 animation:scaleUp 0.3s ease;
}

@keyframes scaleUp{
 from{transform:scale(0.7); opacity:0;}
 to{transform:scale(1); opacity:1;}
}
</style>
</head>

<body>

<div class="container">

<h1 align="center">📖 Issued Books</h1>

<?php
// 🔥 SHOW WARNING
if(mysqli_num_rows($already) > 0){
 echo "<div class='warning'>
 ❌ You already have a book issued. Return it first to take another.
 </div>";
}
?>

<table>

<tr>
<th>Book Name</th>
<th>Issue Date</th>
<th>Due Date</th>
<th>Status</th>
<th>Fine (₹)</th>
<th>Action</th>
</tr>

<?php
if($q && mysqli_num_rows($q)>0){

 while($row = mysqli_fetch_assoc($q)){

  $status = $row['status'];

  $today = date("Y-m-d");
  $due = date("Y-m-d", strtotime($row['due_date']));

  $fine = 0;

  // 🔥 UPDATED FINE LOGIC (NO GRACE)
  if($today > $due && $status != 'Returned'){

   $days = floor((strtotime($today) - strtotime($due)) / (60*60*24));

   if($days > 0){
     $fine = $days * 5;
   }
  }

  if($status == 'Issued'){
   $status_html = "<span style='color:green;font-weight:bold;'>Issued ✔️</span>";
  }elseif($status == 'Return Pending'){
   $status_html = "<span style='color:orange;font-weight:bold;'>Return Pending ⏳</span>";
  }else{
   $status_html = "<span style='color:gray;'>Returned</span>";
  }

  echo "<tr>
  <td>{$row['book_name']}</td>
  <td>{$row['issue_date']}</td>
  <td>{$row['due_date']}</td>
  <td class='status'>$status_html</td>
  <td style='color:".($fine>0?"red":"green").";font-weight:bold;'>₹ $fine</td>
  <td>";

  if($status == 'Issued'){
   echo "<button onclick='returnBook({$row['id']}, this)'>Return Book</button>";
  }else{
   echo "—";
  }

  echo "</td></tr>";
 }

}else{
 echo "<tr><td colspan='6'>No books issued 📭</td></tr>";
}
?>

</table>

</div>

<!-- Popup -->
<div id="popup" class="popup">
 <div class="popup-box">
   <h2 id="msg">✔️ Done</h2>
   <br>
   <button onclick="closePopup()">OK</button>
 </div>
</div>

<script>
function returnBook(id, btn){

 fetch("return_request_ajax.php", {
  method:"POST",
  headers:{
   "Content-Type":"application/x-www-form-urlencoded"
  },
  body:"id="+id
 })
 .then(res => res.text())
 .then(data => {

   document.getElementById("msg").innerHTML = data;
   document.getElementById("popup").style.display = "flex";

   let row = btn.closest("tr");
   row.querySelector(".status").innerHTML =
   "<span style='color:orange;font-weight:bold;'>Return Pending ⏳</span>";

   btn.remove();
 });
}

function closePopup(){
 document.getElementById("popup").style.display = "none";
}
</script>

</body>
</html>