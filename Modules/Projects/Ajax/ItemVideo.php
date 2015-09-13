<?php

$File = false;
$Link = false;

if( isset( $Url[4] ) ){

	$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Url[4] . '/Itens/' . $Url[5] . '/' . $Url[6];
	$File = parse_ini_file( $Location );
}

$Link = explode( 'src="', $File['Value'] );
$Link = explode( '"', $Link[1] );
$Link = $Link[0];
?>


<div class="mdl-textfield mdl-js-textfield">
	<input class="mdl-textfield__input" type="text" id="Url" value="<?php echo $Link; ?>" />
	<label class="mdl-textfield__label" for="Url">Url do Youtube ou Vimeo</label>
</div>

<div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate" style="display:none"></div>

<div id="itemVideo"></div>

<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored btn-save-modal" id="save-block">
  <i class="material-icons">add</i>
</button>

<div class="mdl-tooltip" for="save-block">Inserir ao projeto</div>

<script type="text/javascript">

	var Youtube = '<iframe width="560" height="315" src="https://www.youtube.com/embed/{{URL}}" frameborder="0" allowfullscreen></iframe>',
		Vimeo   = '<iframe src="https://player.vimeo.com/video/{{URL}}" width="500" height="250" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
		Backup;

	function getVideo( URL ){

		if( URL.indexOf('youtube') > -1 ){
			URL = URL.split('?v=');
			URL = Youtube.replace( '{{URL}}', URL[1] );

			$('#itemVideo').html( URL );
		}

		else if( URL.indexOf('vimeo') > -1 ){

			URL = URL.split('vimeo.com/');
			URL = Vimeo.replace( '{{URL}}', URL[1] );

		} else {
			alert('Ops.. URL inválida');
			return false;
		}

		return URL;
	}

	$('#Url').keyup(function(){

		$('#modal mdl-progress').show();

		var URL = $(this).val();

		// if( URL == Backup ){
		// 	return false;
		// }
		
		$('#itemVideo').html( getVideo( URL ) );

		$('#modal mdl-progress').hide();

		Backup = $(this).val();

		return false;
	});

	$('#save-block').click(function(){

		$.ajax({ 
	        type: "POST",
	        dataType: "json",
	        data: {
	            Value: "'" + getVideo( $('#Url').val() ) + "'",
	            Pjc:   $('.pMenuRigth').data('pjc'),
	            Page:  JSON.stringify( $('#p-pages .active').data('info') ),
	        },
	        cache: false,
	        url: '/Projects/Ajax/SaveItemVideo',
	        success: function(Return){

	        	if( Return.Status == true ){
		    		LoadPage();
					$('#modal, .shadowModal').remove();
	        	}
	        }
	    });
	});

<?php if( $File ){ ?>

$(document).ready(function(){

	$('#itemVideo').html( '<?php echo $File['Value']; ?>' );
});
<?php } ?>

</script>