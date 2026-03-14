<?php
require_once '../../Controllers/Connections.php';
require_once '../../Controllers/Configs.php';

define('POINTS_PER_TOPUP', 1);

$apiUrl = 'https://api.web2m.com/historyapiacbv3/Khanhdzz1/15338301/97FE6E41-1672-3EE1-31DE-1DED3D979F0A';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}
curl_close($ch);

$data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'JSON decode error: ' . json_last_error_msg();
    exit;
}

if (!isset($data['transactions']) || empty($data['transactions'])) {
    echo 'Không có dữ liệu giao dịch';
    exit;
}

foreach ($data['transactions'] as $cron) {

    $amount = $cron['amount'];
    $description = strtolower($cron['description']);
    $type = $cron['type'];
    $transactionID = $cron['transactionID'];
    $transactionDate = $cron['transactionDate'];

    $receiverAccountName = "Ngân Hàng Quân Đội - MBBANK";
    $accountNo = "Không có dữ liệu";
    $bankName = "Ngọc Rồng Light";

    $id = null;

    // đọc nội dung chuyển khoản
    if (preg_match('/naptien\s*(\d+)/i', $description, $matches)) {
        $id = $matches[1];
    }

    if (preg_match('/ad\s*(\d+)/i', $description, $matches)) {
        $id = $matches[1];
    }

    if ($type == 'IN' && $id) {

        if ($amount >= 3000 && !isTransactionExist($transactionID, $conn)) {

            updateAccountBalance($id, $amount, $conn);

            insertTransactionHistory(
                $id,
                $transactionID,
                $transactionDate,
                $amount,
                $receiverAccountName,
                $accountNo,
                $bankName,
                $conn
            );

            insertCheckTransaction($transactionID, $conn);

            echo 'Đã xử lý giao dịch: ' . $transactionID . '<br>';
        }
    }
}

function isTransactionExist($refNo, $conn)
{
    $sql = "SELECT tranid FROM atm_check WHERE tranid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$refNo]);
    return $stmt->rowCount() > 0;
}

function updateAccountBalance($id, $amount, $conn)
{

    $bonus = 0;

    if ($amount >= 10000 && $amount < 200000) {
        $bonus = 10;
    } elseif ($amount >= 200000 && $amount < 1000000) {
        $bonus = 10;
    } elseif ($amount >= 1000000 && $amount < 2000000) {
        $bonus = 10;
    } elseif ($amount >= 5000000 && $amount < 10000000) {
        $bonus = 10;
    } elseif ($amount >= 10000000) {
        $bonus = 10;
    }

    $bonusMoney = $amount * ($bonus / 100);
    $total = $amount + $bonusMoney;

    $sql = "UPDATE account SET ruby = ruby + ?, danap = danap + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$total, $total, $id]);
}

function insertTransactionHistory($id, $refNo, $transactionDate, $amount, $receiverAccountName, $accountNo, $bankName, $conn)
{
    $sql = "INSERT INTO atm_lichsu 
    (user_nap, magiaodich, thoigian, sotien, status, benAccountName, accountNo, bankName)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        $id,
        $refNo,
        $transactionDate,
        $amount,
        1,
        $receiverAccountName,
        $accountNo,
        $bankName
    ]);
}

function insertCheckTransaction($refNo, $conn)
{
    $sql = "INSERT INTO atm_check (tranid) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$refNo]);
}

?>