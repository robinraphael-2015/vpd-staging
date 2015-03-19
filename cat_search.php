<?php
 	ini_set('memory_limit', '-1');	
set_time_limit(0);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once('app/Mage.php'); //Path to Magento
umask(0);
Mage::app();

// attribute code
//$attribute_code = 'supplier';
$attribute_code = 'visibility';
 
$productModel = Mage::getModel('catalog/product'); 

// load attribute by attribute code
$attribute = $productModel->getResource()->getAttribute($attribute_code);
 echo $attribute_id=$attribute->getId();
//die();
$resource        = Mage::getSingleton('core/resource'); 

$readConnection  = $resource->getConnection('core_read');
$writeConnection = $resource->getConnection('core_write');

$query = "select entity_id,sku from `catalog_product_entity` where sku IS NOT Null";
$data  = $readConnection->fetchAll($query);
foreach($data as $key=>$value)
{
	 $product_ids[$value['sku']]=$value['entity_id'];
	//echo '<br/>';
}
$path     = Mage::getBaseDir();
$realpath = $path.'/qty1.csv';
$iw   = 0;
$read = fopen($realpath, 'r');
try{
	while (($row = fgetcsv($read)) !== false)
	{
		echo $sku = $row[0];
		if(array_key_exists($sku, $product_ids))
		{
			$id=$product_ids[$sku];
			echo $query = "update catalog_product_entity_int set value =4 where attribute_id ='".$attribute_id."' and  entity_id='".$id."'";
		    $writeConnection->query($query);
		    echo "<br>";
		}
		else{
		  // $iw++;
		  echo $sku." Not updated<br>";
		}
	}
} 
catch (Exception $e) {
	d($e->getMessage());
}
echo "finished";

?>