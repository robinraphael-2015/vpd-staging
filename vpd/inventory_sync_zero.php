<?php

$today =date('D', $timestamp);
//if($today != 'Sun' && $today != 'Sat')
//{
ini_set('memory_limit', '-1');	
set_time_limit(0);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once 'app/Mage.php';
umask(0);
Mage::app('admin');
Mage::getSingleton('core/session', array('name' => 'adminhtml'));
$websiteId = 1;
ini_set('display_errors', 1);
$storeId = Mage::app()->getStore();
function d($data, $die = 0, $z = 3, $msg = 1) {
	echo"<br/><pre style='padding:0px 5px;background: none repeat scroll 0 0 #E04E19;clear: both;color: #FFFFFF;float: left;font-family: Times New Roman;font-style: italic;font-weight: bold;text-align: left;'>";
	if ($z == 1)
		Zend_Debug::dump($data);
	else if ($z == 2)
		var_dump($data);
	else
		print_r($data);
	echo"</pre>";
	if ($d == 1)
		die();

}
//Code for copying the Lippert file content
$path     = Mage::getBaseDir();
$realpath = $path.'/qty.csv';
$filename = Mage::getBaseDir().'/media/lippert/Lippert_Vehicle_PD.txt';
$contents = file($filename);
if($contents)
{
	unlink($realpath);
$resource        = Mage::getSingleton('core/resource'); 
$readConnection  = $resource->getConnection('core_read');
$writeConnection = $resource->getConnection('core_write');



$query = "select entity_id,sku from `catalog_product_entity` where sku IS NOT Null"; //Geting all the sku in the system
$data  = $readConnection->fetchAll($query);
$i=0;
$j=0;
foreach($data as $key=>$value)
{
	$product_ids[$value['sku']]=$value['entity_id'];
	$sku_db[$i]= $value['sku'];
	$i++;
}



//Code for moving Lippert file 

$originPath = Mage::getBaseDir().'/media/lippert/Lippert_Vehicle_PD.txt';
$date = date("Y-m-d");
$filename = $date.'Lippert_Vehicle_PD.txt';
$destinationPath = Mage::getBaseDir().'/media/lippert/Updated/'.$filename;
rename($originPath, $destinationPath);
//end of moving the file

$myfile = fopen($realpath, "w");

foreach($contents as $line) {
    
    $lineItems = explode("\t", $line);
    if ( count($lineItems) == 11 ) {
         $txt = "\"" . $lineItems[1] . "\"," . $lineItems[9] . "\n";
        // echo $txt;
        // echo '<br/>';
        fwrite($myfile, $txt);
       
    } else {
        echo "Invalid line '" . $line . "'\n";
    }
}
//exit();
//Code ending for qty.csv


$iw   = 0;
$read = fopen($realpath, 'r');
try{
	//while (($row = fgetcsv($read)) !== false)
	//{
		foreach($contents as $line) {
    
    $lineItems = explode("\t", $line);
    if ( count($lineItems) == 11 ) {
		
		 $csv_sheet[$j]=$lineItems[9];
		$j++;
		$sku = $lineItems[9];
		if(array_key_exists($sku, $product_ids))
		{
			$qty 		 = (int)($lineItems[1]);
			$productid   = $product_ids[$sku];

			$is_in_stock = 0;
			if($qty) $is_in_stock = 1;
		echo $sql    = "UPDATE `cataloginventory_stock_item` SET `qty` ='$qty',`is_in_stock`= '$is_in_stock',`use_config_manage_stock`='1', `manage_stock`='0',min_qty='0',use_config_max_sale_qty='1' WHERE `product_id` = '".$productid."'";		 
			$as 	     = $writeConnection->query($sql);
			
		}
		else{
		  // $iw++;
		 // echo $sku." Not updated<br>";
		}
	}
} 
}
catch (Exception $e) {
	d($e->getMessage());
}

$result = array_diff($sku_db, $csv_sheet);

foreach($result as $vals)
{
	
	echo $productid = Mage::getModel('catalog/product')
	                  ->getIdBySku(trim($vals));
	$attributeValue =$_product = Mage::getModel('catalog/product')->load($productid);
	echo	$supplier= $attributeValue['supplier'];                  
	                  
	$qty 		 = 0;
	$is_in_stock = 0;
			if($qty==0) $is_in_stock = 0;
			if($supplier=="Lippert")
			{
			echo $sql    = "UPDATE `cataloginventory_stock_item` SET `qty` ='$qty',`is_in_stock`= '$is_in_stock',`use_config_manage_stock`='1', `manage_stock`='1',min_qty='0' WHERE `product_id` = '".$productid."'";		 
			echo "<br>";
			$as 	     = $writeConnection->query($sql);
		}
}

$process = Mage::getModel('index/process')->load(8);
$process->reindexAll();


//Code for sending the mail.
$storeId = Mage::app()->getStore();
$templateId = 5;

 // Set sender information
  $senderName = Mage::getStoreConfig('trans_email/ident_support/name');
  $senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');
  $sender = array('name' => $senderName,
  'email' => $senderEmail);
$recepientEmail[0] = 'amjad.hussain@srgsaas.com';
  $recepientEmail[1] = 'raphaelbabugeorge@gmail.com';
   $recepientEmail[2] = 'peter.fishman@silkrouteglobal.com';
   $recepientEmail[3] = 'jason.kummerl@silkrouteglobal.com';
  $vars = array();
	$vars['total_count'] = (count($csv_sheet)-1);
   $vars['time'] =date("j F Y, \a\\t g.i a", time());
   $vars['day'] = date("j F Y");
  try {
  foreach($recepientEmail as $receiver)
         {
		$transactionalEmail = Mage::getModel('core/email_template')
           ->setDesignConfig(array('area' => 'frontend', 'store' => $storeId));
			 $transactionalEmail
            ->sendTransactional($templateId, $sender, $receiver, $recepientName, $vars, $storeId);

      
 $status = true;
 }
 } catch (Exception $e) { }
    return $status;
}//End of if loop

	


    ?>