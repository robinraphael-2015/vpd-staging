<?php

set_time_limit(0);
error_reporting(E_ALL | E_STRICT);
require_once 'app/Mage.php';
umask(0);
ini_set('display_errors', 1);
Mage::app('admin');
Mage::getSingleton('core/session', array('name' => 'adminhtml'));
$websiteId = 1;
ini_set('display_errors', 1);
$storeId   = Mage::app()->getStore();
ini_set('max_execution_time', 0);
if (function_exists('d') === false) {
    function d($data, $die=0, $z=1, $msg=1) {
        echo"<br/><pre style='padding:2px 5px;background: none repeat scroll 0 0 #E04E19;clear: both;color: #FFFFFF;float: left;font-family: Times New Roman;font-style: italic;font-weight: bold;text-align: left;'>";
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
}
$params  = $_REQUEST;
$indexer = "shell/indexer.php";
if(file_exists($indexer))
{
	$indexlist = array(
					"catalog_product_attribute",
					"catalog_product_price",
					"catalog_product_flat",
					"catalog_category_flat",
					"catalog_category_product",
					"catalog_url",
					"catalogsearch_fulltext",
					"cataloginventory_stock",
					// "mana_db_replicator",
					"tag_summary",
				 );
	if(isset($params['cpf'])){
		$indexlist = array("catalog_product_flat");
	}
	
	try{
		//reindex using magento command line
		foreach($indexlist as $idx)
		{
			$qry = "php /opt/bitnami/apps/magento/htdocs/shell/indexer.php --reindex $idx > /dev/null 2>/dev/null &";
			echo "</br>Reindex - $qry </br>";
			$result = exec($qry);
			var_dump($result);
		}
	} catch (Exception $e) {
		d($e->getMessage());
	}
}
