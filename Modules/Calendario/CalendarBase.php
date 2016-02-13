<?php

$Month = array(
	1	=>	'Janeiro',
	2	=>	'Fevereiro',
	3	=>	'Março',
	4	=>	'Abril',
	5	=>	'Maio',
	6	=>	'Junho',
	7	=>	'Julho',
	8	=>	'Agosto',
	9	=>	'Setembro',
	10	=>	'Outubro',
	11	=>	'Novembro',
	12	=>	'Dezembro'
);

$Week = array(
	0	=>	'Domingo',
	1	=>	'Segunda-Feira',
	2	=>	'Terça-Feira',
	3	=>	'Quarta-Feira',
	4	=>	'Quinta-Feira',
	5	=>	'Sexta-Feira',
	6	=>	'Sabado',
);

$Services->Run('autoSystem');

if( isset( $_GET['date'] ) ){
	$_SESSION['CalendarDate'] = $_GET['date'];
} else {
	$_GET['date'] = $_SESSION['CalendarDate'];
}

$ModuleCalendar = $autoSystem->create(
	array(
		'bd'				=> 'calendar_' . $_SESSION['user']['Path'],
		'auto_increment'	=> 'id_calendar',
		'Where'				=> " WHERE date = '" . $_GET['date'] . "'",
		'Fields'	=> 
			array(
			
				'title'		=>	array(
					'Label'		=>	'Título',
					'Placeholder'		=>	'Título',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'image'		=> array(
					'Label'		=> 'Imagem de capa',
					'Type'		=> 'file',
					'Options'	=> array(
						'Types'	=> 'IMAGE'
					),
				),

				'content'	=>	array(
					'Label'		=>	'Conteúdo da postagem',
					'Type'		=>	'html',
					'Width'		=>  '$(this).parents(\'.window\').width() + \'px\' '
				),

				'type'	=>	array(
					'Label'		=>	'Tipo',
					'Placeholder'		=>	'Tipo',
					'Type'		=>	'select',
					'Options'	=>	array(
						1	=>	'Evento',
						2	=>	'Lembrete'
					)
				),

				'endereco'	=>	array(
					'Label'		=>	'Endereço',
					'Placeholder'		=>	'Endereço',
					'Type'		=>	'textarea',
				),

				'hour_ini'	=>	array(
					'Label'		=>	'Inicia as',
					'Placeholder'		=>	'Inicia as',
					'Type'		=>	'simpleHour',
					'Lenght'	=>	5
				),

				'hour_end'	=>	array(
					'Label'		=>	'Termina as',
					'Placeholder'		=>	'Termina as',
					'Type'		=>	'simpleHour',
					'Lenght'	=>	5
				),

				'coment'	=> array(
					'Label'	=> 'Habilitar Comentários',
					'Type'	=> 'select',
					'Options'	=> array(
						1	=> 'Sim',
						2	=> 'Não'
					),
				),

				'date'		=>	array(
					'Type'		=>	'varchar',
					'Lenght'	=>	10,
					'Value'		=>	( isset( $_GET['date'] ) ? $_GET['date'] : '' ) . 'teste'
				),
			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=>	array('id_calendar', 'date', 'content')
		),
		'Form'	=> array(
			// 'Title'	=> array(
			// 	'New'	=> _('Teste novo'),
			// 	'Edit'	=> _('Teste edit'),
			// ),
			// 'Title'	=> 'Adicionar compromisso',
			'Buttons'	=> array(
				'Save'	=> array(
					// 'Name'	=> _('Salvar demo'),
					'Class'	=>	'btn btn-primary'
				),
			),
		),
	)
);