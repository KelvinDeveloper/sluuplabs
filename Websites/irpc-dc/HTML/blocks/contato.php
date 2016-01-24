<form target="exec" method="post" action="/enviar-email/<?=$action?>">
	<input placeholder="* Nome" name="nome">
	<input placeholder="* Email" name="email"> <br>

	<textarea placeholder="* <?php echo ( isset( $msg ) ? $msg : 'Mensagem' ) ?>" name="mensagem"></textarea><br><br>

	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored fR mR" type="submit">Enviar <i class="material-icons fR">done</i></button> <br><br>

</form>