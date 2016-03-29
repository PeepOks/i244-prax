<?php
    $tekst = "mingitekst123";
	
	echo "algne tekst: $tekst </br>";
	pooraTekst($tekst);
	
	function pooraTekst($sisendtekst){
		echo "pooratud tekst: ";
		for ($i=0; $i < strlen($sisendtekst); $i++) {
			echo $sisendtekst[strlen($sisendtekst)-1-$i];
		}
		echo "\n";
	}
?>