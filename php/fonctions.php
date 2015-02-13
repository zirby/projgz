<?php
/*
 * Created on 17 d�c. 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

	/**
	@desc faire date SQL vers date
	*/
	function SQL2DATE($dt)
	{
		$dat=explode("-",$dt);
		if($dat[0]!="0000" || $dat[1]!="00" || $dat[2]!="00")
			return sprintf("%02d/%02d/%4d",$dat[2],$dat[1],$dat[0]);
		else
			return "null";
	}
	/**
	@desc faire date SQL vers date
	*/
	function DATE2SQL($dt)
	{
		$dat=explode("/",$dt);
		if($dat[0]!="0000" || $dat[1]!="00" || $dat[2]!="00")
			return sprintf("%4d-%02d-%02d",$dat[2],$dat[1],$dat[0]);
		else
			return "null";
	}
	/**
	@desc faire date SQL vers date
	*/
	function DATEUK2SQL($dt)
	{
		$dat=explode("/",$dt);
		if($dat[0]!="0000" || $dat[1]!="00" || $dat[2]!="00")
			return sprintf("%4d-%02d-%02d",$dat[2],$dat[0],$dat[1]);
		else
			return "null";
	}
?>