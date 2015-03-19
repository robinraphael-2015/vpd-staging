<?php

ini_set('memory_limit', '-1');	
set_time_limit(0);
error_reporting(E_ALL | E_STRICT);


require_once('app/Mage.php'); //Path to Magento
ini_set('display_errors', 1);
umask(0);
Mage::app();

$resource = Mage::getSingleton('core/resource'); 

 $readConnection = $resource->getConnection('core_read');
 $writeConnection = $resource->getConnection('core_write');



// attribute code
$attribute_code = 'manufacturer_name ';

$productModel = Mage::getModel('catalog/product'); 

// load attribute by attribute code
$attribute = $productModel->getResource()->getAttribute($attribute_code);
 echo $attribute_id=$attribute->getId();
//die();



 $query="select option_id from `eav_attribute_option` where attribute_id='".$attribute_id."'";

 $data=$readConnection->fetchAll($query);

 foreach($data as $key=>$value)
 {
 	$key1[]=$data[$key]['option_id'];
 	
 }

 $ids=join(',',$key1);


$query="select option_id,value from `eav_attribute_option_value` where option_id in ($ids) and store_id=0 ";
$data=$readConnection->fetchAll($query);

 foreach($data as $key=>$value)
 {
 	$key1=$data[$key]['option_id'];
 	
	$manufacture[$key1]=$data[$key]['value'];
 }
 //var_dump($manufacture);
 

 //die();
$path=Mage::getBaseDir();
$realpath=$path.'/manfname.csv';

$read = fopen($realpath, 'r');
  //var_dump($product_id);die();
while (($row = fgetcsv($read)) !== false)
{
      $manuf_name=trim($row[0]);

  if(!array_search($manuf_name, $manufacture))
     {
      echo $query1="insert into eav_attribute_option(attribute_id,sort_order) values('".$attribute_id."','0')";
      echo "<br>";
	  $writeConnection->query($query1);
	  if($writeConnection->lastInsertId())
	  {
	  	$option_id=$writeConnection->lastInsertId();
        echo $query1="insert into eav_attribute_option_value(option_id,store_id,value) values('".$option_id."','0','".$manuf_name."')";
	    $as=$writeConnection->query($query1);
	    echo "<br>";
	    echo $query1="insert into eav_attribute_option_value(option_id,store_id,value) values('".$option_id."','1','".$manuf_name."')";
	    $as=$writeConnection->query($query1);
	    echo "<br><br><br><br><br><br>";
	    $manufacture[$option_id]=$manuf_name;
	  }




    }

}
?>