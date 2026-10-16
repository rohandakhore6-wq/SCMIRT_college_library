<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db.php';

$student_id = $_SESSION['student_id'];

// 🔥 PAYMENT ACTION (AJAX)
if(isset($_POST['pay'])){
    $issue_id = (int)$_POST['issue_id'];
    $method = $_POST['method'];

    $q = mysqli_query($conn,"SELECT * FROM issued_books WHERE id='$issue_id'");
    $row = mysqli_fetch_assoc($q);

    if($row){
        $due_date = $row['due_date'];
        $today = date("Y-m-d");

        $fine = 0;

        if($today > $due_date){
            $days = floor((strtotime($today)-strtotime($due_date))/(60*60*24));
            $fine = $days * 5;
        }

        $status = ($method=="UPI") ? "paid" : "pending";

        // ✅ issue_id add केलं
        mysqli_query($conn,"
        INSERT INTO payment(student_id, issue_id, amount, payment_method, status)
        VALUES('$student_id','$issue_id','$fine','$method','$status')
        ");

        $payment_id = mysqli_insert_id($conn);

        if($method=="UPI"){
            echo json_encode([
                "status"=>"success",
                "payment_id"=>$payment_id
            ]);
        } else {
            echo json_encode(["status"=>"pending"]);
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:linear-gradient(to right,#0f2027,#203a43,#2c5364);
    color:white;
}
.header{
    background:#0d47a1;
    padding:15px;
    text-align:center;
    font-size:22px;
}
.container{
    width:85%;
    margin:40px auto;
    background:rgba(255,255,255,0.1);
    padding:25px;
    border-radius:12px;
}
table{
    width:100%;
    border-collapse:collapse;
}
th, td{
    padding:12px;
    text-align:center;
}
th{
    background:#1565c0;
}
tr{
    background:rgba(255,255,255,0.1);
}
.btn{
    padding:6px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
}
</style>

<script>
function payNow(issue_id, method){
    if(method==""){
        alert("Select Payment Method");
        return;
    }

    let formData = new FormData();
    formData.append("pay",true);
    formData.append("issue_id",issue_id);
    formData.append("method",method);

    fetch("payment.php",{
        method:"POST",
        body:formData
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.status=="success"){
            alert("✅ Payment Successful!");
            window.open("receipt.php?id="+data.payment_id,"_blank");
            location.reload();
        } else {
            alert("💵 Cash Request Sent to Admin");
            location.reload();
        }
    });
}
</script>

</head>

<body>

<div class="header">
💳 Library Fine Payment
</div>

<div class="container">

<h2>📚 Pending Fine Books</h2>

<table>
<tr>
<th>Book Name</th>
<th>Due Date</th>
<th>Fine</th>
<th>Payment</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT ib.*, b.book_name 
FROM issued_books ib
JOIN books b ON ib.book_id=b.book_id
WHERE ib.student_id='$student_id' AND ib.return_date IS NULL
");

while($row=mysqli_fetch_assoc($q)){

    $issue_id = $row['id'];
    $due_date = $row['due_date'];
    $today = date("Y-m-d");

    // 🔥 PAYMENT CHECK
    $pay_check = mysqli_query($conn,"
    SELECT * FROM payment 
    WHERE student_id='$student_id' 
    AND issue_id='$issue_id'
    AND (status='paid' OR status='approved')
    ORDER BY payment_id DESC LIMIT 1
    ");

    $paid = mysqli_fetch_assoc($pay_check);

    $fine = 0;

    if(!$paid){
        if($today > $due_date){
            $days = floor((strtotime($today)-strtotime($due_date))/(60*60*24));
            $fine = $days * 5;
        }
    }
?>

<tr>
<td><?php echo htmlspecialchars($row['book_name']); ?></td>
<td><?php echo $due_date; ?></td>

<td>
<?php 
if($paid){
    echo "<span style='color:lightgreen;font-weight:bold;'>Paid ✅</span>";
}else{
    echo "₹".$fine;
}
?>
</td>

<td>
<?php
if($paid){
?>
<a href="receipt.php?id=<?php echo $paid['payment_id']; ?>" target="_blank">
<button class="btn">⬇ Download Receipt</button>
</a>
<?php
}else{
?>
<select id="m<?php echo $row['id']; ?>">
<option value="">Select</option>
<option value="UPI">UPI</option>
<option value="CASH">Cash</option>
</select>

<button onclick="payNow(<?php echo $row['id']; ?>, document.getElementById('m<?php echo $row['id']; ?>').value)" class="btn">
Pay Now
</button>
<?php
}
?>
</td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>