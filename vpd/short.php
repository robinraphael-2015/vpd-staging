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

echo $query = "select entity_id from `catalog_product_entity_text` where attribute_id=73 and value like '%PARKER - MASTER CODE%'";
$data  = $readConnection->fetchAll($query);
$product_id =array();
echo '<pre>';
foreach($data as $val)
{
	$product_id= $val[entity_id];	
	$attribute_id=73;
	echo $sql    = "UPDATE `catalog_product_entity_text` SET `value` ='Parker' WHERE attribute_id=73 and  `entity_id` = '".$product_id."'";		 
	$as 	     = $writeConnection->query($sql);
	echo '<br/>';
}

echo "finished";
?>