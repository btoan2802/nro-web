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

<?php
$username = $_SESSION['account'] ?? '';
?>

<p>
Ví dụ: <b>nap <?php echo $username; ?></b>
</p>

<div style="margin-top:10px">

<b>Tài khoản của bạn:</b>

<span id="username">
<?php echo $username; ?>
</span>

</div>

<button class="btn btn-primary copybtn" onclick="copyNoiDung()">
Copy nội dung chuyển khoản
</button>

<hr>

<h5>Chọn số tiền nạp</h5>

<select class="form-control mb-3" id="amount" onchange="genQR()">

<option value="">-- Chọn nhanh số tiền --</option>
<option value="10000">10,000 VNĐ</option>
<option value="20000">20,000 VNĐ</option>
<option value="50000">50,000 VNĐ</option>
<option value="100000">100,000 VNĐ</option>
<option value="200000">200,000 VNĐ</option>
<option value="500000">500,000 VNĐ</option>
<option value="1000000">1,000,000 VNĐ</option>

</select>

<h6>Hoặc nhập số tiền tùy ý</h6>

<input 
type="number" 
class="form-control" 
id="custom_amount"
placeholder="Nhập số tiền muốn nạp (VD: 75000)"
oninput="genQR()"
>

<div style="margin-top:20px">

<img id="qrimg" class="bktne" style="display:none">

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

var temp = document.createElement("input");
temp.value = text;
document.body.appendChild(temp);
temp.select();
document.execCommand("copy");
document.body.removeChild(temp);

alert("Đã copy: " + text);

}


function genQR(){

var username = document.getElementById("username").innerText.trim();

var dropdown = document.getElementById("amount").value;
var custom = document.getElementById("custom_amount").value;

var amount = custom ? custom : dropdown;

if(amount == "" || amount <= 0){
document.getElementById("qrimg").style.display = "none";
return;
}

var content = "nap " + username;

var url = "https://qr.sepay.vn/img?acc=00352924355&bank=TPBank&amount="+amount+"&des="+encodeURIComponent(content);

var qr = document.getElementById("qrimg");

qr.src = url;
qr.style.display = "block";

}

</script>

<?php
include 'Controllers/Footer.php';
?>

</body>

</html>