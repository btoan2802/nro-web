<?php
include '../../Controllers/Header.php';
?>

<div class="card">
<div class="card-body">
<div class="col-md-12">
<div class="row text-center justify-content-center my-1 mb-2">

<div class="col-md-12 mb-4">

<div id="chooseAmountSection">

<div class="text-center">
<h5>Ngân Hàng</h5>
<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/37/TPBank_logo.svg/2560px-TPBank_logo.svg.png" width="120">
</div>

<div class="row justify-content-center my-3">

<?php

$amounts = [
20000 => "20,000 đ",
50000 => "50,000 đ",
100000 => "100,000 đ",
200000 => "200,000 đ",
500000 => "500,000 đ",
1000000 => "1,000,000 đ",
2000000 => "2,000,000 đ",
5000000 => "5,000,000 đ",
10000000 => "10,000,000 đ"
];

$bonus = [
20000 => "+0%",
50000 => "+0%",
100000 => "+10%",
200000 => "+10%",
500000 => "+10%",
1000000 => "+20%",
2000000 => "+20%",
5000000 => "+20%",
10000000 => "+50%"
];

foreach ($amounts as $value => $display) {

$percent = intval(str_replace(['+','%'],'',$bonus[$value]));
$cash = $value + ($value * $percent / 100);

echo "

<div class='col-4 my-2'>

<div class='recharge-method-item position-relative text-center p-2 rounded'

style='background:#FDF5E6;border:2px solid #F7C873;cursor:pointer'

onclick='selectAmount($value,\"$display\")'>

<div class='price_momo font-weight-bold'>$display</div>

<div class='text-primary'>Nhận ".number_format($cash)." cash</div>

<span class='text-white position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>

{$bonus[$value]}

</span>

</div>

</div>

";

}

?>

</div>

<div class="text-center mt-3">
<button id="confirmAmount" class="btn btn-primary w-50" onclick="showPaymentDetails()" disabled>
Thanh Toán
</button>
</div>

</div>


<div id="paymentDetailsSection" style="display:none;">

<div class="row justify-content-center align-items-start">

<div class="col-md-5 p-3 rounded mx-2"

style="background:#FDF5E6;border:2px solid #F7C873;box-shadow:0px 4px 6px rgba(0,0,0,0.1);">

<div class="text-center mb-4">

<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/37/TPBank_logo.svg/2560px-TPBank_logo.svg.png" width="80">

<h5 class="font-weight-bold mt-2">TP Bank</h5>

</div>

<table class="table text-left bg-transparent">

<tbody>

<tr>
<td class="font-weight-bold">Tên Tài Khoản:</td>
<td>
<span class="copy" data-clipboard-text="NGUYEN BAO TOAN">
NGUYEN BAO TOAN
<i class="fa fa-copy text-primary"></i>
</span>
</td>
</tr>

<tr>
<td class="font-weight-bold">Số Tài Khoản:</td>
<td>
<span class="copy" data-clipboard-text="00352925355">
00352925355
<i class="fa fa-copy text-primary"></i>
</span>
</td>
</tr>

<tr>
<td class="font-weight-bold">Ngân Hàng:</td>
<td>TP Bank</td>
</tr>

<tr>
<td class="font-weight-bold">Nội Dung Chuyển:</td>
<td>

<span class="copy" data-clipboard-text="NAP <?= $_Username ?>">
NAP <?= $_Username ?>
<i class="fa fa-copy text-primary"></i>

</span>

</td>
</tr>

<tr>
<td class="font-weight-bold">Số Tiền:</td>
<td id="selectedAmount">20,000 đ</td>
</tr>

</tbody>

</table>

<div class="text-center mt-3">

<img id="qrAtm"

width="200"

src="https://img.vietqr.io/image/TPB-00352925355-qr_only.png"

alt="QR Code TPBank" />

<p class="mt-2 text-muted">Quét QR để chuyển tiền</p>

</div>

</div>

</div>

<div class="text-center mt-4">

<p class="text-danger font-weight-bold">

Lưu ý: Chuyển đúng nội dung để hệ thống tự động cộng tiền.

</p>

</div>

</div>

</div>

</div>
</div>
</div>
</div>


<script>

let selectedAmount = 0;
let selectedDisplay = "";

function selectAmount(amount, display){

selectedAmount = amount;
selectedDisplay = display;

document.querySelectorAll(".recharge-method-item").forEach(item=>{
item.style.border="2px solid #F7C873";
});

event.currentTarget.style.border="2px solid #4CAF50";

document.getElementById("confirmAmount").disabled=false;

}

function showPaymentDetails(){

if(!selectedAmount){

alert("Vui lòng chọn mệnh giá");

return;

}

document.getElementById("selectedAmount").textContent = selectedDisplay;

document.getElementById("chooseAmountSection").style.display="none";

document.getElementById("paymentDetailsSection").style.display="block";

}


$(document).on('click','.copy',function(){

const text=$(this).data('clipboard-text');

navigator.clipboard.writeText(text).then(()=>{

alert('Đã sao chép: '+text);

});

});

</script>


<?php
include '../../Controllers/Footer.php';
?>