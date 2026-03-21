<?php
$sql = "SELECT * FROM post ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()):
?>

<div class="post-item align-items-center my-2">

    <div class="post-image">
        <img class="img-fluid rounded" src="/Assets/Images/default.png">
    </div>

    <div class="text-container">

        <a href="/Pages/Posts/Detail.php?id=<?=$row['id']?>">
            <?=$row['tieude']?>
        </a>

        <p class="text-muted mb-0">
            <?=$row['ngaytao']?> | 👁 <?=$row['luotxem']?>
        </p>

    </div>
</div>

<?php endwhile; ?>