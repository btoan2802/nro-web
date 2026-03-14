<?php
#Nguyen Duc Kien - Ngoc Rong Min
$_Logo = 'NROLEGION.png?v=' . time();
$_Domain = 'https://teamobiz.online/';
$_Title = 'Ngọc Rồng BT - Chơi Là Nghiện';
$_Description = 'Web đăng kí tải game';
$_Keyword = 'Nro BT, Nro, Nro Lậu, Ngọc Rồng, Ngọc Rồng Online, Chú Bé Rồng';

$_ForgotEmail = 'Email'; 
$_ForgotPass = 'Password'; 

#Tăng Giá Trị Đổi
$_GiaTri = '1'; 
$_GiaTriAtm = '1'; 
$_danap = '1';

$_TrangThai = '0'; // Hoạt Động = 1
$_FixWeb = '0'; // Bảo Trì = 1
$_AuthLog = '0';

#Hỗ Trợ
$_Zalo = 'https://zalo.me/g/vjyqws883';
$_ZaloX1 = '';
$_ZaloX2 = '';

#---------------#
#Downloads
$_Android = 'https://www.mediafire.com/file/1s1s1jixez3yjjf/NroMin%25282%2529.apk/file';
$_Iphone = 'https://www.mediafire.com/file/v1i87tgr6wucgob/NroMin%25282%2529.ipa/file';
$_Windows = 'https://www.mediafire.com/file/pjzk56ei3u9w0ue/NroMin%25282%2529.rar/file';
$_JavaX1 = '';

#Card
$Partner_Key = 'AAC18F8E764F83C105BEA957C2CA8B33';
$Partner_Id = '5154';
$_ApiCard = 'https://thesieutoc.net/';

#Atm - Mbbank
$userloginmbbank_config = 'taikhoan';
$passmbbank_config = 'matkhau';
$deviceIdCommon_goc_config = 'ssss';
$stkmbbank_config = '0461000632421';
$mbbank_name = 'NGUYEN VIET AN';
$_mbbank = 'Ngân Hàng VCB';

$_Token = ($conn->query("SELECT token FROM cpanel")->fetchColumn()) ?? '';

#Tạo Token
if (!function_exists('CreateToken')) {
    function CreateToken()
    {
        return md5(uniqid(rand(), true));
    }
}

#Chặn truy cập API
if (!function_exists('isLocalhost')) {
    function isLocalhost()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
        return in_array($_SERVER['REMOTE_ADDR'], $whitelist);
    }
}