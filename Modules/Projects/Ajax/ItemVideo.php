<div class="mdl-textfield mdl-js-textfield">
	<input class="mdl-textfield__input" type="text" id="Url" />
	<label class="mdl-textfield__label" for="Url">Url do Youtube ou Vimeo</label>
</div>

<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="display:none"></div>

<div id="itemVideo"></div>

<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored btn-save-modal" id="save-block">
  <i class="material-icons">add</i>
</button>

<div class="mdl-tooltip" for="save-block">Inserir ao projeto</div>

<script type="text/javascript">

	var Youtube = '<iframe width="560" height="315" src="https://www.youtube.com/embed/{{URL}}" frameborder="0" allowfullscreen></iframe>',
		Vimeo   = '<iframe src="https://player.vimeo.com/video/{{URL}}" width="500" height="250" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
		Backup;

	$('#Url').keyup(function(){

		$('#modal mdl-progress').show();

		var URL = $(this).val();

		if( URL == Backup ){
			return false;
		}
		
		if( URL.indexOf('youtube') > -1 ){
			URL = URL.split('?v=');
			URL = Youtube.replace( '{{URL}}', URL[1] );

			$('#itemVideo').html( URL );
		}

		else if( URL.indexOf('vimeo') > -1 ){

			URL = URL.split('vimeo.com/');
			URL = Vimeo.replace( '{{URL}}', URL[1] );

			$('#itemVideo').html( URL );
		} else {
			alert('Ops.. URL inválida');
		}

		$('#modal mdl-progress').hide();

		Backup = $(this).val();

		return false;
	});
</script>