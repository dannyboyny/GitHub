<?php

function getProbabilidadConditional($A, $B, $Data){
	$NumAB = 0;
	$NumB = 0;
	$Num = 0;
	$NumData = count($Data);

	for ($i=0; $i < $NumData; $i++) { 
		if (in_array($B, $Data[$i])) {
			$NumB++;
			if (in_array($A, $Data[$i])) {
				$NumAB++;
			}
		}		
	}

	if ($NumB != 0) {
		$Num = $NumAB / $NumB;
	}

	return $Num;
}

?>