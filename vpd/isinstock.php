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
 //echo "<pre>";
 //var_dump($product_id); die();
 /*$collection = Mage::getModel('catalog/product')
->getCollection();

$sku=array();
$product_id=array();

$data=$collection->getData();
foreach($data as $key=>$value)
{
	if($data[$key]['sku']) 
	{
		$key1=$data[$key]['sku'];
	$product_id[$key1]=$data[$key]['entity_id'];
     }
	//$sku[]=$data[$key]['sku'];
	//echo $data[$key]['sku']."<br>";
}*/

//print_r($product_id);


 //$query="select product_id from `cataloginventory_stock_item`";
 //$reading_id=$readConnection->fetchCol($query);
/// echo "<br>";
 //var_dump($reading_id);
 //$actualdata=array_diff($product_id, $reading_id);
 //var_dump($actualdata);
 //die();


$path=Mage::getBaseDir();
$realpath=$path.'/qty.csv';
$iw=0;
$read = fopen($realpath, 'r');
  //var_dump($product_id);die();
while (($row = fgetcsv($read)) !== false)
  {
  	///echo $row[1];
  	if(array_key_exists($row[0], $product_id))

     {
     	$sku_id=$row[0];
     	$productid=$product_id[$sku_id];
     	
    echo $sql = "UPDATE `
    cataloginventory_stock_item` SET `qty` ='".$row[1]."',`use_config_manage_stock`='1',`manage_stock`='1' WHERE `product_id` = '".$productid."'";
     
       //echo $as;
      //$sql="INSERT INTO `cataloginventory_stock_item`(`product_id`, `stock_id`, `qty`, `min_qty`, `use_config_min_qty`, `is_qty_decimal`, `backorders`, `use_config_backorders`, `min_sale_qty`, `use_config_min_sale_qty`, `max_sale_qty`, `use_config_max_sale_qty`, `is_in_stock`, `low_stock_date`, `notify_stock_qty`, `use_config_notify_stock_qty`, `manage_stock`, `use_config_manage_stock`, `stock_status_changed_auto`, `use_config_qty_increments`, `qty_increments`, `use_config_enable_qty_inc`, `enable_qty_increments`, `is_decimal_divided`) VALUES ($productid,1,$row[2],0,1,0,0,1,1,1,0,1,1,'NULL','NULL',1,1,1,0,1,0,1,0,0)";
     
     $as=$writeConnection->query($sql);
     echo $productid."<br>";
     //die();
     $iw++;
        }
        //else{
          //$iw++;
          //echo $row[0]."<br>";
        //}

  }
  
  //echo $iw;
echo "finished";

















/*while (($row = fgetcsv($read)) !== false)
  {
  	//echo "sa";
  	//print_r($sku);
  	if(in_array($row[0],$sku))
     {
     	$key=array_search($row[0],$sku);
     echo $row[0]."<br>";
     	echo $key;
     $sql = "UPDATE `cataloginventory_stock_item` SET `qty` ='".$row[2]."',`use_config_manage_stock`='1',`manage_stock`='1' WHERE `product_id` = '".$product_id[$key]."'";
     $as=$writeConnection->query($sql);
       //echo $as;
     }

  }*/ 

?>