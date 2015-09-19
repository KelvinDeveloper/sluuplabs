<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Url[4];

if( isset( $_GET['Block'] ) ){
	parse_ini_file( $Location . '/Grids/' . $_GET['Block'] . 'Config.pjc' );
}

?>

<div class="mdl-layout mdl-js-layout itens-pjc">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <span class="mdl-layout-title"></span>
      <div class="mdl-layout-spacer"></div>
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
    <div class="page-content"></div>
  </main>
</div>

<div class="item-content"></div>

<script type="text/javascript">

<?php if( isset( $Url[5] ) ){ 

$Url[6] = ucfirst( $Url[6] );

?>

var Type = '',
	This = $('#p-pages li.active').data('info');

switch( '<?=$Url[6]?>' ){
	case 'TEXT':
		Type = 'Texto';
		break;

	default:
		Type = '<?=$Url[6]?>';
}

$('#modal .page-content').load( '/Projects/Ajax/Item' + Type + '/' + $('.pMenuRigth').data('pjc') + '/' + This.Url.replace('/', '') + '/<?=$Url[5]?>/' );

<?php } else { ?>

$(document).ready(function(){
	setTimeout(function(){
		$('#modal .mdl-layout__drawer-button').click();
	}, 100);
});

<?php } ?>

$('#modal .itens-pjc .mdl-navigation a').click(function(){

	$('.itens-pjc .mdl-navigation a').removeClass('active');
	$(this).addClass('active');

	$('#modal .page-content').load( '/Projects/Ajax/Item' + $(this).attr('href') );
	$('#modal .mdl-layout__drawer-button').click();

	$('#modal .mdl-layout-title').html( $(this).html() );

	return false;
});


</script>