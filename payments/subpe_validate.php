<?php
	include_once("../includes/bppg_helper.php");
	$is_admin_path = true;
	$root_folder_path = "../";
	
	$paramList = array();
	//$isValid = "FALSE";


	//$paramList = $_POST;
	$bpayhash = isset($_POST["HASH"]) ? $_POST["HASH"] : ""; //Sent by \Subpe pg

	$paramList["AMOUNT"]= $_POST['AMOUNT'];
	$paramList["CURRENCY_CODE"]= $_POST['CURRENCY_CODE'];
	$paramList["CUST_EMAIL"]= $_POST['CUST_EMAIL'];
	$paramList["CUST_NAME"]= $_POST['CUST_NAME'];
	$paramList["CUST_PHONE"]=$_POST['CUST_PHONE'];
	$paramList["ORDER_ID"]= $_POST['ORDER_ID'];
	$paramList["PAY_ID"]= $_POST['TXN_ID'];
	$paramList["PRODUCT_DESC"]= $_POST['PRODUCT_DESC'];
	$paramList["RETURN_URL"]= $_POST['RETURN_URL'];
	$paramList["TXNTYPE"]= $_POST['TXNTYPE'];
	$paramList["HASH"]=$bpayhash;


	 if ($_POST['RESPONSE_CODE']=='000') {
	  	echo "Success";
	  } 
	  else{
	  	echo "Fail";
	  }


   







