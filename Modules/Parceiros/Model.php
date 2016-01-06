<?php
$Services->Run('autoSystem');

$Parceiros = $autoSystem->create(
	array(
		'bd'				=> 'parceiros_' . $_SESSION['user']['id_user'],
		'auto_increment'	=> 'id_parceiro',
		'Fields'	=> 
			array(
			
				'image'	=> array(
					'Label'	=> 'Logo',
					'Type'	=> 'file',
					'Options'	=> array(
						'Types'	=> 'IMAGE'
					),
				),

				'identificacao'		=>	array(
					'Label'		=>	'Identificação',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'cpf'	=>	array(
					'Label'		=>	'CPF/CNPJ',
					'Type'		=>	'cpf',
					'Placeholder'	=> 'CPF/CNPJ',
					'Lenght'	=>	100
				),

				'telefone'	=>	array(
					'Label'		=>	'Telefone',
					'Type'		=>	'phone',
					'Lenght'	=>	25
				),

				'link'	=>	array(
					'Label'		=>	'URL',
					'Type'		=>	'varchar',
					'Placeholder'	=> 'URL',
					'Lenght'	=>	100
				),

				'valor'	=>	array(
					'Type'		=>	'money',
					'Lenght'	=>	10
				),

				'vencimento'	=> array(
					'Label'	=> 'Vencimento dia',
					'Type'	=> 'varchar',
					'Lenght'	=>	2
				)
			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array( 'id_parceiro' )
		),
		'Form'	=> array(
			// 'Title'	=> array(
			// 	'New'	=> _('Teste novo'),
			// 	'Edit'	=> _('Teste edit'),
			// ),
			'Title'	=> 'Parceiros',
			'Buttons'	=> array(
				'Save'	=> array(
					// 'Name'	=> _('Salvar demo'),
					'Class'	=>	'btn btn-primary'
				),
			),
		),
	)
);