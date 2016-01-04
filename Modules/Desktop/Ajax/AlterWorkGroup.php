<h1>Grupo de trabalho</h1>

<b>Tem certeza que deseja alterar o grupo de trabalho?</b> <br>
Atenção, documentos não salvos serão perdidos! <br><br><br><br>

<div style="position:absolute;bottom:1px;width:100%;">
	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored fR alterGroup mL"><i class="material-icons fL">compare_arrows</i> Alterar Grupo</button> 
	<button class="mdl-button mdl-js-button mdl-button--raised close fR"><i class="material-icons fL mR">close</i> Cancelar</button>
</div>
<script type="text/javascript">
	$('.alterGroup').click(function(){
		window.location = '/AlterGroup/<?=$Url['4']?>'; 
	});
</script>