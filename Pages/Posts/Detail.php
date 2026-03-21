<?php
require_once 'Controllers/Connections.php';
require_once 'Controllers/Sessions.php';
require_once 'Controllers/Configs.php';

// 🔥 lấy id từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Bài viết không hợp lệ");
}

// 🔥 lấy bài viết
$stmt = $conn->prepare("SELECT * FROM post WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Không tìm thấy bài viết");
}

// 🔥 tăng lượt xem
$conn->prepare("UPDATE post SET luotxem = luotxem + 1 WHERE id = :id")
     ->execute(['id' => $id]);
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
        .post-container {
            background: rgba(0,0,0,0.6);
            border: 2px solid #3aa0ff;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        .post-title {
            color: #ffd43b;
            font-weight: bold;
            font-size: 26px;
        }
        .meta {
            color: #ccc;
            font-size: 14px;
            margin-bottom: 15px;
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

    <?php include 'Controllers/Header.php'; ?>

    <div class="post-container">

        <!-- 🔥 tiêu đề -->
        <div class="post-title">
            <?= htmlspecialchars($post['tieude']) ?>
        </div>

        <!-- 🔥 meta -->
        <div class="meta">
            📅 <?= date("d/m/Y H:i", strtotime($post['ngaytao'])) ?> |
            👁 <?= number_format($post['luotxem'] + 1) ?> lượt xem
        </div>

        <hr>

        <!-- 🔥 nội dung (cho phép HTML) -->
        <div class="content">
            <?= $post['noidung'] ?>
        </div>

    </div>

    <?php include 'Controllers/Footer.php'; ?>

</div>

</body>
</html>