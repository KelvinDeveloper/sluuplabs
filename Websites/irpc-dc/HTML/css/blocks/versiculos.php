	<div class="mdl-grid w80">

	<h2>
		<a href="#">Vercículos</a>
	</h2>

	<?php
	$Result = $Database->Fetch( 'versiculos_4', false,false, 'RAND()', false, 1 );
	while( $Slide = $Result->fetch(PDO::FETCH_OBJ) ){
	?>

	<div class="versiculos">
		<h4><i><?=$Slide->versiculo;?></i></h4> <br>
		<span class="fR"><b><?=$Slide->livro?></b> <?=$Slide->capitulo?>:<?=$Slide->verso?></span>
	</div>

	<?php } ?>

	</div>