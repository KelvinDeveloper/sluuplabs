	<div class="mdl-grid w80">

	<h2>
		<a href="#">Parceiros</a>
	</h2>

	<?php
	$Result = $Database->Fetch( 'parceiros_3', false,false, false, false, 4 );
	while( $Slide = $Result->fetch(PDO::FETCH_OBJ) ){
	?>

		<div class="card-image mdl-card mdl-shadow--2dp" style="background-image:url('<?=$Slide->image?>');cursor:default">
			<div class="mdl-card__title mdl-card--expand"></div>
			<div class="mdl-card__actions">
				<span class="card-image__filename"><?=$Slide->identificacao?></span>
			</div>
		</div>


	<?php } ?>

	</div>