<?php
$Services->Run('autoSystem');

$Versiculos = $autoSystem->create(
	array(
		'bd'				=> 'versiculos_' . $_SESSION['user']['Path'],
		'auto_increment'	=> 'id_versiculos',
		'Fields'	=> 
			array(
			
				'livro'		=>	array(
					'Label'		=>	'Livro',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'capitulo'	=>	array(
					'Label'		=>	'Capítulo',
					'Type'		=>	'int',
					'Lenght'	=>	2
				),

				'verso'	=>	array(
					'Label'		=>	'Verso',
					'Type'		=>	'int',
					'Lenght'	=>	2
				),

				'versiculo'	=>	array(
					'Label'		=>	'Versículo',
					'Type'		=>	'html',
				),

			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array( 'id_versiculos' )
		),
		'Form'	=> array(
			// 'Title'	=> array(
			// 	'New'	=> _('Teste novo'),
			// 	'Edit'	=> _('Teste edit'),
			// ),
			'Title'	=> 'Cadastro de Versículos',
			'Buttons'	=> array(
				'Save'	=> array(
					// 'Name'	=> _('Salvar demo'),
					'Class'	=>	'btn btn-primary'
				),
			),
		),
	)
);