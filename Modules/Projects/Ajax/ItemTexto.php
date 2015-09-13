<?php

$File = false;

if( isset( $Url[4] ) ){

	$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Url[4] . '/Itens/' . $Url[5] . '/' . $Url[6];
	$File = parse_ini_file( $Location );
}

?>

<textarea id="itemContent" class="tinymce"></textarea>

<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored btn-save-modal" id="save-block">
  <i class="material-icons">add</i>
</button>

<div class="mdl-tooltip" for="save-block">Inserir ao projeto</div>

<script type="text/javascript">
	editorHTML({
		Element: 'itemContent',
		Height: ( $('#modal').height() - 165 ) + 'px',
		Width:  ( $('#modal').width()  - 7 )
	});

$('#save-block').click(function(){

	$.ajax({ 
        type: "POST",
        dataType: "json",
        data: {
            Value:   tinymce.get('itemContent').getContent(),
            Pjc:   $('.pMenuRigth').data('pjc'),
            Page:  JSON.stringify( $('#p-pages .active').data('info') ),
        },
        cache: false,
        url: '/Projects/Ajax/SaveItemTexto',
        success: function(Return){

        	if( Return.Status == true ){
	    		LoadPage();
				$('#modal, .shadowModal').remove();
        	}
        }
    });
});

<?php if( $File ){ ?>
	tinyMCE.get('itemContent').setContent('<?php echo $File['Value'] ?>');
<?php } ?>

</script>