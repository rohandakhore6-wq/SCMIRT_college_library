<?php
session_start();
include '../db.php';
?>

<html>
<head>
<title>Manage Books</title>

<style>
body{
 font-family:Arial;
 background:#f2f2f2;
 margin:0;
}

.container{
 padding:30px;
}

/* FORM */
.form-box{
 background:white;
 padding:20px;
 width:350px;
 margin:auto;
 border-radius:10px;
 box-shadow:0 0 15px rgba(0,0,0,0.2);
}

input{
 width:95%;
 padding:10px;
 margin:8px 0;
 border-radius:6px;
 border:1px solid #ccc;
}

button{
 padding:10px;
 background:#0072ff;
 color:white;
 border:none;
 border-radius:6px;
 cursor:pointer;
 width:100%;
}

/* TABLE */
table{
 width:90%;
 background:white;
 border-collapse:collapse;
 margin:30px auto;
}

th,td{
 padding:12px;
 border:1px solid #ccc;
 text-align:center;
}

.delete{
 background:#dc3545;
 color:white;
 padding:6px 12px;
 border:none;
 border-radius:5px;
 cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<h1 align="center">📚 Manage Books</h1>

<!-- ADD BOOK FORM -->
<div class="form-box">

<form method="post">

<input type="text" name="title" placeholder="Book Title" required>

<input type="text" name="author" placeholder="Author Name" required>

<input type="number" name="qty" placeholder="Quantity" required>

<button name="add">Add Book</button>

</form>

</div>

<?php
// ADD BOOK
if(isset($_POST['add'])){
$t=$_POST['title'];
$a=$_POST['author'];
$q=$_POST['qty'];

mysqli_query($conn,
"INSERT INTO books(title,author,quantity)
VALUES('$t','$a','$q')");

echo "<script>alert('Book Added ✔️'); location.reload();</script>";
}
?>

<!-- BOOK LIST -->
<table>

<tr>
<th>Title</th>
<th>Author</th>
<th>Quantity</th>
<th>Action</th>
</tr>

<?php
$b = mysqli_query($conn,"SELECT * FROM books");

while($row = mysqli_fetch_assoc($b)){
echo "<tr>
<td>{$row['title']}</td>
<td>{$row['author']}</td>
<td>{$row['quantity']}</td>
<td>
<form method='post'>
<input type='hidden' name='id' value='{$row['id']}'>
<button name='delete' class='delete'>Delete</button>
</form>
</td>
</tr>";
}
?>

</table>

<?php
// DELETE BOOK
if(isset($_POST['delete'])){
$id = $_POST['id'];

mysqli_query($conn,"DELETE FROM books WHERE id='$id'");

echo "<script>location.reload();</script>";
}
?>

</div>

</body>
</html>
