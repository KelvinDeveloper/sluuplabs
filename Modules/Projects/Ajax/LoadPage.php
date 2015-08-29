<?php
/*
	Arquivo que chama as classes responsáveis para montar o projeto
*/

$Services->Run('Projects');
echo $Projects->LoadHeader( $_POST['Pjc'], $_POST['File'] );