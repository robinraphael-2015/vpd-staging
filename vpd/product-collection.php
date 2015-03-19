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
/*$collection  = Mage::getModel('catalog/product')->getCollection()
				->addAttributeToSelect('*');
    			//->addFieldToFilter('status', array('eq' => '1',));


$i=0;
 foreach ($collection as $product) {
 // $product->getSku(); //get name
 //$product_id = Mage::getModel("catalog/product")->getIdBySku($product->getSku());
 $_product = Mage::getModel('catalog/product')->load($product->getId());
 //$ids = $_product->getCategoryIds();
 if(!$_product->getCategoryIds())
 {
 //echo $product->getSku(); 
//echo '</br>';
}

 }*/
$resource = Mage::getSingleton('core/resource'); 
$readConnection = $resource->getConnection('core_read');
$writeConnection = $resource->getConnection('core_write');

$query= "SELECT cpe.entity_id, cpe.sku FROM catalog_product_entity as cpe LEFT JOIN catalog_category_product as ccp on cpe.entity_id = ccp.product_id WHERE category_id IS NULL and cpe.sku IS Not NUll";
$data=$readConnection->fetchAll($query);
foreach($data as $key=>$value)
{

	echo $data[$key][entity_id].','.$data[$key][sku]."<br>";
}
