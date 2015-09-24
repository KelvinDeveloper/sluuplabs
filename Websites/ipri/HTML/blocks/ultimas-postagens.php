
	<div class="mdl-grid w80">

	<h2>
		<a href="#">Últimas postagens</a>
	</h2>

	<?php
	$Result = $Database->Fetch( 'blog', false, "publish='1'", 'id_blog DESC', false, 4 );
	while( $Slide = $Result->fetch(PDO::FETCH_OBJ) ){
	?>


		<div class="card-image mdl-card mdl-shadow--2dp openFunction" style="background-image:url('<?=$Slide->image?>')" href="/post/<?php echo $Slide->id_blog . '-' . strtolower( $Function->RemoveAccents( str_replace( ' ', '-', $Slide->title ) ) ); ?>" title="<?=$Slide->title?>">
			<div class="mdl-card__title mdl-card--expand"></div>
			<div class="mdl-card__actions">
				<span class="card-image__filename"><?=$Slide->title?></span>
			</div>
		</div>


	<?php } ?>

	</div>