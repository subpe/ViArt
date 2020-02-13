<?php
	include_once("../includes/bppg_helper.php");
	
	$is_admin_path = true;
	$root_folder_path = "../";

	include_once ($root_folder_path ."includes/common.php");
	include_once ($root_folder_path ."includes/order_items.php");
	include_once ($root_folder_path ."messages/".$language_code."/cart_messages.php");
	include_once ($root_folder_path ."includes/parameters.php");
	    
	$vc = get_session("session_vc");
	$order_id = get_session("session_order_id");
	
	
	$order_errors = check_order($order_id, $vc);
	if($order_errors) {
		echo $order_errors;
		exit;
	}
	
	$post_parameters = ""; 
	$payment_params = array(); 
	$pass_parameters = array(); 
	$pass_data = array(); 
	$variables = array();
    $product_id=$order_id;
	get_payment_parameters($order_id, $payment_params, $pass_parameters, $post_parameters, $pass_data, $variables, "");

	$checkSum = "";
	$paramList = array();
	$callback_url = get_setting_value($payment_params, "callback_url", "");

	@$invoice=$_POST["invoice"];
    $ORDER_ID= $product_id;
	$CUST_ID = $_POST["email"];
	
	$INDUSTRY_TYPE_ID = get_setting_value($payment_params, "industry", "");
	
	$CHANNEL_ID = get_setting_value($payment_params, "channel", "");	
	$email = $_POST["email"];
	@$TXN_AMOUNT = $_POST["amount"];

	
	 $_POST['amount_'];
	
	
	 $paramList["MID"] = get_setting_value($payment_params, "merchant_id", "");
	
	$paramList["ORDER_ID"] = $ORDER_ID;
	$paramList["CUST_ID"] = $CUST_ID;
	$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
    $paramList["CHANNEL_ID"] = $CHANNEL_ID;
	$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
	$paramList["WEBSITE"] = get_setting_value($payment_params, "merchant_website", "");
	$paramList["CALLBACK_URL"] = $callback_url;
	$post_url = get_setting_value($payment_params, "transaction_url", "");
	$pg_transaction = new BPPGModule;
	$pg_transaction->setPayId($paramList['MID']);
	$pg_transaction->setPgRequestUrl("$post_url");
	$pg_transaction->setSalt($_POST['merchant_key']);
	$pg_transaction->setReturnUrl($_POST['callback_url']);
	$pg_transaction->setCurrencyCode(356);
	$pg_transaction->setTxnType('SALE');
	$pg_transaction->setOrderId($_POST['invoice_']);
	@$pg_transaction->setCustEmail($_POST['email']);
	@$pg_transaction->setCustName($_POST['name']);
		// @$pg_transaction->setCustStreetAddress1($_REQUEST['CUST_STREET_ADDRESS1']);
		// @$pg_transaction->setCustCity($_REQUEST['CUST_CITY']);
		// @$pg_transaction->setCustState($_REQUEST['CUST_STATE']);
		// @$pg_transaction->setCustCountry($_REQUEST['CUST_COUNTRY']);
		// @$pg_transaction->setCustZip($_REQUEST['CUST_ZIP']);
		@$pg_transaction->setCustPhone('phone');
		@$pg_transaction->setAmount($_POST['amount_']*100); // convert to Rupee from Paisa
		@$pg_transaction->setProductDesc($_POST['industry_']);
		 $postdata = $pg_transaction->createTransactionRequest();

		 $pg_transaction->redirectForm($postdata);
         
	?>
	<html>
		<head>
			<title>Merchant Check Out Page</title>
		</head>
		<body>
			<center><h1>Please do not refresh this page...</h1></center>
			<form method="post" action="<?php echo $post_url; ?>" name="f1">
				<table border="1">
					<tbody>			
						<?php
						foreach($paramList as $name => $value) {
						echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
						}
						?>
						<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
					</tbody>
				</table>
				<script type="text/javascript">
				document.f1.submit();
				</script>
			</form>
		</body>
	</html>
	