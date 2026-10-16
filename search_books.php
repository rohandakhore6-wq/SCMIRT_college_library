<?php
session_start();
include '../db.php';

if(!isset($_SESSION['student_id'])){
 header("Location: login.php");
 exit();
}

$id = $_SESSION['student_id'];

// 🔥 SEARCH + DEFAULT ALL BOOKS
$search = "";

if(isset($_GET['search']) && $_GET['search'] != ""){
 $search = $_GET['search'];

 $q = mysqli_query($conn,
 "SELECT * FROM books 
 WHERE book_name LIKE '%$search%' 
 OR author LIKE '%$search%'");
}else{
 // 🔥 DEFAULT: SHOW ALL BOOKS
 $q = mysqli_query($conn,"SELECT * FROM books");
}
?>

<html>
<head>
<title>Search Books</title>

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
}

.container{
 padding:30px;
 color:white;
}

input{
 padding:10px;
 width:300px;
 border-radius:6px;
 border:none;
}

button{
 padding:10px 20px;
 background:#0072ff;
 color:white;
 border:none;
 border-radius:6px;
 cursor:pointer;
}

button:hover{ background:#0056cc; }

table{
 margin-top:20px;
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

/* 🔥 POPUP */
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
 color:black;
 box-shadow:0 0 30px rgba(0,0,0,0.5);
}
</style>
</head>

<body>

<div class="container">

<h1>🔍 Search Books</h1>

<form method="get">
<input type="text" name="search"
placeholder="Enter book name or author"
value="<?php echo $search; ?>">
<button>Search</button>
</form>

<?php
if($q && mysqli_num_rows($q)>0){

echo "<table>
<tr>
<th>Book Name</th>
<th>Author</th>
<th>Available</th>
<th>Action</th>
</tr>";

while($b = mysqli_fetch_assoc($q)){

echo "<tr>
<td>{$b['book_name']}</td>
<td>{$b['author']}</td>
<td>{$b['quantity']}</td>
<td>";

if($b['quantity'] > 0){
 echo "<button onclick='requestBook({$b['book_id']})'>
 Request Book
 </button>";
}else{
 echo "Not Available";
}

echo "</td></tr>";
}

echo "</table>";

}else{
 echo "<p>No books found ❌</p>";
}
?>

<br>
<a href="dashboard.php" class="back">⬅ Back to Dashboard</a>

</div>

<!-- 🔥 POPUP -->
<div id="popup" class="popup">
 <div class="popup-box">
   <h2 id="msg">✔️ Done</h2>
   <button onclick="closePopup()">OK</button>
 </div>
</div>

<script>
function requestBook(book_id){

 fetch("request_book_ajax.php", {
  method:"POST",
  headers:{
   "Content-Type":"application/x-www-form-urlencoded"
  },
  body:"book_id="+book_id
 })
 .then(res => res.text())
 .then(data => {

   document.getElementById("msg").innerHTML = data;
   document.getElementById("popup").style.display = "flex";

 });
}

function closePopup(){
 document.getElementById("popup").style.display = "none";
}
</script>

</body>
</html>