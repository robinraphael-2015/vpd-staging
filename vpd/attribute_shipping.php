<?php
//echo "sd"; 
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
$resource        = Mage::getSingleton('core/resource'); 

$readConnection  = $resource->getConnection('core_read');
$writeConnection = $resource->getConnection('core_write');

$query = "SELECT `entity_id` FROM `catalog_product_entity_varchar` WHERE `attribute_id` =141 AND `value` IS NOT NULL";
$data  = $readConnection->fetchAll($query);
foreach($data as $key=>$value)
{
	//$val ='';
	echo $productid=$value['entity_id'];
	echo '<br/>';
	echo $sql    = "UPDATE `catalog_product_entity_varchar` SET `value`=NULL WHERE attribute_id=141 and entity_id=$productid";		 
	$as 	     = $writeConnection->query($sql);
	echo "<br>";
}
/*$path     = Mage::getBaseDir();
//$realpath = $path.'/cost.csv';
$iw   = 0;
$read = fopen($realpath, 'r');
try{
	while (($row = fgetcsv($read)) !== false)
	{
		// var_dump($row);
		// die();
		$sku = $row[1];
		if(array_key_exists($sku, $product_ids))
		{
			$cost 		 = ($row[0]);
			$productid   = $product_ids[$sku];
			$is_in_stock = 0;
			if($qty) $is_in_stock = 1;
			echo $sql    = "UPDATE `catalog_product_entity_decimal` SET `value`=$cost WHERE attribute_id=75 and entity_id=$productid";		 
			$as 	     = $writeConnection->query($sql);
			echo "<br>";
			// die();
		}
		else{
		  // $iw++;
		//  echo $sku." Not updated<br>";
		}
	}
} 
catch (Exception $e) {
	d($e->getMessage());
}*/
echo "finished";