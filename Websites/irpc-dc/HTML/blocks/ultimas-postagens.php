
	<div class="mdl-grid w80">

	<h2>
		<a href="#">Mais visitadas</a>
	</h2>

	<?php
	$Result = $Database->Fetch( 'blog_2', false, "publish='1'", 'visitas DESC', false, ( isset( $UltimasPostagens ) ? $UltimasPostagens : 4) );
	while( $Slide = $Result->fetch(PDO::FETCH_OBJ) ){
	?>


		<div class="card-image mdl-card mdl-shadow--2dp openFunction" style="background-image:url('<?=$Slide->image?>')" href="/post/<?php echo $Slide->id_blog . '-' . strtolower( $Function->RemoveAccents( str_replace( ' ', '-', $Slide->title ) ) ); ?>" title="<?=$Slide->title . ' | ' . Title;?>">
			<div class="mdl-card__title mdl-card--expand"></div>
			<div class="mdl-card__actions">
				<span class="card-image__filename"><?=$Slide->title?></span>
			</div>
		</div>


	<?php } ?>

	</div>