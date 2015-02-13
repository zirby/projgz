<?php

$id = intval($_REQUEST['id']);
$s_pay_le = isset($_REQUEST['s_pay_le']) ? strval($_REQUEST['s_pay_le']) : '';  

include 'conn.php';

if($s_pay_le=='')
    $s_pay_le_up="s_pay_le=NULL";
else
     $s_pay_le_up="s_pay_le='".$s_pay_le."'";

$sql = "update soins set ".$s_pay_le_up." where s_id=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('msg'=>$sql));
}
?>