<?php
    $searchMois = isset($_GET['searchMois']) ? intval($_GET['searchMois']) : 0;  
    
    if ($searchMois > 0 ) {
        $where="and MONTH(s_date)='".$searchMois."'";
    } else {
        $where="and MONTH(s_date)=1";  
    }

  	$result = array();
    $items = array();
    
	include 'conn.php';
	
	$result["label"] = "Mois: ".$searchMois;
    
    $sql= "SELECT sum(s_hono) as sumAn,  year(s_date) as an FROM soins WHERE 1=1 ".$where." group by year(s_date)";
       // echo $sql;
  
  
   $rs = mysql_query($sql);
    while($row = mysql_fetch_object($rs)){
        if($row->an >= 2005){
        $coord = array();
        $coord[0]=intval($row->an);
        $coord[1]=floatval($row->sumAn);
        array_push($items, $coord);
        }
    }
 
 	$result["data"] = $items;
	
	echo json_encode($result);

 ?>