<?php
include '../../Controllers/Header.php';

if ($_Admin != 1) {
    echo '<script>window.location.href="../home"</script>';
    exit;
}

$_alert = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $cash = intval($_POST["cash"]);

    if($cash <= 0){
        $_alert = '<div class="alert alert-danger">Số tiền không hợp lệ!</div>';
    }else{

        $sql_check = "SELECT * FROM account WHERE username = :username";
        $statement_check = $conn->prepare($sql_check);
        $statement_check->bindParam(':username', $username);
        $statement_check->execute();

        if ($statement_check->rowCount() == 0) {

            $_alert = '<div class="alert alert-danger">Tài khoản không tồn tại!</div>';

        } else {

            $row = $statement_check->fetch();

            if ($row["ban"] == 1) {

                $_alert = '<div class="alert alert-danger">Tài khoản đã bị khóa!</div>';

            } else {

                $sql_update = "UPDATE account SET 
                vnd = vnd + :cash,
                tong_nap_moc_game = tong_nap_moc_game + :cash,
                tong_nap_server = tong_nap_server + :cash,
                danap = danap + :cash
                WHERE username = :username";

                $statement_update = $conn->prepare($sql_update);
                $statement_update->bindParam(':cash', $cash);
                $statement_update->bindParam(':username', $username);

                if ($statement_update->execute()) {

                    $magd = "ADMIN".time();

                    $sql_insert = "INSERT INTO atm_lichsu
                    (user_nap, magd, sotien, noidung, thoigian, trangthai, status)
                    VALUES
                    (:user_nap, :magd, :sotien, :noidung, NOW(), 1, 1)";

                    $statement_insert = $conn->prepare($sql_insert);
                    $statement_insert->bindParam(':user_nap', $username);
                    $statement_insert->bindParam(':magd', $magd);
                    $statement_insert->bindParam(':sotien', $cash);
                    $statement_insert->bindParam(':noidung', $username);
                    $statement_insert->execute();

                    echo '<script>window.location.href="' . $_SERVER['REQUEST_URI'] . '"</script>';
exit;

                } else {

                    $_alert = '<div class="alert alert-danger">Lỗi máy chủ!</div>';

                }

            }

        }

    }

}
?>

<div class="container pb-5">
<div class="col-md-12">
<div class="card">
<div class="card-body">

<h4>Cộng Tiền</h4>
<br>

<?php echo $_alert; ?>

<form method="POST">

<div class="mb-3">
<label class="text-black">Tên Tài Khoản:</label>
<input type="text" class="form-control" name="username" required>
</div>

<div class="mb-3">
<label class="text-black">Số Tiền:</label>
<input type="number" class="form-control" name="cash" required>
</div>

<button type="submit" class="btn btn-success">
Thực Hiện
</button>

</form>

</div>
</div>
</div>
</div>


<div class="container pb-5">
<div class="col-md-12">
<div class="card">
<div class="card-body">

<h4>Lịch Sử ATM</h4>

<div class="table-responsive">

<table class="table table-striped">

<thead>
<tr>
<th>ID</th>
<th>User</th>
<th>Thời Gian</th>
<th>Số Tiền</th>
<th>Trạng Thái</th>
</tr>
</thead>

<tbody>

<?php

$sql = "SELECT * FROM atm_lichsu ORDER BY id DESC LIMIT 10";
$statement = $conn->prepare($sql);
$statement->execute();
$transactions = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($transactions as $transaction) {

$status = '';

switch ($transaction['status']) {

case 1:
$status = '<span style="background:#28a745;color:white;padding:5px 10px;border-radius:10px;">Đã thanh toán</span>';
break;

case 2:
$status = '<span style="background:#dc3545;color:white;padding:5px 10px;border-radius:10px;">Chưa thanh toán</span>';
break;

default:
$status = '<span style="background:#ffc107;color:black;padding:5px 10px;border-radius:10px;">Đang xử lý</span>';

}

echo "<tr>";

echo "<td>".$transaction['id']."</td>";
echo "<td>".$transaction['user_nap']."</td>";
echo "<td>".$transaction['thoigian']."</td>";
echo "<td>".number_format($transaction['sotien'])."đ</td>";
echo "<td>".$status."</td>";

echo "</tr>";

}

?>

</tbody>
</table>

</div>
</div>
</div>
</div>
</div>


<div class="container pb-5">
<div class="col-md-12">
<div class="card">
<div class="card-body">

<h4>Tổng Doanh Thu</h4>

<?php

$sql_today = "SELECT SUM(sotien) AS total
FROM atm_lichsu
WHERE DATE(thoigian) = CURDATE()
AND status = 1";

$stmt_today = $conn->prepare($sql_today);
$stmt_today->execute();
$today = $stmt_today->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;


$sql_week = "SELECT SUM(sotien) AS total
FROM atm_lichsu
WHERE YEARWEEK(thoigian,1) = YEARWEEK(CURDATE(),1)
AND status = 1";

$stmt_week = $conn->prepare($sql_week);
$stmt_week->execute();
$week = $stmt_week->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;


$sql_month = "SELECT SUM(sotien) AS total
FROM atm_lichsu
WHERE MONTH(thoigian) = MONTH(CURDATE())
AND YEAR(thoigian) = YEAR(CURDATE())
AND status = 1";

$stmt_month = $conn->prepare($sql_month);
$stmt_month->execute();
$month = $stmt_month->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

?>

<div class="row">

<div class="col-md-4">
<div class="card text-white bg-success mb-3">
<div class="card-header">Doanh Thu Hôm Nay</div>
<div class="card-body">
<h5><?php echo number_format($today)."đ"; ?></h5>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card text-white bg-primary mb-3">
<div class="card-header">Doanh Thu Tuần Này</div>
<div class="card-body">
<h5><?php echo number_format($week)."đ"; ?></h5>
</div>
</div>
</div>

<div class="col-md-4">
<div class="card text-white bg-warning mb-3">
<div class="card-header">Doanh Thu Tháng Này</div>
<div class="card-body">
<h5><?php echo number_format($month)."đ"; ?></h5>
</div>
</div>
</div>

</div>

</div>
</div>
</div>
</div>

<?php
include '../../Controllers/Footer.php';
?>