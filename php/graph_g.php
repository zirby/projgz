<?php
    //phpinfo();

    $result = array();
    $items = array();
    
    include 'conn.php';
    
    $result["label"] = "Global";

 
        $sql= "SELECT sum(s_hono) as sumAn,  year(s_date) as an FROM soins group by year(s_date)";
        //echo $sql;
        
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