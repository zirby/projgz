<?php

    include 'conn.php';
    
    $rs = mysql_query("select distinct year(s_date) as an from soins order by s_date desc" );
    
    $items = array();
    while($row = mysql_fetch_object($rs)){
        array_push($items, $row);
    }

    echo json_encode($items);
?>