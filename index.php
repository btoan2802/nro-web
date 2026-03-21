<?php

require_once 'Controllers/Connections.php';
require_once 'Controllers/Sessions.php';
require_once 'Controllers/Configs.php';
?>
<!DOCTYPE html>

<html lang="vi">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= $_Title ?></title>

<meta name="description" content="<?= $_Description ?>">
<meta name="keywords" content="<?= $_Keyword ?>">

<link rel="icon" href="/Assets/Images/<?= $_Logo ?>?v=<?php echo time(); ?>">

<link href="/Assets/Css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/Assets/Css/bootstrap.min.js"></script>   

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>

<style>

.logo{
max-width:450px;
height:auto;
}

@media(max-width:768px){
.logo{
max-width:250px;
}
}

.post-item{
display:flex;
gap:12px;
}

.post-image img{
width:80px;
}

.text-container{
flex:1;
}

.text-container a{
color:#4ec3ff;
font-weight:bold;
font-size:16px;
}

.text-container a:hover{
color:#6ed6ff;
}

.content-text{
font-size:16px;
line-height:1.7;
color:#f1f1f1;
}

.content-text ul{
padding-left:20px;
}

.content-text li{
margin-bottom:6px;
}

.card{
background:rgba(0,0,0,0.55);
border:2px solid #3aa0ff;
border-radius:10px;
}

.card-title{
color:#ffd43b;
font-weight:bold;
}

h4,h5{
color:#ffd43b;
}

.text-muted{
color:#cccccc !important;
}

.text-danger{
color:#ff5b5b !important;
}

.snowEffect{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
pointer-events:none;
z-index:-1;
}

.snowEffect canvas{
width:100%;
height:100%;
}

@media(max-width:768px){

.post-image img{
width:60px;
}

}

</style>

</head>

<body class="page-layout-color">

<div class="snowEffect">
<canvas></canvas>
</div>

<div class="container">

<?php include 'Controllers/Header.php'; ?>

<div class="card mt-3">
<div class="card-body">

<h5 class="card-title">Trang chủ</h5>

<?php
$result = $conn->query("SELECT COUNT(*) as total FROM post");
$row = $result->fetch(PDO::FETCH_ASSOC);
echo "Số bài: " . $row['total'];
?>

<?php include 'Pages/Others/Top.php'; ?>

<div class="mt-4">

<div class="post-item align-items-center my-2">

<div class="post-image">
<img class="img-fluid rounded"
src="/Assets/Images/dfwfpf8-98f685fe-34f0-4aa3-a409-1f8fae08bb2f.gif">
</div>

<div class="text-container">

<a href="/Pages/Others/Sukien.php">
Hướng dẫn cơ bản
</a>

<p class="text-muted mb-0">
Đăng bởi <span class="text-danger fw-bold">Admin</span>
</p>

</div>
</div>

<div class="post-item align-items-center my-2">

<div class="post-image">
<img class="img-fluid rounded" src="/Assets/Images/<?=$_Logo?>?v=<?php echo time(); ?>">
</div>

<div class="text-container">

<a href="/Pages/Others/ModsGuide.php">
Hướng dẫn sử dụng Mod
</a>

<p class="text-muted mb-0">
Đăng bởi <span class="text-danger fw-bold">Admin</span>
</p>

</div>
</div>

<hr>

<?php include 'Pages/Posts/List.php'; ?>

<h4 class="fw-bold">Giới Thiệu</h4>

<div class="content-text">

<p>
<strong>Ngọc Rồng BT</strong> là một tựa game nhập vai lấy cảm hứng từ bộ truyện
<strong>7 Viên Ngọc Rồng</strong>.
</p>

<ul>
<li><b>Saiyan</b> – Chiến binh chống chịu cao.</li>
<li><b>Namek</b> – Đánh nhanh và mạnh.</li>
<li><b>Trái Đất</b> – Sở hữu Kamejoko cực mạnh.</li>
</ul>

<h5 class="fw-bold mt-3">Lối Chơi</h5>

<ul>
<li>Hệ thống nhân vật đa dạng</li>
<li>Chiến đấu nâng cấp kỹ năng</li>
<li>Nhiệm vụ theo cốt truyện</li>
<li>PvP và săn boss</li>
</ul>

<h5 class="fw-bold mt-3">Tính Năng Game</h5>

<ul>
<li>Đồ họa 2D nhẹ</li>
<li>Bang hội và giao dịch</li>
<li>Trang bị phong phú</li>
<li>Sự kiện hấp dẫn</li>
</ul>

</div>

<hr>

<p class="text-danger text-center fw-bold">Cơ Bản</p>

<div class="text-center">

<img class="img-fluid m-1" src="/Assets/Images/gif_maphongba.gif">
<img class="img-fluid m-1" src="/Assets/Images/gif_gif_Saiyain.gif">
<img class="img-fluid m-1" src="/Assets/Images/gif_supber_kame.gif">

</div>

<p class="text-danger text-center fw-bold mt-3">VIP</p>

<div class="text-center">

<img class="img-fluid m-1" src="/Assets/Images/gif_maphongba_VIP.gif">
<img class="img-fluid m-1" src="/Assets/Images/gif_gif_Saiyain_VIP.gif">
<img class="img-fluid m-1" src="/Assets/Images/gif_supber_kame_VIP.gif">

</div>

<div class="text-center mt-3">

<a href="" class="btn btn-primary">
Xem thêm
</a>

</div>

</div>
</div>
</div>

<?php include 'Controllers/Footer.php'; ?>

</div>

<script src="/Assets/Js/ThreeCanvas.js"></script>
<script src="/Assets/Js/Snow3d.js"></script>
<script src="/Assets/Js/animation.js?v4"></script>

</body>
</html>