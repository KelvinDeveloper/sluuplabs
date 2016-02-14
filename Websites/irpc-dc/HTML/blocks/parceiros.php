	<div class="mdl-grid w80">

	<h2>
		<a href="#">Parceiros</a>
	</h2>

	<?php
	$Result = $Database->Fetch( 'parceiros_4', false,false, false, false, 4 );
	while( $Slide = $Result->fetch(PDO::FETCH_OBJ) ){
	?>

		<a class="card-image mdl-card mdl-shadow--2dp" style="background-image:url('<?=$Slide->image?>');cursor:default" href="<?php echo $Slide->link?>" target="_blank">
			<div class="mdl-card__title mdl-card--expand"></div>
			<div class="mdl-card__actions">
				<span class="card-image__filename"><?=$Slide->identificacao?></span>
			</div>
		</a>

	<?php } ?>

	</div>