<?php
/*
	Arquivo que chama as classes responsáveis para montar o projeto
*/

$Services->Run('Projects');
echo $Projects->Start( $_POST['Pjc'], $_POST['File'] );