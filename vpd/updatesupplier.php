<?php
 	ini_set('memory_limit', '-1');	
set_time_limit(0);
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once('app/Mage.php'); //Path to Magento
umask(0);
Mage::app();

// attribute code
$attribute_code = 'supplier';
//$attribute_code = 'visibility';
 
$productModel = Mage::getModel('catalog/product'); 

// load attribute by attribute code
$attribute = $productModel->getResource()->getAttribute($attribute_code);
 echo $attribute_id=$attribute->getId();



$resource = Mage::getSingleton('core/resource'); 

 $readConnection = $resource->getConnection('core_read');
 $writeConnection = $resource->getConnection('core_write');
 //$query="Update catalog_product_entity_varchar set value='Right Parts' where attribute_id='".$attribute_id."' and value is NULL";
 $query="select * from `catalog_product_entity_varchar` where value='Right Parts' and attribute_id='".$attribute_id."' order by entity_id asc";
 $data= $readConnection->fetchAll($query);
 var_dump($data);
 die();
 $query="select entity_id,sku from `catalog_product_entity` where sku IS NOT Null order by  entity_id ";
 $data=$readConnection->fetchAll($query);
 $existing="select entity_id from `catalog_product_entity_varchar` where attribute_id='".$attribute_id."'";
 $ext_id=$readConnection->fetchAll($existing);
 $product_id= array();
 foreach($ext_id as $key=>$value)
 {
 	$product_id[]=$ext_id[$key][entity_id];
 }
 //var_dump($product_id);

 
 foreach($data as $key=>$value)
 {
 	if(in_array($data[$key][entity_id], $product_id)){
  echo $query1="Update catalog_product_entity_varchar set value='Right Parts' where attribute_id='".$attribute_id."' and entity_id= '".$data[$key][entity_id]."' ";
	$as=$writeConnection->query($query1);
 	}
 	
	else{
	
	//break;
	
	}
     
 }



?>