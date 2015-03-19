<?php
// Open the file
$filename ="robin123.txt";
$fp = @fopen($filename, 'r'); 

// Add each line to an array
if ($fp) {
   $array = explode("\n", fread($fp, filesize($filename)));
}
$i=0;
$j=0;
for($i=1;$i<=1;$i++)
{

	//echo  $array[$i];
	//echo '<br/>';
	$content = explode(" ", $array[$i]);
	//echo count($content);
	for($j=0;$j<count($content);$j++)
	{
		echo $content[$j];
		echo '<br/>';
	}
}
?>