<?php

$Services->Run('autoSystem');

$assuntos = $autoSystem->create(
	array(

		'bd'				=>	'assuntos_' . $_SESSION['user']['Path'],
		'auto_increment'	=>	'id_assunto',

		'Fields'	=> array(

			'name'	=> array(
				'Type'		=> 'varchar',
				'Label'		=> 'Assunto',
				'Lenght'	=> 100,
			),
		),

		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array('id_assunto')
		),

		'Form'	=>	array(
			'Title'	=>	'Assuntos'
		),

	)

);