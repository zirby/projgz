<?php
    /* pour le sort  */
    $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'sis';  
    $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
    /* where de recherche   */
    $searchMois = isset($_POST['searchAnnivMois']) ? intval($_POST['searchAnnivMois']) : date("n");  
    
    $searchMois = sprintf("%02d", strval($searchMois));
    
    $where="and mid(SIS,5,2)='".$searchMois."'";
        
    $result = array();

    include 'conn.php';
    
    
    $sql = "SELECT sis, nom, prenom, mid(SIS,7,2) as jour FROM  patients WHERE 1=1 ".$where." order by ".$sort." ".$order; 
    $rs = mysql_query($sql);
    
    $items = array();
    while($row = mysql_fetch_object($rs)){
        $myrow = array();
        $myrow = array('sis'=>$row->sis,'nom'=>$row->nom,'prenom'=>utf8_encode($row->prenom), 'jour'=>$row->jour,'age'=>sis2age($row->sis));
        array_push($items, $myrow);
    }
    $result["rows"] = $items;

    echo json_encode($result);

?>