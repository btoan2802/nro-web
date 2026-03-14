<?php
session_start();
include 'Controllers/Header.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>

<meta charset="UTF-8">

<link href="/Assets/Css/bootstrap.min.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="/Assets/Js/ThreeCanvas.js"></script>
<script src="/Assets/Js/Snow3d.js"></script>
<script src="/Assets/Js/animation.js?v4"></script>

<title>Nạp Tiền</title>

<style>

.snowEffect{
display:block;
margin:0 auto;
width:100%;
height:100%;
position:absolute;
top:0;
left:0;
z-index:-1;
}

.bktne{
display:block;
margin:auto;
width:90%;
max-width:320px;
height:auto;
}

.copybtn{
margin-top:10px;
}
@media (max-width: 600px){
.bktne{
max-width:300px;
}
}

</style>

</head>

<body>

<div class="snowEffect">
<canvas width="969" height="969"></canvas>
</div>

<div class="container mt-4">

<div class="card">

<div class="card-body text-center">

<h4>Quét mã QR để nạp tiền</h4>

<p>
Lưu ý: kiểm tra username nhân vật trong game hoặc trang tài khoản và ghi đúng nội dung chuyển khoản
</p>

<h5 style="color:red">

nap + tên tài khoản

</h5>

<p>

Ví dụ:

<b>nap_tentaikhoan</b>

</p>

<?php
$username = $_SESSION['account'] ?? '';
?>

<div style="margin-top:10px">

<b>Tài khoản của bạn:</b>
<span id="username">
<?php echo $username; ?>
</span>

</div>

<button class="btn btn-primary copybtn" onclick="copyNoiDung()">

Copy nội dung chuyển khoản

</button>

<div style="margin-top:20px">

<img class="bktne" src="/Assets/Images/QR.png?v=<?php echo time(); ?>">

</div>

<p style="margin-top:10px">

Sau khi chuyển khoản hệ thống sẽ tự động cộng tiền trong vòng 5-10 giây.

</p>

</div>

</div>

</div>

<script>

function copyNoiDung(){

var username = document.getElementById("username").innerText.trim();

if(username == ""){
alert("Không tìm thấy Username người chơi");
return;
}

var text = "nap " + username;

// tạo input tạm để copy
var temp = document.createElement("input");
temp.value = text;
document.body.appendChild(temp);
temp.select();
document.execCommand("copy");
document.body.removeChild(temp);

alert("Đã copy: " + text);

}
</script>

<?php
include 'Controllers/Footer.php';
?>

</body>

</html>