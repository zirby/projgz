<?php
require_once("fonctions.php");

/**
* Class DentaireService
* toutes les fonctions utiles pour le logiciel dantaire
*/
class DentaireService
{
	
	function DentaireService()
	{
		mysql_connect("localhost", "root", "root");
		mysql_select_db("dentaire");
	}
	/**
	@desc affiche les patients
	*/
	function getPatients()
	{
		$sql="select SIS, nom, prenom from patients limit 0,30";
		return mysql_query($sql);
	}
	/**
	@desc affiche le traitement d'un patient
	*/
	function getTraitementPatient($sis)
	{
		$id=$sis;
		//$sql = 'SELECT * FROM `soins` WHERE sis_id=1964021337313 LIMIT 0, 30 '; 
		$sql = 'SELECT * FROM `soins` WHERE sis_id='.$id.' LIMIT 0, 30 '; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le traitement d'un patient
	*/
	function getListTraitementPatient()
	{
		//$sql = "SELECT `sis_id` as SIS, `s_dent` as nom, `inami_id` as prenom FROM `soins` LIMIT 0, 20000"; 
		$sql = "SELECT `s_id` as SIS, patients.nom as nom, patients.prenom as prenom FROM `soins`, patients WHERE soins.sis_id=patients.SIS LIMIT 0,10000"; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le virements
	*/
	function getListVirements($annee)
	{
		$sql = "SELECT s_id as id, p.nom, p.prenom, DATE_FORMAT(s.s_date,'%d/%m/%Y') as s_date, YEAR(s.s_date) as an,  s.s_asd, s.s_hono,  s.s_pay_le FROM `soins` as s, patients as p WHERE s.sis_id=p.SIS and s.s_pay='V' and YEAR(s.s_date)='$annee' order by s_date"; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le total des virements
	*/
	function getTotalVirements($annee)
	{
		$sql = "SELECT SUM( s.s_hono) as sumhono FROM `soins` as s WHERE  s.s_pay='V' and YEAR(s.s_date)=$annee"; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le virements fait
	*/
	function getPayeVirements($annee)
	{
		$sql = "SELECT SUM( s.s_hono) as sumpaye FROM `soins` as s WHERE  s.s_pay='V' and s.s_pay_le IS NOT NULL and YEAR(s.s_date)=$annee "; 
		return mysql_query($sql);
	}
	/**
	@desc update la date de payement
	*/
	function setPayeVirements($id, $datepay)
	{
		$datepay=DATE2SQL($datepay);
		$sql = "UPDATE soins SET s_pay_le='$datepay' WHERE s_id=$id"; 
		if (mysql_query($sql)) {
			return $sql;
		} else {
			return "E-".$sql;
		}
	}
	/**
	@desc affiche le bilans par mois et per ann&eacute;e 
	*/
	function getHonoDays($mois, $annee)
	{
		$sql = "SELECT SUM( s.s_hono) as sumhono, DAYOFMONTH(s.s_date) as jour  FROM `soins` as s WHERE YEAR(s.s_date)=$annee and MONTH(s.s_date)=$mois Group by s.s_date order by jour "; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le recette du mois
	*/
	function getSumHonoDays($mois, $annee)
	{
		$sql = "SELECT SUM( s.s_hono) as sumhono FROM `soins` as s WHERE YEAR(s.s_date)=$annee and MONTH(s.s_date)=$mois "; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le bilans par mois et per ann&eacute;e 
	*/
	function getHonoMonths( $annee)
	{
		$sql = "SELECT SUM( s.s_hono) as sumhono, MONTH(s.s_date) as mois  FROM `soins` as s WHERE YEAR(s.s_date)=$annee Group by mois order by mois "; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le recette du an
	*/
	function getSumHonoMonths( $annee)
	{
		$sql = "SELECT SUM( s.s_hono) as sumhono FROM `soins` as s WHERE YEAR(s.s_date)=$annee "; 
		return mysql_query($sql);
	}
	/**
	@desc affiche le bilans par total par ann&eacute;e
	*/
	function getHonoGlobal()
	{
		$sql = "SELECT SUM( s.s_hono) as sumhono, YEAR(s.s_date) as an  FROM `soins` as s WHERE YEAR(s.s_date)>2003  Group by an order by an "; 
		return mysql_query($sql);
	}
	

}

?>