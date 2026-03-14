<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');

$_Login = null;
$_Users = $_SESSION['account'] ?? null;
$_Ip = $_SERVER['REMOTE_ADDR'];

if (!function_exists('fetchUserData')) {
function fetchUserData($conn, $Username) {
    $stmt = $conn->prepare("SELECT * FROM account WHERE username = :username");
    $stmt->bindValue(":username", $Username, PDO::PARAM_STR);
    $stmt->execute();
    $user_arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user_arr) return null;

    foreach ($user_arr as $key => $value) {
        $user_data[$key] = htmlspecialchars($value ?? '');
    }

    return [
        "_id" => $user_data['id'],
        "_admin" => $user_data['is_admin'],
        "_user" => $user_data['username'],
        "_Pass" => $user_data['password'],
        "_cash" => $user_data['cash'] ?? 0,
        "_tcash" => $user_data['danap'] ?? 0,
        "_status" => $user_data['active']
    ];
}
}

if (!function_exists('sanitizeUserData')) {
function sanitizeUserData($data) {
    if ($data === null) return null;
    return is_array($data) ? array_map('sanitizeUserData', $data) : htmlspecialchars($data);
}
}

if ($_Users) {
    $_Login = "on";
    $user_data = sanitizeUserData(fetchUserData($conn, $_Users));

    $_Admin = $user_data['_admin'];
    $_Id = $user_data['_id'];
    $_Username = $user_data["_user"];
    $_Password = $user_data["_Pass"];
    $_cashs = $user_data["_cash"];
    $_Tcashs = $user_data["_tcash"];
    $_Status = $user_data["_status"];
}

if (!function_exists('formatMoney')) {
function formatMoney($number) {
    if (!is_numeric($number) || $number === null) return '0 VNĐ';

    $suffix = '';
    if ($number >= 1e12) { $number /= 1e12; $suffix = ' Tỷ'; }
    elseif ($number >= 1e9) { $number /= 1e9; $suffix = ' Tỷ'; }
    elseif ($number >= 1e6) { $number /= 1e6; $suffix = ' Triệu'; }
    elseif ($number >= 1e3) { $number /= 1e3; $suffix = ' K'; }

    return number_format($number) . $suffix;
}
}

if (!function_exists('isValidInput')) {
function isValidInput($input) {
    return preg_match('/^[a-zA-Z0-9_]+$/', $input) && strlen($input) <= 255;
}
}

if (!function_exists('validateCaptcha')) {
function validateCaptcha($input, $captchaText) {
    return strtoupper($input) === strtoupper($captchaText);
}
}

if (!function_exists('generateCaptcha')) {
function generateCaptcha($length = 6) {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    return substr(str_shuffle($characters), 0, $length);
}
}

if (!isset($_POST["captcha"])) {
    $_SESSION['captcha'] = generateCaptcha();
}

if (!function_exists('checkExistingUsername')) {
function checkExistingUsername($conn, $Username) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE username = :username");
    $stmt->bindValue(':username', $Username, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
}

if (!function_exists('checkExistingEmail')) {
function checkExistingEmail($conn, $Email) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM account WHERE email = :email");
    $stmt->bindValue(':email', $Email, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
}

if (!function_exists('insertAccount')) {
function insertAccount($conn, $Username, $Password, $IPAddress) {
    $stmt = $conn->prepare("INSERT INTO account (username, password, ip_address) VALUES (:account, :password, :ip_address)");
    $stmt->bindValue(':account', $Username, PDO::PARAM_STR);
    $stmt->bindValue(':password', $Password, PDO::PARAM_STR);
    $stmt->bindValue(':ip_address', $IPAddress, PDO::PARAM_STR);
    return $stmt->execute();
}
}

if (!function_exists('hasIPBeenUsedForReferral')) {
function hasIPBeenUsedForReferral($conn, $IP) {
    $stmt = $conn->prepare("SELECT idRef FROM referrals WHERE IP = ?");
    $stmt->bindValue(1, $IP, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn();
}
}

if (!function_exists('checkReferralAlreadyAwarded')) {
function checkReferralAlreadyAwarded($conn, $IP, $idRef) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM referrals WHERE IP = ? AND idRef = ?");
    $stmt->bindValue(1, $IP, PDO::PARAM_STR);
    $stmt->bindValue(2, $idRef, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
}

if (!function_exists('getReferrerIP')) {
function getReferrerIP($conn, $idRef) {
    $stmt = $conn->prepare("SELECT ip_address FROM account WHERE id = :idRef");
    $stmt->bindValue(':idRef', $idRef, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}
}

if (!function_exists('updateReferralPoints')) {
function updateReferralPoints($conn, $idRef) {
    $stmt = $conn->prepare("UPDATE account SET referral_points = referral_points + 1 WHERE id = ?");
    $stmt->bindValue(1, $idRef, PDO::PARAM_INT);
    $stmt->execute();
}
}

if (!function_exists('logReferral')) {
function logReferral($conn, $IP, $idRef) {
    $stmt = $conn->prepare("INSERT INTO referrals (IP, idRef) VALUES (?, ?)");
    $stmt->bindValue(1, $IP, PDO::PARAM_STR);
    $stmt->bindValue(2, $idRef, PDO::PARAM_INT);
    $stmt->execute();
}
}
?>