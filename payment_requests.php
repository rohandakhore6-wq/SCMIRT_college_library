<?php
session_start();
include '../db.php';

// 🔥 APPROVE
if(isset($_GET['approve'])){
    $id = (int)$_GET['approve'];
    mysqli_query($conn,"UPDATE payment SET status='approved' WHERE payment_id='$id'");
    header("Location: payment_requests.php");
}

// 🔥 REJECT
if(isset($_GET['reject'])){
    $id = (int)$_GET['reject'];
    mysqli_query($conn,"UPDATE payment SET status='rejected' WHERE payment_id='$id'");
    header("Location: payment_requests.php");
}

// 🔥 TOTAL STATS
$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(amount) as total FROM payment WHERE status IN('paid','approved')
"))['total'] ?? 0;

$pending = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(amount) as pending FROM payment WHERE status='pending'
"))['pending'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Payments</title>

<style>
body{font-family:Arial;background:#eef2f3;}

.container{
    width:90%;
    margin:30px auto;
}

h2{text-align:center;}

.card{
    display:inline-block;
    padding:15px;
    margin:10px;
    background:#fff;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.2);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th,td{
    padding:10px;
    text-align:center;
    border:1px solid #ccc;
}

th{background:#1565c0;color:white;}

.btn{
    padding:5px 10px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}

.approve{background:green;color:white;}
.reject{background:red;color:white;}
.view{background:#0288d1;color:white;}
</style>
</head>

<body>

<div class="container">

<h2>💰 Payment Management (Admin)</h2>

<div class="card">Total Collected: ₹<?php echo $total; ?></div>
<div class="card">Pending Amount: ₹<?php echo $pending; ?></div>

<table>
<tr>
<th>Student</th>
<th>Book</th>
<th>Amount</th>
<th>Method</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT p.*, s.student_name, b.book_name
FROM payment p
JOIN students s ON p.student_id = s.student_id
LEFT JOIN issued_books ib ON p.issue_id = ib.id
LEFT JOIN books b ON ib.book_id = b.book_id
ORDER BY p.payment_id DESC
");

while($row=mysqli_fetch_assoc($q)){
?>

<tr>
<td><?php echo $row['student_name']; ?></td>
<td><?php echo $row['book_name']; ?></td>
<td>₹<?php echo $row['amount']; ?></td>
<td><?php echo $row['payment_method']; ?></td>
<td><?php echo $row['status']; ?></td>

<td>

<?php if($row['status']=="pending"){ ?>

<a href="?approve=<?php echo $row['payment_id']; ?>">
<button class="btn approve">Approve</button>
</a>

<a href="?reject=<?php echo $row['payment_id']; ?>">
<button class="btn reject">Reject</button>
</a>

<?php } else { ?>

<a href="../student/receipt.php?id=<?php echo $row['payment_id']; ?>" target="_blank">
<button class="btn view">📄 View Receipt</button>
</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>