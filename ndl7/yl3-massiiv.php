<?php
    $kassid= array( 
		array('nimi'=>'Miisu', 'vanus'=>2, 'sugu'=>'emane', 'varvus'=>'triibuline', 'pilt'=>'http://3.bp.blogspot.com/-osIKpccJdU8/U2tyY4ohiQI/AAAAAAAAAXg/ki9D6vwMVWQ/s1600/kass.jpg'), 
		array('nimi'=>'Tom', 'vanus'=>1, 'sugu'=>'isane', 'varvus'=>'must', 'pilt'=>'http://viljandi.varjupaik.ee/albums/kassid_kodus/07_06_24kassid_005.jpg'),
		array('nimi'=>'Nurr', 'vanus'=>3, 'sugu'=>'emane', 'varvus'=>'kollane', 'pilt'=>'http://www.teadus.ee/wp-content/uploads/kassikeel.jpg')
	);
	
	foreach ($kassid as $kass) {
		include "template.php";
	}
?>