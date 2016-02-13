<?php

$Services->Run('autoSystem');

$video = $autoSystem->create(
	array(
		'bd'				=> 'videos_' . $_SESSION['user']['Path'],
		'auto_increment'	=> 'id_video',
		'Fields'	=> 
			array(

				'url'		=>	array(
					'Label'	=>	'Url do vídeo (Youtube)',
					'Type'		=>	'varchar',
					'Placeholder'	=> 'Ex.: https://www.youtube.com/watch?v=xhR4B14AYHs',
					'Lenght'	=>	255
				),

				'title'	=> array(
					'Label'	=>	'Nome do Vídeo',
					'Type'	=>	'varchar',
					'Placeholder'	=>	'Nome do Vídeo',
					'Lenght'	=>	255
				),

				'img'	=> array(
					'Type'	 =>	'varchar',
					'Lenght' => 255
				),

				'descricao'	=>	array(
					'Label'		=>	'Descrição do Album',
					'Type'		=>	'html',
					// 'Width'		=>  '$(this).parents(\'.window\').width() + \'px\' '
				),

				'register'	=>	array(
					'Label'	=>	'Cadastrado',
					'Type'	=>	'datetime',
					'Hide'	=> 	true
				),

				'adduser'	=>	array(
					'Type'	=>	'int',
					'Hide'	=>	true
				),
			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array( 'id_video', 'coment', 'descricao', 'adduser', 'img' ),
		),
		'Form'	=> array(
			'Title'	=> 'Video',
			'Buttons'	=> array(
				'Save'	=> array(
					'Class'	=>	'btn btn-primary'
				),
			),
			'Log'	=> array(
				'Register'	=> true,
				'AddUser'	=> true,
			),
			'Scripts'	=> 	"

			$('#fldimg').parents('tr').hide();

				$('#fldurl').blur(function(){

					if( $(this).val() != '' ){

						$.ajax({

							type: 'POST',
							dataType: 'json',
							url: '/Videos/Ajax/getInfo',
							data: {
								url: $(this).val()
							},
							success: function(json){

								var video = json.items[0].snippet;

								if( $('#fldtitle').val() == '' ){

									$('#fldtitle').val( video.title );
								}

								$('#fldimg').val( video.thumbnails.medium.url );

								if( tinymce.get('flddescricao').getContent() == '' ){

									tinymce.get('flddescricao').setContent( video.description );
								}
							}
						});
					}
				});
			",
		),
	)
);