<h1>Grupo de trabalho</h1>

<b>Tem certeza que deseja alterar o grupo de trabalho?</b> <br>
Atenção, documentos não salvos serão perdidos!

<button class="mdl-button mdl-js-button mdl-button--raised close"><i class="material-icons fL">close</i> Cancelar</button>
<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored fR alterGroup"><i class="material-icons fL">compare_arrows</i> Alterar Grupo</button>

<script type="text/javascript">
	$('.alterGroup').click(function(){
		window.location = '/AlterGroup/<?=$Url['4']?>'; 
	});
</script>