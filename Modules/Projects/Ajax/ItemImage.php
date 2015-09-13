<div id="pNavImage"></div>

<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored btn-save-modal" id="save-block">
  <i class="material-icons">add</i>
</button>

<div class="mdl-tooltip" for="save-block">Inserir ao projeto</div>

<script type="text/javascript">
$('#pNavImage').load('/Explorer?navPrev=true&type=IMAGE');

$('#save-block').click(function(){

	if( $('#explorerContent .rCliked').length > 0 ){

		var This = $('#explorerContent .rCliked').data('info');

		if( This.Type != 'FOLDER' ){

			
			return false;
		}
	}

	alert('Selecione uma imagem');
});
</script>