<?php
//Registration test.
// $Service->Prote()->Objects()->Auth()->register('zeeshanm1010@gmail.com','habba12345');
$Service->DBlue()->cd('ProtePeople');

$lss=$Service->DBlue()->ls();

foreach($lss as $ls){
	var_dump($ls);
	echo "<br><br>";
}



 ?>
