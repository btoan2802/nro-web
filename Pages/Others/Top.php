<?php
function convertNumberToText($number) {
    if ($number >= 1000000000) return round($number / 1000000000, 2) . ' tỉ';
    if ($number >= 1000000) return round($number / 1000000, 2) . ' triệu';
    if ($number >= 1000) return round($number / 1000, 2) . ' nghìn';
    return $number;
}
?>

<style>

.main{ color:#fff; }

.card{
background:rgba(0,0,0,0.45);
border:2px solid #3fa9ff;
border-radius:12px;
}

.table tbody td.top-1{
color:#ffd700 !important;
font-weight:bold;
text-shadow:0 0 6px rgba(255,215,0,0.8);
}

.table tbody td.top-2{
color:#cfd8dc !important;
font-weight:bold;
text-shadow:0 0 5px rgba(220,220,220,0.6);
}

.table tbody td.top-3{
color:#ff9c2f !important;
font-weight:bold;
text-shadow:0 0 5px rgba(255,140,0,0.6);
}

.btn-group button{
font-weight:bold;
border-radius:6px;
margin:2px;
}

.btn-group button:hover{
opacity:0.9;
transform:scale(1.05);
}

.table-wrapper{
width:100%;
overflow-x:auto;
}

.table{
background:rgba(10,20,35,0.9);
color:#fff;
border-radius:8px;
overflow:hidden;
}

.table thead{
background:linear-gradient(90deg,#1f6ed4,#3fa9ff);
color:#ffffff;
font-size:15px;
}

.table tbody td{
color:#ffffff !important;
}

.table-striped tbody tr:nth-of-type(odd){
background:rgba(255,255,255,0.06);
}

.table-striped tbody tr:nth-of-type(even){
background:rgba(0,0,0,0.25);
}

.table td,.table th{
white-space:nowrap;
border-color:#4ea3ff;
font-weight:500;
}

.table tbody tr:hover{
background:rgba(63,169,255,0.35);
}

@media (max-width:768px){

.table{ font-size:12px; }

.btn-group button{
font-size:12px;
padding:6px 10px;
}

}

#chuyensinh1,#boss1,#nhiemvu1,#banghoi1, #caothu1{

display:none;
}

</style>

<div class="main">
<div class="card">
<div class="card-body">

<div class="text-center h3 mb-3">BẢNG XẾP HẠNG</div>

<div class="d-flex justify-content-center">
<div class="btn-group">

<button class="btn fw-semibold" style="background:#6f42c1;color:#fff;" id="chuyensinh">Chuyển Sinh</button>
<button class="btn fw-semibold active" style="background:#dc3545;color:#fff;" id="luong">Top Nạp</button>
<button class="btn fw-semibold" style="background:#0dcaf0;color:#000;" id="nhiemvu">Leo Tháp</button>
<button class="btn fw-semibold" style="background:#20c997;color:#000;" id="banghoi">Bang Hội</button>

</div>
</div>

<div class="table-wrapper">

<!-- TOP NẠP -->

<?php
$query="SELECT player.name AS character_name,account.danap AS danap
FROM account
LEFT JOIN player ON account.id=player.account_id
WHERE account.is_admin = 0
ORDER BY account.danap DESC
LIMIT 20";

$stmt=$conn->prepare($query);
$stmt->execute();

echo '<table class="table table-striped table-hover table-bordered mt-3 text-center" id="luong1">';
echo '<thead><tr><th>TOP</th><th>Nhân vật</th><th>Tổng Nạp</th></tr></thead><tbody>';

$stt=1;

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

$name=!empty($row['character_name'])?$row['character_name']:'Chưa tạo nhân vật';
$nap=convertNumberToText($row['danap']);

$class='';
if($stt==1) $class='top-1';
elseif($stt==2) $class='top-2';
elseif($stt==3) $class='top-3';

echo "<tr>
<td class='{$class}'>{$stt}</td>
<td class='{$class}'>{$name}</td>
<td class='{$class}'>{$nap}</td>
</tr>";

$stt++;
}

echo '</tbody></table>';
?>
<!-- TOP CHUYỂN SINH -->

<table class="table table-striped table-hover table-bordered mt-3 text-center" id="chuyensinh1">

<thead>
<tr>
<th>TOP</th>
<th>Nhân vật</th>
<th>Chuyển Sinh</th>
</tr>
</thead>

<tbody>

<?php

$query="
SELECT 
player.name,
(
  CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(player.chuyen_sinh_su_phu,'[',-1),',',1) AS UNSIGNED)
  - player.chuyensinh_base
) AS chuyensinh
FROM player
JOIN account ON player.account_id = account.id
WHERE account.is_admin = 0
ORDER BY chuyensinh DESC
LIMIT 20
";

$stmt=$conn->prepare($query);
$stmt->execute();

$stt=1;

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

$name=htmlspecialchars($row['name']);
$rebirth=$row['chuyensinh'];

$class='';
if($stt==1) $class='top-1';
elseif($stt==2) $class='top-2';
elseif($stt==3) $class='top-3';

echo "<tr>
<td class='{$class}'>{$stt}</td>
<td class='{$class}'>{$name}</td>
<td class='{$class}'>{$rebirth}</td>
</tr>";

$stt++;

}

?>

</tbody>
</table>


<!-- TOP SỨC MẠNH -->

<table class="table table-striped table-hover table-bordered mt-3 text-center" id="caothu1">
<thead>
<tr>
<th>TOP</th>
<th>Nhân vật</th>
<th>Sức Mạnh</th>
</tr>
</thead>
<tbody>

<?php

$query="SELECT player.name,data_point
FROM player
JOIN account ON player.account_id = account.id
WHERE account.is_admin = 0";

$stmt=$conn->prepare($query);
$stmt->execute();

$players=[];

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

$data_point=explode(',',$row['data_point']);
$power=isset($data_point[1])?(int)$data_point[1]:0;

$players[]=[
'name'=>htmlspecialchars($row['name']),
'power'=>$power
];
}

usort($players,function($a,$b){
return $b['power']-$a['power'];
});

$stt=1;

foreach(array_slice($players,0,20) as $player){

echo "<tr>
<td>{$stt}</td>
<td>{$player['name']}</td>
<td>".convertNumberToText($player['power'])."</td>
</tr>";

$stt++;
}

?>

</tbody>
</table>

<!-- TOP NHIỆM VỤ -->
 

                    <!-- TOP NHIỆM VỤ (ĐÃ COMMENT - KHÔNG XOÁ) -->

<!--
<table class="table table-striped table-hover table-bordered mt-3 text-center" id="nhiemvu1">
<thead>
<tr>
<th>TOP</th>
<th>Nhân vật</th>
<th>ID nhiệm vụ</th>
<th>Tên nhiệm vụ</th>
<th>Tiến độ</th>
</tr>
</thead>
<tbody>

<?php

$query="SELECT player.name,data_task
FROM player
JOIN account ON player.account_id = account.id
WHERE account.is_admin = 0";

$stmt=$conn->prepare($query);
$stmt->execute();

$tasks=[];

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

$data_task = trim($row['data_task'],'[]');
$data_task = explode(',', $data_task);

$count = isset($data_task[0]) ? (int)$data_task[0] : 0;
$task_main = isset($data_task[1]) ? (int)$data_task[1] : 0;
$task_sub = isset($data_task[2]) ? (int)$data_task[2] : 0;

$q="SELECT NAME,max_count 
FROM task_sub_template 
WHERE task_main_id=? 
LIMIT 1 OFFSET ".$task_sub;

$s=$conn->prepare($q);
$s->execute([$task_main]);

$taskInfo=$s->fetch(PDO::FETCH_ASSOC);

$task_name = $taskInfo['NAME'] ?? 'Không rõ';
$max_count = $taskInfo['max_count'] ?? 0;

$tasks[]=[
'name'=>htmlspecialchars($row['name']),
'id'=>$task_main,
'task_name'=>$task_name,
'count'=>$count,
'max'=>$max_count
];

}

usort($tasks,function($a,$b){
return $b['id']-$a['id'];
});

$stt=1;

foreach(array_slice($tasks,0,20) as $task){

$progress=$task['count']."/".$task['max'];

echo "<tr>
<td>{$stt}</td>
<td>{$task['name']}</td>
<td>{$task['id']}</td>
<td>{$task['task_name']}</td>
<td>{$progress}</td>
</tr>";

$stt++;

}

?>

</tbody>
</table>
-->



<!-- TOP LEO THÁP (MỚI) -->

<table class="table table-striped table-hover table-bordered mt-3 text-center" id="nhiemvu1">
<thead>
<tr>
<th>TOP</th>
<th>Nhân vật</th>
<th>Tầng</th>
<th>Thời gian</th>
</tr>
</thead>
<tbody>

<?php

$query="
SELECT player.name, player.levelKill_leothap, player.timeKill_leothap
FROM player
JOIN account ON player.account_id = account.id
WHERE account.is_admin = 0
ORDER BY CAST(player.levelKill_leothap AS UNSIGNED) DESC,
         CAST(player.timeKill_leothap AS UNSIGNED) ASC
LIMIT 20
";

$stmt=$conn->prepare($query);
$stmt->execute();

$stt=1;

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

$name = htmlspecialchars($row['name']);
$level = (int)$row['levelKill_leothap'];
$time = (int)$row['timeKill_leothap'];

// convert ms -> giây
$seconds = floor($time / 1000);

$class='';
if($stt==1) $class='top-1';
elseif($stt==2) $class='top-2';
elseif($stt==3) $class='top-3';

echo "<tr>
<td class='{$class}'>{$stt}</td>
<td class='{$class}'>{$name}</td>
<td class='{$class}'>{$level}</td>
<td class='{$class}'>{$seconds} giây</td>
</tr>";

$stt++;

}

?>

</tbody>
</table>

<!-- TOP BANG HỘI -->

<table class="table table-striped table-hover table-bordered mt-3 text-center" id="banghoi1">
<thead>
<tr>
<th>TOP</th>
<th>Bang Hội</th>
<th>Cấp</th>
<th>Điểm</th>
<th>Thành viên</th>
</tr>
</thead>
<tbody>

<?php

$query="SELECT 
NAME,
LEVEL,
clan_point,
JSON_LENGTH(members) AS member_count,
max_member
FROM clan_sv1
ORDER BY clan_point DESC
LIMIT 20";
$stmt=$conn->prepare($query);
$stmt->execute();

$stt=1;

while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

echo "<tr>
<td>{$stt}</td>
<td>{$row['NAME']}</td>
<td>{$row['LEVEL']}</td>
<td>{$row['clan_point']}</td>
<td>{$row['member_count']}/{$row['max_member']}</td>
</tr>";

$stt++;

}

?>

</tbody>
</table>

</div>
</div>
</div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

const tables={
chuyensinh:"chuyensinh1",
boss:"boss1",
luong:"luong1",
nhiemvu:"nhiemvu1",
banghoi:"banghoi1"
};

Object.keys(tables).forEach(id=>{

const btn=document.getElementById(id);

if(!btn) return;

btn.addEventListener("click",function(){

document.querySelectorAll('.btn-group button').forEach(btn=>btn.classList.remove('active'));

this.classList.add('active');

Object.values(tables).forEach(tableId=>{
const table=document.getElementById(tableId);
if(table) table.style.display="none";
});

const showTable=document.getElementById(tables[id]);
if(showTable) showTable.style.display="table";

});

});

});

</script>