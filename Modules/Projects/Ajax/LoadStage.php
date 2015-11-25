<?php
$j = $_REQUEST['json'];

?>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title">Title</span>
      <div class="mdl-layout-spacer"></div>
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <a class="mdl-navigation__link openModal" href="/Projects/Ajax/ItemsModal/<?=$j['Config']['nome_projeto'];?>" title="<i class='material-icons fL mR'>&#xE02E;</i> Adicionando item" data-parent="#ModuleProjects" data-size="large">Adicionar Item</a>
        <!--a class="mdl-navigation__link" href="">Link</a>
        <a class="mdl-navigation__link" href="">Link</a>
        <a class="mdl-navigation__link" href="">Link</a-->
      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer pMenuRigth" data-pjc="<?php echo $j['Config']['nome_projeto']; ?>">
    <nav class="mdl-navigation">

	<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" style="width:100%" id="newPage">
		<i class="material-icons fL">add</i>
		Criar Página
	</button>

    <ul id="p-pages" class="menuSelect">

	    <?php
		$loop = 0;
		foreach ( $j['Pages'] as $k => $v ){ ?>
			<li data-info='<?php echo json_encode( $v ) ?>' <?php echo ( $loop === 0 ? 'class="active"' : "" ); ?> id="<?=$k?>" data-title="<?=$v['Title']?>">
				<div class="view">
					<i class="material-icons fL">&#xE5CC;</i> <?=$v['Title']?> 
					<?php if( $j['Config']['Index'] === $k ){ ?>
					<i class="material-icons" id="s-home">&#xE88A;</i>
						<div class="mdl-tooltip" for="s-home">Página inicial</div>
					<?php } ?>						
				</div>

				<div class="edit" style="display:none;">
					<input value="<?=$v['Title']?>">
				</div>

			</li>
		<?php $loop++; } ?>
		</ul>
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content" id="stage"></div>
  </main>
</div>

<script type="text/javascript">

/* Functions */

function rename( This ){
	This.find('.edit').show();
	This.find('.view').hide();
}

$(document).ready(function(){

	$('#p-pages').height( $(window).height() / 1.4 );
	$('#p-pages li:first').click();
});

/* Nova página */
$('#newPage').click(function(){

	var NewPage 	= 'Nova Página',
		LoopName	= true,
		Loop 		= 0;

	while( LoopName ){
		if( $('#p-pages li[data-title="' + NewPage + ( Loop === 0 ? '' : '-' + Loop ) + '"]').length > 0 ){
			Loop++;
		} else {
			NewPage 	= NewPage + ( Loop === 0 ? '' : '-' + Loop );
			LoopName 	= false;
		}
	}

	$.ajax({ 
		type: "POST",
		dataType: "json",
		cache: false,
		data: {
			Page: NewPage,
			Pjc : '<?php echo $j['Config']['nome_projeto']; ?>'
		},
		url: '/Projects/Ajax/CreatePage', 
		success: function(Page){ 

			var rJSON = JSON.stringify( Page );

			console.log( rJSON );

			if( Page.Status == true ){

				$('#p-pages li.active').removeClass('active');

				$('#p-pages').prepend('<li data-info=\'' + rJSON + '\' class="active" id="' + Page.File + '" data-title="' + Page.Title + '">' +
					'<div class="view" style="display:none">' +
						'<i class="material-icons fL">&#xE5CC;</i> ' + Page.Title +
					'</div>' +
					'<div class="edit">' +
						'<input value="' + Page.Title + '">' +
					'</div>' +
				'</li>');

				$('#p-pages input:first').focus();
			}
		}
	});
});

/* ends nova página */

/* Ordenação de páginas */

$('#p-pages').sortable({
	items: "li",
	stop: function( event, ui ) {
		
		var Sequence = '',
			Loop     = 1;

		$('#p-pages li').each(function(){
			if( $(this).attr('id') != undefined ){
				Sequence += $(this).attr('id') + ':' + Loop + ';';
				Loop++;
			}
		});

		$.ajax({ 
	    	type: "POST",
	    	dataType: "json",
	    	cache: false,
	    	data: {
	    		Pjc : '<?php echo $j['Config']['nome_projeto']; ?>',
	    		Sequence: Sequence
	    	},
	    	url: '/Projects/Ajax/SaveSequence', 
	    	success: function(Data){ 
	    		$.each( Data, function(k, v){
	    			$('#' + k.replace('.', '\\.') ).attr('id', v);
	    		});
	    	}
	    });

	}
});	
/* Ends ordenação de páginas */


/* rClick */

$('#p-pages li').rClick({

	id: 's-page-rClick',

	Menu: {

		rename: {

			icon: '<i class="material-icons">&#xE150;</i>',
			text: 'Renomear',
			exec: function(This){
				rename( This );
			}

		},

		delete: {
			icon: '<i class="material-icons">&#xE872;</i>',
			text: 'Excluir página',
			exec: function(This){
				
				var isDelete 	= confirm("Tem certeza que deseja deletar esta página?");

				if( isDelete == true ){
					$.ajax({ 
				    	type: "POST",
				    	dataType: "json",
				    	cache: false,
				    	data: {
				    		Page: This.attr('id'),
				    		Pjc : '<?php echo $j['Config']['nome_projeto']; ?>'
				    	},
				    	url: '/Projects/Ajax/DeletePage', 
				    	success: function(Page){ 
				    		if( Page.Status === true ){
				    			This.remove();
				    		}
				    	}
				    });
				}
			}
		},
	}
});

/* Ends rClick */

</script>