<ul class="menu-themes">
	<li>Temas</li>
	<li><a href="/page" class="<?php echo ( ! isset( $Url[2] ) ? 'active' : '' ); ?> openFunction">Todos</a></li>
	<?php 
	$Result = $Database->Fetch( 'assuntos_4', false, false , 'name ASC' );
	while( $Theme = $Result->fetch(PDO::FETCH_OBJ) ){
		echo '<li><a class="' . ( isset( $Url[2] ) && $Url[2] == $Theme->id_assunto ? 'active' : '' ) . ' openFunction" href="/page/' . $Theme->id_assunto . '">' . $Theme->name . '</a></li>';
	}
	?>
</ul>