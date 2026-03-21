<?php
// 🔥 FIX include CHUẨN - không ảnh hưởng file khác
require_once __DIR__ . '/../../Controllers/Connections.php';
require_once __DIR__ . '/../../Controllers/Sessions.php';
require_once __DIR__ . '/../../Controllers/Configs.php';

// 🔥 lấy id từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("ID không hợp lệ");
}

// 🔥 lấy bài viết
$stmt = $conn->prepare("SELECT * FROM post WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔥 nếu không có bài
if (!$post) {
    die("Bài viết không tồn tại");
}

// 🔥 tăng lượt xem (FIX dấu ] đúng)
$update = $conn->prepare("UPDATE post SET luotxem = luotxem + 1 WHERE id = :id");
$update->execute(['id' => $id]);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['tieude']) ?></title>

    <link href="/Assets/Css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #0f172a;
            color: #fff;
        }
        .post-box {
            background: rgba(235, 229, 229, 0.6);
            border: 2px solid #3aa0ff;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        .title {
            font-size: 26px;
            font-weight: bold;
            color: #ffd43b;
        }
        .meta {
            font-size: 14px;
            color: #ccc;
            margin-bottom: 10px;
        }
        .content {
            line-height: 1.8;
            font-size: 16px;
        }
        .content img {
            max-width: 100%;
        }
    </style>
</head>

<body>

<div class="container">

    <?php include __DIR__ . '/../../Controllers/Header.php'; ?>

    <div class="post-box">

        <!-- tiêu đề -->
        <div class="title">
            <?= htmlspecialchars($post['tieude']) ?>
        </div>

        <!-- thông tin -->
        <div class="meta">
            📅 <?= date("d/m/Y H:i", strtotime($post['ngaytao'])) ?> |
            👁 <?= number_format($post['luotxem'] + 1) ?> lượt xem
        </div>

        <hr>

        <!-- nội dung (HTML giữ nguyên) -->
        <div class="content">
            <?= $post['noidung'] ?>
        </div>

    </div>

    <?php include __DIR__ . '/../../Controllers/Footer.php'; ?>

</div>

</body>
</html>