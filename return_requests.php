<?php
session_start();
include '../db.php';
?>

<html>
<head>
<title>Return Requests</title>

<style>
body{
 font-family:Arial;
 background:#f2f2f2;
 margin:0;
}

.container{ padding:30px; }

table{
 width:90%;
 background:white;
 border-collapse:collapse;
 margin:auto;
 box-shadow:0 0 20px rgba(0,0,0,0.3);
}

th{ background:#2196F3; color:white; }

th,td{
 padding:12px;
 border:1px solid #ccc;
 text-align:center;
}

button{
 padding:6px 12px;
 background:#28a745;
 color:white;
 border:none;
 border-radius:5px;
 cursor:pointer;
}

button:hover{ background:#218838; }

/* POPUP */
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
 padding:30px 40px;
 border-radius:12px;
 text-align:center;
 box-shadow:0 0 30px rgba(0,0,0,0.5);
}
</style>
</head>

<body>

<div class="container">

<h1 align="center">📚 Return Book Requests</h1>

<table>

<tr>
<th>Student name</th>
<th>Course</th>
<th>Book name</th>
<th>Issue Date</th>
<th>Due Date</th>
<th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,
"SELECT i.*, s.student_name, s.course, b.book_name
FROM issued_books i
JOIN students s ON i.student_id = s.student_id
JOIN books b ON i.book_id = b.book_id
WHERE i.status='Return Pending'");

while($r = mysqli_fetch_assoc($q)){

echo "<tr>
<td>{$r['student_name']}</td>
<td>{$r['course']}</td>
<td>{$r['book_name']}</td>
<td>{$r['issue_date']}</td>
<td>{$r['due_date']}</td>
<td>
<button onclick='approveReturn({$r['id']})'>
Approve
</button>
</td>
</tr>";
}
?>

</table>

</div>

<!-- 🔥 PROFESSIONAL POPUP -->
<div id="popup" class="popup">
 <div class="popup-box">
  <h2 id="msg">✔️ Done</h2>
  <button onclick="closePopup()">OK</button>
 </div>
</div>

<script>

function approveReturn(id){

 fetch("approve_return_ajax.php", {
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

 });

}

function closePopup(){
 document.getElementById("popup").style.display = "none";
 location.reload();
}

</script>

</body>
</html>