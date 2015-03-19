<?php

ini_set('memory_limit', '-1');	
set_time_limit(0);
error_reporting(E_ALL | E_STRICT);


require_once('app/Mage.php'); //Path to Magento
ini_set('display_errors', 1);
umask(0);
Mage::app();



// attribute code
$attribute_code = 'name';

$productModel = Mage::getModel('catalog/product'); 

// load attribute by attribute code
$attribute = $productModel->getResource()->getAttribute($attribute_code);
 echo $attribute_id=$attribute->getId();
//die();

$resource = Mage::getSingleton('core/resource'); 

 $readConnection = $resource->getConnection('core_read');
 $writeConnection = $resource->getConnection('core_write');

 $query="select entity_id,sku from `catalog_product_entity` where sku IS NOT Null";
 $data=$readConnection->fetchAll($query);
 foreach($data as $key=>$value)
 {
 	$key1=$data[$key]['sku'];
	$product_id[$key1]=$data[$key]['entity_id'];
 }

 
$not_updated=array();
$not_in_table=array();
$updated=array();
$path=Mage::getBaseDir();
$realpath=$path.'/updatename.csv';

$read = fopen($realpath, 'r');
  //var_dump($product_id);die();
while (($row = fgetcsv($read)) !== false)
  {
  	///echo $row[1];
  	if(array_key_exists($row[0], $product_id))

     {
     	$sku_id=$row[0];
     	$productid=$product_id[$sku_id];
     	
       echo $sql = "UPDATE `catalog_product_entity_varchar` SET `value` ='".$row[1]."' WHERE `entity_id` = '".$productid."' and attribute_id='".$attribute_id."'";
       echo "<br>";
       $as=$writeConnection->query($sql);
             if($as){
                    $updated[$productid]=$sku_id;
                     }
                 else{
                      $not_in_table[$productid]=$sku_id;
                     }

     //die();
     
     }

     else 
        {
          $not_updated[]=$row[0];
        }
        

  }
  
  echo "Updated<br>";
  
  foreach($updated as $key=>$value){
   echo $updated[$key].','.$key."<br>";
  }

 echo "not Updated<br>";
  
  foreach($not_updated as $key=>$value){
   echo $not_updated[$key]."<br>";
  }

 echo "Not in table <br>";
  
  foreach($not_in_table as $key=>$value){
   echo $not_in_table[$key].','.$key."<br>";
  }
















?>