<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" type="text/css" href="../css/print.css" />
    </head>
    <body>
        <header id="banner" class="printer">
            <h1>Impression de la recette</h1>
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
                </tr>
            </thead>

<?php
    /* where de recherche   */
    $searchToday = isset($_POST['searchToday']) ? $_POST['searchToday'] : 0;  
    
    if ($searchToday > 0 ) {
        $where="and s.s_date='".$searchToday."'";
    } else {
        $where="and s.s_date='".date('Y-m-d')."'";            
    }
        
    $result = array();

    include 'conn.php';
    
    
    $sql = "SELECT s_id as id, p.nom, p.prenom,  s_date,  s.s_asd, s.s_hono, s.s_pay FROM `soins` as s, patients as p WHERE s.sis_id=p.SIS  ".$where." order by s.s_id asc"; 
    $rs = mysql_query($sql);
    //echo $sql;
    $items = array();
    while($row = mysql_fetch_object($rs)){
        echo "<tr>";
        echo "<td>".$row->id."</td><td>".$row->nom."</td><td>".$row->prenom."</td><td>".$row->s_date."</td><td>".$row->s_asd."</td><td>".$row->s_hono."</td><td>".$row->s_pay."</td>";
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