<?php
$Services->Run('autoSystem');

$demo = $autoSystem->create(
	array(
		'bd'				=> 'demo',
		'auto_increment'	=> 'id_demo',
		'Fields'	=> 
			array(
			
				'campo'		=>	array(
					'Label'		=>	'Label Campo',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'campo2'	=>	array(
					'Label'		=>	'Label Campo 2',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'campo3'	=>	array(
					'Label'		=>	'Label Campo 3',
					'Type'		=>	'varchar',
					'Lenght'	=>	50
				),

				'campo4'	=>	array(
					'Label'		=>	'Label Campo 4',
					'Type'		=>	'varchar',
					'Lenght'	=>	10
				),

				'campo5'	=>	array(
					'Label'		=>	'Label Campo 5',
					'Type'		=>	'varchar',
					'Lenght'	=>	255
				),
			),
		'Grid'	=> array(
			'Width'		=> '100%',
		),
		'Form'	=> array(
			// 'Title'	=> array(
			// 	'New'	=> _('Teste novo'),
			// 	'Edit'	=> _('Teste edit'),
			// ),
			'Title'	=> 'Teste',
			'Buttons'	=> array(
				'Save'	=> array(
					// 'Name'	=> _('Salvar demo'),
					'Class'	=>	'btn btn-primary'
				),
			),
		),
	)
);