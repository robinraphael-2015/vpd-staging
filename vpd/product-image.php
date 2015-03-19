<?php

require_once 'app/Mage.php';
Mage::app();
$page		 = (!isset($_GET['page']))?1:$_GET['page'];
$collection  = Mage::getModel('catalog/product')
                        ->getCollection()
                        ->addAttributeToSelect('*');
if($page){
	$collection->setPageSize(2)->setCurPage($page);
}						
$base_url = Mage::getBaseDir('media') . DS . 'catalog/category/';			
foreach ($collection as $product) {
	$catIds = $product->getCategoryIds(); 
	$catId  = $catIds['0'];
	$category = Mage::getModel('catalog/category')->load($catId); 
	$cat_img  = $category->getImage();
	if($cat_img){
		$new_image = $base_url.$cat_img;
		try {
			$product->addImageToMediaGallery($new_image,array('image','small_image','thumbnail'),false);
			$product->save();
			echo "Image Upadated Succesfully for ".$product->getSku()."<br/>";
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	else{
		
	}	
}
?>
<html>
	<title> Image update from category to Product</title>

	<script type="text/javascript" src="//code.jquery.com/jquery-1.7.2.min.js"></script>
	<script type="text/javascript">

		function getParameterByName(name) {
		    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
		    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
		}

		function autoRefresh()
		{	
			var value = window.getParameterByName("page");
			var current_url = window.location.hostname + window.location.pathname;
			if(value == null){
				window.location =  "?page=1";
			}
			else{
				var page_add = parseInt(value)+1;
				window.location =  "?page=" + page_add;
			}
		}

		jQuery(window).bind("load", function() {
		  //setInterval('autoRefresh()', 5000);
		});

	</script>
</html>