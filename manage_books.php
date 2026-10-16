<?php
session_start();
include '../db.php';

// ➕ ADD BOOK
if(isset($_POST['add'])){
 $name = $_POST['name'];
 $author = $_POST['author'];
 $qty = $_POST['qty'];

 mysqli_query($conn,
 "INSERT INTO books(book_name,author,quantity)
 VALUES('$name','$author','$qty')");
}

// ✏ EDIT BOOK
if(isset($_POST['update'])){
 $id = $_POST['id'];
 $name = $_POST['name'];
 $author = $_POST['author'];
 $qty = $_POST['qty'];

 mysqli_query($conn,
 "UPDATE books 
 SET book_name='$name', author='$author', quantity='$qty'
 WHERE book_id='$id'");
}

// ❌ DELETE BOOK
if(isset($_GET['delete'])){
 $id = $_GET['delete'];

 mysqli_query($conn,
 "DELETE FROM books WHERE book_id='$id'");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Books</title>

<style>
body{
 font-family:Arial;
 background:#f2f2f2;
}

.container{
 padding:30px;
}

table{
 width:95%;
 margin:auto;
 border-collapse:collapse;
 background:white;
}

th{
 background:#2196F3;
 color:white;
}

th,td{
 padding:10px;
 border:1px solid #ccc;
 text-align:center;
}

input{
 padding:5px;
}

button{
 padding:6px 10px;
 border:none;
 border-radius:5px;
 cursor:pointer;
}

.add{ background:#28a745; color:white; }
.edit{ background:#ffc107; }
.delete{ background:#dc3545; color:white; }
</style>
</head>

<body>

<div class="container">

<h1 align="center">📚 Manage Books</h1>

<!-- ➕ ADD BOOK -->
<form method="post" style="text-align:center;margin-bottom:20px;">
<input type="text" name="name" placeholder="Book Name" required>
<input type="text" name="author" placeholder="Author" required>
<input type="number" name="qty" placeholder="Quantity" required>
<button name="add" class="add">Add Book</button>
</form>

<table>

<tr>
<th>ID</th>
<th>Book</th>
<th>Author</th>
<th>Total Qty</th>
<th>Issued</th>
<th>Available</th>
<th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,"SELECT * FROM books");

while($row = mysqli_fetch_assoc($q)){

 $book_id = $row['book_id'];

 // 📖 Issued Count
 $issued_q = mysqli_query($conn,
 "SELECT COUNT(*) as total 
 FROM issued_books 
 WHERE book_id='$book_id' AND status!='Returned'");

 $issued = mysqli_fetch_assoc($issued_q)['total'];

 $total = $row['quantity'];
 $available = $total - $issued;

 echo "<tr>
 <form method='post'>
 <td>{$row['book_id']}</td>
 <td><input name='name' value='{$row['book_name']}'></td>
 <td><input name='author' value='{$row['author']}'></td>
 <td><input name='qty' value='{$row['quantity']}'></td>
 <td>$issued</td>
 <td>$available</td>

 <td>
 <input type='hidden' name='id' value='{$row['book_id']}'>

 <button name='update' class='edit'>Update</button>
 <a href='?delete={$row['book_id']}' 
 onclick=\"return confirm('Delete?')\">
 <button type='button' class='delete'>Delete</button>
 </a>
 </td>

 </form>
 </tr>";
}
?>

</table>

</div>

</body>
</html>