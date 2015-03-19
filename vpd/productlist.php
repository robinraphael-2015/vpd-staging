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

$productModel = Mage::getModel('catalog/product'); 

// load attribute by attribute code
$attribute = $productModel->getResource()->getAttribute($attribute_code);
 echo $attribute_id=$attribute->getId();
//die();
/*//var_dump($products);

$i=0;

$storeId=0;

$_productCollection=Mage::getModel('catalog/product')
                    ->getCollection()
                    ->addAttributeToSelect('*') ;                                   
                    //->addAttributeToFilter('type_id','simple');
$storeId=0;

foreach($_productCollection as $_product){
   //$product = Mage::getModel('catalog/product')->load($_product->getEntityId());
	//echo $_product->getEntityId()."<br>";
	//echo $product->getId()."<br><br><br>";
    //$product = Mage::getModel('catalog/product')->load($_product->getEntityId());   
    $data=array('supplier'=>'Lippert');
   Mage::getSingleton('catalog/product_action')->updateAttributes(array($_product->getEntityId()), $data, $storeId);    
    echo $_product->getEntityId()."<br>";
    if($i==100){
	break;
}
$i++;
}*/


$resource = Mage::getSingleton('core/resource'); 

 $readConnection = $resource->getConnection('core_read');
 $writeConnection = $resource->getConnection('core_write');

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

 if(in_array('60047', $ext_id)){
 		echo "hai";
 //var_dump($ext_id);
 
 	}
 	//die();
 foreach($data as $key=>$value)
 {
 	if(in_array($data[$key][entity_id], $product_id)){
 		continue;
 	}
 	
	else{
	echo $query1="insert into catalog_product_entity_varchar(entity_type_id,attribute_id,store_id,entity_id,value) values('4','".$attribute_id."','0','".$data[$key][entity_id]."','Lippert')";
	$as=$writeConnection->query($query1);
	//break;
	
	}
     
 }



?>