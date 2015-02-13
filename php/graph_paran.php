<?php
    $searchAn = isset($_GET['searchAn']) ? intval($_GET['searchAn']) : 0;  
    
    if ($searchAn > 0 ) {
        $where="and YEAR(s_date)='".$searchAn."'";
    } else {
        $where="and YEAR(s_date)='".date(Y)."'";  
        //$where="and YEAR(s_date)='2011'";                
    }

  	$result = array();
    $items = array();
    
	include 'conn.php';
	
	$result["label"] = "Mois";
    for ($i=1; $i <= 12 ; $i++) {
        $sql= "select sum(s_hono) as sumMois from soins where MONTH(s_date)=$i $where";
        $rs = mysql_query($sql);
        $row = mysql_fetch_object($rs);
        $coord = array();
        $coord[0]=intval($i);
        $coord[1]=floatval($row->sumMois);
        array_push($items, $coord);
    }
	$result["data"] = $items;
	

	echo json_encode($result);
  
?>