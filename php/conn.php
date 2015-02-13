<?php

$conn = @mysql_connect('localhost','root','root');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('projg', $conn);

function date2SQL($dt)
{
  $dat=split("/",$dt);
    if (count($dat)==3) return sprintf("%4d-%02d-%02d",$dat[2],$dat[0],$dat[1]);
    //if (count($dat)==2) return sprintf("2004-%02d-%02d",$dat[1],$dat[0]);
    return $dt;
}
function sis2age($s){
    $birthyear=substr($s,0,4);
    $birthmonth=substr($s,4,2);
    $birthday=substr($s,6,2);
    $nowyear=date("Y");
    $nowmonth=date("m");
    $nowday=date("d");
    if (($nowmonth<$birthmonth) || (($nowmonth==$birthmonth) && ($nowday<$birthday))) {
        $correction=-1;
    } else {
        $correction=0;
    }
    $age=$nowyear-$birthyear+$correction;
    return $age;
}

?>