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
$path     = Mage::getBaseDir();
$realpath = $path.'/remove.csv';
$iw   = 0;
$read = fopen($realpath, 'r');
try{
	while (($row = fgetcsv($read)) !== false)
	{
		// var_dump($row);
		// die();
		 $sku = $row[0];
		echo $productid = Mage::getModel('catalog/product')
	                  ->getIdBySku(trim($sku));
		try{
    Mage::getModel("catalog/product")->load($productid)->delete();
}catch(Exception $e){
    echo "Delete failed";
}
		//echo $sku.'has been deleted';
		echo '<br/>';

	}
} 
catch (Exception $e) {
	d($e->getMessage());
}
echo "finished";
?>