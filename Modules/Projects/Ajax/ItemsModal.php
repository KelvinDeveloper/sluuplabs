<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Url[4];

if( isset( $_GET['Block'] ) ){
	parse_ini_file( $Location . '/Grids/' . $_GET['Block'] . 'Config.pjc' );
}

?>

<div class="mdl-layout mdl-js-layout itens-pjc">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title"></span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation -->
      <nav class="mdl-navigation">

      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <nav class="mdl-navigation">
			<a class="mdl-navigation__link mR" href="Texto">
				<i class="material-icons mR">&#xE165;</i> Texto
			</a>

			<a class="mdl-navigation__link" href="Image"><i class="material-icons mR">&#xE3B6;</i> Imagem</a>

			<a class="mdl-navigation__link" href="Video"><i class="material-icons mR">&#xE404;</i> Video</a>
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content"><!-- Your content goes here --></div>
  </main>
</div>

<div class="item-content"></div>

<script type="text/javascript">
$('.itens-pjc a').click(function(){

	$('.itens-pjc a').removeClass('active');
	$(this).addClass('active');

	$('.page-content').load( '/Projects/Ajax/Item' + $(this).attr('href') );
	$('.mdl-layout__drawer-button').click();

	$('.mdl-layout-title').html( $(this).html() );

	return false;
});

$(document).ready(function(){
	setTimeout(function(){
		$('.mdl-layout__drawer-button').click();
	}, 100);
});
</script>