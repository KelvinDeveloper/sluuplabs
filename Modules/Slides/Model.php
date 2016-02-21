<?php
$Services->Run('autoSystem');

$Slides = $autoSystem->create(
	array(
		'bd'				=> 'slides_' . $_SESSION['user']['Path'],
		'auto_increment'	=> 'id_slide',
		'Fields'	=> 
			array(
			
				'image'	=> array(
					'Label'	=> 'Imagem',
					'Type'	=> 'file',
					'Options'	=> array(
						'Types'	=> 'IMAGE'
					),
				),

				'title'		=>	array(
					'Label'		=>	'Título',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'link'		=>	array(
					'Label'		=>	'Link',
					'Type'		=>	'varchar',
					'Lenght'	=>	255
				),

				'target'		=>	array(
					'Label'		=>	'Abrir link',
					'Type'		=>	'select',
					'Options'	=>	array(
						1	=>	'Na mesma página',
						2	=>	'Em outra página'
					)
				),

			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array( 'id_slide' )
		),
		'Form'	=> array(
			// 'Title'	=> array(
			// 	'New'	=> _('Teste novo'),
			// 	'Edit'	=> _('Teste edit'),
			// ),
			'Title'	=> 'Slideshow',
			'Buttons'	=> array(
				'Save'	=> array(
					// 'Name'	=> _('Salvar demo'),
					'Class'	=>	'btn btn-primary'
				),
			),
		),
	)
);