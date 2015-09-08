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
</script>