<?php
    /* pour le sort  */
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 's_id';  
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
    /* where de recherche   */
    $searchToday = isset($_POST['searchToday']) ? $_POST['searchToday'] : 0;  
    
    if ($searchToday > 0 ) {
        $where="and s.s_date='".$searchToday."'";
    } else {
        $where="and s.s_date='".date('Y-m-d')."'";            
    }
        
    $result = array();

    include 'conn.php';
    
    
    $sql = "SELECT s_id as id, p.nom, p.prenom,  s_date,  s.s_asd, s.s_hono,  s.s_pay_le, s.s_pay FROM `soins` as s, patients as p WHERE s.sis_id=p.SIS  ".$where." order by s.".$sort." ".$order; 
    $rs = mysql_query($sql);
    
    $items = array();
    while($row = mysql_fetch_object($rs)){
        $myrow = array();
        $myrow = array('id'=>$row->id,'nom'=>utf8_encode($row->nom),'prenom'=>utf8_encode($row->prenom), 's_asd'=>$row->s_asd, 's_date'=>$row->s_date, 's_hono'=>$row->s_hono, 's_pay_le'=>$row->s_pay_le, 's_pay'=>$row->s_pay);
        array_push($items, $myrow);
    }
    $result["rows"] = $items;

    /* pour le footer */
    $items = array();
    
    /* chris */
    $sql="select sum(s.s_hono) from `soins` as s where s.s_dentiste='Z' ".$where;
    $rs = mysql_query($sql);    
    $tot = array('s_asd'=>'Total Christ:');
    $row = mysql_fetch_row($rs);
    $tot["s_hono"]= $row[0];
    array_push($items, $tot);
    /* sousou */
    $sql="select sum(s.s_hono) from `soins` as s where s.s_dentiste='F' ".$where;
    $rs = mysql_query($sql);    
    $tot = array('s_asd'=>'Total Sousou:');
    $row = mysql_fetch_row($rs);
    $tot["s_hono"]= $row[0];
    array_push($items, $tot);
    
    $result["footer"] = $items;

    
    //echo $sql;
    echo json_encode($result);

?>