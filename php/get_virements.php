<?php
    /* pour le sort  */
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 's_date';  
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
    /* where de recherche   */
    $searchAn = isset($_POST['searchAn']) ? intval($_POST['searchAn']) : 0;  
    
    if ($searchAn > 0 ) {
        $where="and YEAR(s.s_date)='".$searchAn."'";
    } else {
        $where="and YEAR(s.s_date)='".date(Y)."'";            
    }
    
        
    $result = array();

    include 'conn.php';
    
    
    $rs = mysql_query("select count(*) from soins as s WHERE  s.s_pay='V' ".$where);
    $row = mysql_fetch_row($rs);
    $result["total"] = $row[0];
    $sql = "SELECT s_id as id, p.nom, p.prenom,  s_date,  s.s_asd, s.s_hono,  s.s_pay_le FROM `soins` as s, patients as p WHERE s.sis_id=p.SIS and s.s_pay='V' ".$where." order by ".$sort." ".$order; 
    $rs = mysql_query($sql);
    
    $items = array();
    while($row = mysql_fetch_object($rs)){
        $myrow = array();
        $myrow = array('id'=>$row->id,
                        'nom'=>utf8_encode($row->nom),
                        'prenom'=>utf8_encode($row->prenom),
                        's_date'=>$row->s_date, 
                        's_asd'=>$row->s_asd,
                        's_hono'=>$row->s_hono, 
                        's_pay_le'=>$row->s_pay_le);
        array_push($items, $myrow);
    }
    $result["rows"] = $items;

    /* pour le footer */
    $items = array();
    
    /* chris */
    $sql="select sum(s.s_hono) from `soins` as s where s.s_pay='V' ".$where;
    $rs = mysql_query($sql);    
    $tot = array('s_asd'=>'Total Virements:');
    $row = mysql_fetch_row($rs);
    $tot["s_hono"]= $row[0];
    array_push($items, $tot);
    /* sousou */
    $sql="select sum(s.s_hono) from `soins` as s where s.s_pay='V' and s.s_pay_le IS NULL  ".$where;
    $rs = mysql_query($sql);    
    $tot = array('s_asd'=>'Total Non Payé:');
    $row = mysql_fetch_row($rs);
    $tot["s_hono"]= $row[0];
    array_push($items, $tot);
    
    $result["footer"] = $items;
    
    //echo $rs;
    echo json_encode($result);

?>