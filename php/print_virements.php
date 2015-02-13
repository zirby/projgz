<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../css/print.css" />
    </head>
    <body>
        <header id="banner" class="printer">
            <h1>Impression des virements</h1>
            <a href="javascript:window.print()">Print This Page</a> 
        </header>
        <section id="content" class="printer">
            <table cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOM</th>
                    <th>PRENOM</th>
                    <th>DATE</th>
                    <th>ASD</th>
                    <th>HONO</th>
                    <th>PAYE LE</th>
                </tr>
            </thead>

<?php
    /* where de recherche   */
    $searchAn = isset($_GET['searchAn']) ? intval($_GET['searchAn']) : 0;  
    
    if ($searchAn > 0 ) {
        $where="and YEAR(s.s_date)='".$searchAn."'";
    } else {
        $where="and YEAR(s.s_date)='".date(Y)."'";            
    }
    

    include 'conn.php';
    $test="toto";
    
    $sql = "SELECT s_id as id, p.nom, p.prenom,  s_date,  s.s_asd, s.s_hono,  s.s_pay_le FROM `soins` as s, patients as p WHERE s.sis_id=p.SIS and s.s_pay='V' ".$where." order by s.s_date desc"; 
    $rs = mysql_query($sql);
    
    $items = array();
    while($row = mysql_fetch_object($rs)){
        echo "<tr>";
        echo "<td>".$row->id."</td><td>".$row->nom."</td><td>".$row->prenom."</td><td>".$row->s_date."</td><td>".$row->s_asd."</td><td>".$row->s_hono."</td><td>".$row->s_pay_le."</td>";
        echo "</tr>";
    }
    
?>
            </table>
        </section>
        <header id="footer" class="printer">
        	<p><?php echo "le ".date('d/m/Y'); ?></p>
        </header>
    </body>
</html>