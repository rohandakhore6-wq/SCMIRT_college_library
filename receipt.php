<?php
include '../db.php';

$payment_id = $_GET['id'] ?? 0;

// 🔎 DATA FETCH
$q = mysqli_query($conn, "
SELECT p.*, s.student_name, b.book_name
FROM payment p
JOIN students s ON p.student_id = s.student_id
LEFT JOIN issued_books ib ON p.issue_id = ib.id
LEFT JOIN books b ON ib.book_id = b.book_id
WHERE p.payment_id='$payment_id'
LIMIT 1
");

$data = mysqli_fetch_assoc($q);

if(!$data){
    echo "Invalid Receipt";
    exit();
}

// 🔥 RECEIPT NO
$receipt_no = "RCPT-" . str_pad($payment_id, 5, "0", STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html>
<head>
<title>Receipt</title>

<script>
window.onload = function(){
    window.print();
}
</script>

<style>
body{
    font-family:Arial;
    background:#f2f2f2;
}

.receipt{
    width:650px;
    margin:30px auto;
    background:#fff;
    padding:25px;
    border:2px solid #000;
    box-shadow:0 0 10px rgba(0,0,0,0.3);
}

.header{
    text-align:center;
}

.logo{
    width:80px;
    margin-bottom:10px;
}

.top{
    display:flex;
    justify-content:space-between;
    margin-top:10px;
}

.table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

.table td{
    padding:8px;
    border:1px solid #000;
}

.footer{
    margin-top:40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.barcode{
    text-align:center;
    margin-top:20px;
}
</style>

</head>

<body>

<div class="receipt">

<div class="header">

<!-- 🔥 COLLEGE LOGO -->
<img src="/library/images/1588151545phpSWUpWe.jpeg" class="logo">

<h2>Suryadatta College of Management Information Research and Technology (SCMIRT)</h2>
<h3>Library Payment Receipt</h3>
<hr>

</div>

<div class="top">
<div><b>Receipt No:</b> <?php echo $receipt_no; ?></div>
<div><b>Date:</b> <?php echo date("d-m-Y"); ?></div>
</div>

<table class="table">

<tr>
<td><b>Student Name</b></td>
<td><?php echo $data['student_name']; ?></td>
</tr>

<tr>
<td><b>Book Name</b></td>
<td><?php echo $data['book_name']; ?></td>
</tr>

<tr>
<td><b>Amount Paid</b></td>
<td>₹<?php echo $data['amount']; ?></td>
</tr>

<tr>
<td><b>Payment Method</b></td>
<td><?php echo $data['payment_method']; ?></td>
</tr>

<tr>
<td><b>Status</b></td>
<td>Paid</td>
</tr>

<tr>
<td><b>Time</b></td>
<td><?php echo date("h:i A", strtotime($data['payment_date'])); ?></td>
</tr>

</table>

<!-- 🔥 BARCODE -->
<div class="barcode">
<img src="https://barcode.tec-it.com/barcode.ashx?data=<?php echo $receipt_no; ?>&code=Code128" />
</div>

<div class="footer">

<div>
<p><b>College Stamp</b></p>
<img src="/library/images/stamp.png.png" width="120">
</div>

<div>
<p><b>Authorized Signature</b></p>
<!-- 🔥 UPDATED SIGNATURE -->
<img src="/library/images/sing.png" width="150">
</div>

</div>

</div>

</body>
</html>