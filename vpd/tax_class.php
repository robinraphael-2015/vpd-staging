<?php 

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
$resource = Mage::getSingleton('core/resource'); 
$readConnection = $resource->getConnection('core_read');
$writeConnection = $resource->getConnection('core_write');
//$query = "SELECT * FROM catalog_product_entity_int where attribute_id=121";

$query = "SELECT product_id FROM cataloginventory_stock_item where qty=0";
  $results =$readConnection->fetchCol($query);
  //echo count($results);
  foreach($results as $pro_id)
  {

  	echo $pro_id;
  	echo $query1 ="UPDATE cataloginventory_stock_item SET is_in_stock=0 WHERE qty=0 and product_id=".$pro_id;
    echo '<br/>';
    echo $query2 ="UPDATE cataloginventory_stock_status SET stock_status=0,qty=0 WHERE  product_id=".$pro_id;
    echo '<br/>';
    $writeConnection->query($query1);
    $writeConnection->query($query2);
   echo $i;

  }
  echo 'finished';
  



/*$collection = Mage::getModel('catalog/product')->getCollection()
			->addAttributeToSelect('entity_id');
foreach($collection as $product) {
    echo $product_id=$product->getId();
	
	echo $sql = "UPDATE `catalog_product_entity_int` SET `value`=4 WHERE `attribute_id`=121 and `entity_id`=".$product_id;
          $as=$writeConnection->query($sql);
	echo '<br/>';
}*/

?>