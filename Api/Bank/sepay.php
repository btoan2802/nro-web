<?php

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo "No data";
    exit;
}

$amount = $data['amount'];
$content = $data['content'];
$tranid = $data['id'];

if(!$amount || !$content){
    exit("No data");
}

// nội dung chuyển khoản: nap username
if(strpos($content,"nap ") !== false){

    $username = str_replace("nap ","",$content);

    // kiểm tra user
    $check = $conn->prepare("SELECT * FROM users WHERE username=?");
    $check->execute([$username]);
    $user = $check->fetch();

    if($user){

        // tránh cộng trùng
        $checkTran = $conn->prepare("SELECT * FROM atm_history WHERE tranid=?");
        $checkTran->execute([$tranid]);

        if(!$checkTran->fetch()){

            $coin = $amount; // 1đ = 1 coin (bạn chỉnh lại nếu muốn)

            // cộng coin
            $update = $conn->prepare("UPDATE users SET coin = coin + ? WHERE username=?");
            $update->execute([$coin,$username]);

            // lưu lịch sử
            $insert = $conn->prepare("INSERT INTO atm_history(username,amount,tranid) VALUES(?,?,?)");
            $insert->execute([$username,$amount,$tranid]);

        }

    }

}

echo "OK";