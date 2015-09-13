<?php

$File = false;

if( isset( $Url[4] ) ){

	$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Url[4] . '/Itens/' . $Url[5] . '/' . $Url[6];
	$File = parse_ini_file( $Location );
}

?>


<div id="pNavImage"></div>

<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored btn-save-modal" id="save-block">
  <i class="material-icons">add</i>
</button>

<div class="mdl-tooltip" for="save-block">Inserir ao projeto</div>

<script type="text/javascript">
$('#pNavImage').load('/Explorer?navPrev=true&type=IMAGE<?php echo ( $File ? '&Location=' . $File['Location'] : '' ) ?>');

$('#save-block').click(function(){

	if( $('#explorerContent .rCliked').length > 0 ){

		var This = $('#explorerContent .rCliked').data('info');

		if( This.Type != 'FOLDER' ){

		$.ajax({ 
	        type: "POST",
	        dataType: "json",
	        data: {
	            Obj:   JSON.stringify( This ),
	            Pjc:   $('.pMenuRigth').data('pjc'),
	            Page:  JSON.stringify( $('#p-pages .active').data('info') ),
	        },
	        cache: false,
	        url: '/Projects/Ajax/SaveItemImage',
	        success: function(Return){

	        	if( Return.Status == true ){
		    		LoadPage();
					$('#modal, .shadowModal').remove();
	        	}
	        }
	    });

		return false;
		}
	}

	alert('Selecione uma imagem');
});

</script>