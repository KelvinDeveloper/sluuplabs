<?php
class autoSystem{
	function create( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url, $Router;

		// Autobd
		$this->autobd( $Array );

		// Grid
		if( !isset( $Url[2] ) || $Url[2] == 'Ajax' ){
			return $this->grid( $Array );
		}
		// Form
		else if( is_numeric( $Url[2] ) || $Url[2] == 'Novo' ){
			return $this->form( $Array );
		}
		else if(  $Url[2] == 'Salvar' ){

			$new = false;

			if( !is_numeric( $Url[3] ) ){
				$new = true;
			}

			$Module = $Router[ $Domain[0] ][ $Url[1] ];
			$Module = explode( '/', $Module );

			@include ROOT . '/Modules/' . $Module[1] . '/Validate.php';

			$Json = '';
			
			if( function_exists('onStart') ){
				onStart( $Array, $new, $PDO->lastInsertId() );
			}

			echo json_encode( $this->post( $Array ) );

			if( function_exists('onEnd') ){
				onEnd( $Array, $new, $PDO->lastInsertId() );
			}

			exit;
		}
		else if( $Url[2] == 'Deletar' ){
			if( $Database->Delete( $Array['bd'], $Array['auto_increment'] . '=' . $Url[3]  ) ){
				$Return['message'] = true;
				echo json_encode( $Return );
			}
			exit;
		}

	}

	function autobd( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;

		// Table existe
		$tableExist = $PDO->query( " SHOW TABLES LIKE '" . $Array['bd'] . "' " )->rowCount();
		if( $tableExist == 0 ){
			$PDO->exec( " CREATE TABLE `" . $Array['bd'] . "` (
  						`" . $Array['auto_increment'] . "` int(11) NOT NULL AUTO_INCREMENT,
  						PRIMARY KEY (`" . $Array['auto_increment'] . "`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 " );
		}

		// Coluns
		$Fields = $Database->Desc( $Array['bd'] );
		while ( $F = $Fields->fetch(PDO::FETCH_OBJ) ){
			$Field[ $F->Field ] = $F;
		}

		foreach ( $Array['Fields'] as $k => $v ){
			// Colum exist

			$Type = $this->field_type( $v );

			if( !isset( $Field[ $k ] ) ){

				$PDO->exec( " ALTER TABLE `" . BD . "`.`" . $Array['bd'] . "` 
				ADD COLUMN `" . $k . "` " . $Type . "  NULL " );
			}
			else if( $v['Type'] .'(' . $v['Lenght'] . ')' != $Field[ $k ]->Type ){

				$PDO->exec( " ALTER TABLE `" . BD . "`.`" . $Array['bd'] . "` 
							CHANGE COLUMN `" . $k . "` `" . $k . "` " . $Type . " NULL DEFAULT NULL " );

			}
		}
	}

	function field_type( $v ){
		switch ( $v['Type'] ){
			case 'text':
			case 'html':
				$Type = 'TEXT';
				break;
			case 'int':
				$Type = "INT(" . ( isset( $v['Lenght'] ) ? $v['Lenght']: 11 ) . ")";
				break;
			case 'date':
				$Type = 'DATE';
				break;
			case 'datetime':
				$Type = 'DATETIME';
			case 'file':
			case 'files':
				$Type = "VARCHAR(255)";
				break;
			default:
				$Type = "VARCHAR(" . ( isset( $v['Lenght'] ) ? $v['Lenght']: 45 ) . ")";
				break;
		}
		return $Type;
	}

	function grid( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;
		
		$HTML = '<br>';
		$Script = '';

		if( $Array['Grid']['Buttons'] || !isset( $Array['Grid']['Buttons'] ) ){
			if( $Array['Grid']['Buttons']['New'] !== false || !isset( $Array['Grid']['Buttons']['New'] ) ){
				if( !isset( $Array['Grid']['Buttons']['Label']['New'] ) ){

					$HTML .= '<a href="/' . $Url[1] . '/Novo" class="openThisWindow mdl-button mdl-js-button mdl-button--raised mdl-button--colored" for="' . $Url[1] . '">
								<i class="material-icons fL">add</i> Adicionar Registro
							</a>';

				} else {

					$HTML .= '<a href="/' . $Url[1] . '/Novo" class="openThisWindow mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-js-ripple-effect" for="' . $Url[1] . '">' . $Array['Grid']['Buttons']['Label']['New'] . ' <i class="material-icons fR">add</i></a> <br><br>';
				}
			}
		}

		$HTML .= '<br><br>';

		$HTML .= '<table ' . ( isset( $Array['Grid']['Width'] ) ? 'width="' . $Array['Grid']['Width'] . '"' : false ) . ' class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp tableDefault">';

			$HTML .= '<thead>';

				$HTML .= '<tr>';

				$SQLFields = $Database->Desc( $Array['bd'] );

				// $HTML .= '<td class="check"> 
				// 			<label for="CheckAll" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
				// 			  <input type="checkbox" id="CheckAll" class="mdl-checkbox__input" />
				// 			</label>

				// 		</td>';

				while ( $F = $SQLFields->fetch(PDO::FETCH_OBJ) ){
					if( !in_array( $F->Field, $Array['Grid']['Hide'] ) ){

						$HTML .= '<td>' . ( !empty( $Array['Fields'][ $F->Field ]['Label'] ) ? $Array['Fields'][ $F->Field ]['Label'] : ucfirst( $F->Field ) ) . '</td>';
						$Fields[ $F->Field ] = $F;
					}
				}

				$HTML .= '<td></td>';

				$HTML .= '</tr>';

			$HTML .= '</thead>';
			$HTML .= '<tbody>';
			
				$Result = $Database->Fetch( $Array['bd'] . ( isset( $Array['Where'] ) ? ' ' . $Array['Where'] : '' ), false, false, $Array['auto_increment'] . ' DESC' );
				while ( $Value = $Result->fetch(PDO::FETCH_OBJ) ){
					$HTML .= '<tr href="/' . $Url[1] . '/' . $Value->$Array['auto_increment'] . '" data-module="' . $Url[1] . '" data-id="' . $Value->$Array['auto_increment'] . '" for="' . $Url[1] . '">';
						
						// $HTML .= '<td class="check"> 
						// 			<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-' . $Value->$Array['auto_increment'] . '">
						// 			  <input type="checkbox" id="checkbox-' . $Value->$Array['auto_increment'] . '" class="mdl-checkbox__input" checked />
						// 			</label>
						// 		</td>';

					foreach ( $Fields as $Field => $Info ){

						$v = $Value->$Field;

						switch ( $Array['Fields'][ $Field ]['Type'] ){
							case 'select':
								if( isset( $Array['Fields'][ $Field ]['Query'] ) ){
									$R = $PDO->query( $Array['Fields'][ $Field ]['Query'] );
									while( $v = $R->fetch(PDO::FETCH_OBJ) ){
										$Array['Fields'][ $Field ]['Options'][ $v->$Array['Fields'][ $Field ]['Key'] ] = $v->$Array['Fields'][ $Field ]['Value'];
									}
								}

								$v = $Array['Fields'][ $Field ]['Options'][ $Value->$Field ];
								break;
							case 'file':
								if( $Array['Fields'][ $Field ]['Options']['Types'] == 'IMAGE' ){
									$v = '<div class="image" style="background-image:url(\'' . $v . '\')"></div>';
								}
								break;

							case 'files':

								if( $Array['Fields'][ $Field ]['Options']['Types'] == 'IMAGE' ){

									$Dir = scandir( ROOT . $v );
									$path = $v;
									$v = '<ul class="multi_files" data-value="' . $path . '">';
									$m = 5;
										foreach ( $Dir as $value ){
											if( $value != '.' && $value != '..' ){
												$v .= '<li style="background-image:url(\'' . $path . '/' . $value . '\');left:' . $m . 'px"></li>';
												$m = $m + 5;
											}
										}
									$v .= '</ul>';
								}
								break;
						}

						$HTML .= '<td>' . ( empty( $v ) ? '-' : $v ) . '</td>';
					}

					$HTML .= '
					<td>
						<button id="' . $Array['auto_increment'] . $Value->$Array['auto_increment'] . '-menu"
						        class="mdl-button mdl-js-button mdl-button--icon">
						  <i class="material-icons">more_vert</i>
						</button>

						<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
						    for="' . $Array['auto_increment'] . $Value->$Array['auto_increment'] . '-menu">
						  <li class="mdl-menu__item" onclick="editRegister( $(this).parents(\'tr\') )"><i class="material-icons">&#xE254;</i> ' . _('Editar') . '</li>
						  <li class="mdl-menu__item item_delete"><i class="material-icons">&#xE872;</i> ' . _('Excluir') . '</li>
						</ul>
					</td>';

					$HTML .= '</tr>';
				}

			$HTML .= '</tbody>';

		$HTML .= '</table>';

		return $HTML;

	}

	function form( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;

		$new = false;
		$Value = '';

		if( !is_numeric( $Url[2] ) ){
			$new = true;
		} else {
			// Traz os dados do modulo
			$Value = $Database->Search( $Array['bd'], false, $Array['auto_increment'] . "='" . $Url[2] . "'" );
		}

		$HTML = '<form action="/' . $Url[1] . '/Salvar/' . ( $new ? 'New' : $Url[2] ) . '" method="post" target="defaultForm">';

		// Título
		$HTML .= '<h1> <span>';
		
		if( isset( $Array['Form']['Title'] ) ){

			if( is_array( $Array['Form']['Title'] ) ){

				$HTML .= ( $new ? $Array['Form']['Title']['New'] : $Array['Form']['Title']['Edit'] );

			} else {
				$HTML .= $Array['Form']['Title'];
			}

		} else {

			$HTML .= ( $new ? _('Novo registro') : _('Editando registro') );

		}
		
		$HTML .= '</span></h1>';

		$HTML .= '<table>';

		foreach ( $Array['Fields'] as $Field => $Data ){

			if( !$Data['Hide'] ){

				$HTML .= '<tr><td valign="top">';

				$HTML .= '<label for="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '">' . ( isset( $Data['Label'] ) ? $Data['Label'] : ucfirst( $Field ) ) . ' </label>';

				$HTML .= '</td><td valign="top">';

				switch ( $Data['Type'] ) {
					
					case 'text':
						$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						break;

				case 'hidden':
						$HTML .= '<input type="hidden" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						break;

				case 'rand':
						$HTML .= '<input type="hidden" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . ( empty( $Value->$Field ) ? rand() : $Value->$Field ) . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						break;

				case 'password':
					if( $Data['Security'] === true && $Url[2] != 'Criar-Usuario' ){
						$HTML .= '<input type="password" maxlength="' . $Data['Lenght'] . '" placeholder="Senha Atual" name="Atual' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fldAtual' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '"><br>';
					}
					$HTML .= '<input type="password" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
					if( $Data['Security'] === true ){
						$HTML .= '<br><input type="password" maxlength="' . $Data['Lenght'] . '" placeholder="Repetir ' . ( $Url[2] != 'Criar-Usuario' ? 'Nova Senha' : 'Senha' ) . '" name="ReNova' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fldReNova' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '"><br>';
					}
					break;

				case 'textarea':
					$HTML .= '<textarea maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">' . $Value->$Field . '</textarea>';
					break;

				case 'html':
					$HTML 	.= '<textarea id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .' tinymce" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '"></textarea>';
					$Script .= '
					editorHTML({Element: \'' . 'fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '\', Width: ' . ( isset( $Data['Width'] ) ? $Data['Width'] : '\'100%\'' ) . '});
					setTimeout(function(){ tinyMCE.get(\'' . 'fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) .  '\').setContent(\'' . preg_replace( '/\s/',' ',$Value->$Field ) . '\') }, 500);';
					break;

				case 'select':
					$HTML .= '<select name="' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : '' ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';

					if( isset( $Data['Query'] ) ){
						$Result = $PDO->query( $Data['Query'] );
						while( $v = $Result->fetch(PDO::FETCH_OBJ) ){
							$Data['Options'][ $v->$Data['Key'] ] = $v->$Data['Value'];
						}
					}
					$HTML .= '<option>Selecione</option>';
					foreach ( $Data['Options'] as $k => $v ) {
						$HTML .= '<option value="' . $k . '" ' . ( $k == $Value->$Field ? 'selected="selected"' : '' ) . '>' . $v . '</option>';

					}

					if( $thisForm['Fields'][ $Field ]['Stats'] === 'BR' ){
						$HTML .= '
								<option value="">Selecionar Estado</option>
								<option value="ac" ' . ( 'ac' == $Value->$Field ? 'selected="selected"' : false ) . '>Acre</option> 
								<option value="al" ' . ( 'al' == $Value->$Field ? 'selected="selected"' : false ) . '>Alagoas</option> 
								<option value="am" ' . ( 'am' == $Value->$Field ? 'selected="selected"' : false ) . '>Amazonas</option> 
								<option value="ap" ' . ( 'ap' == $Value->$Field ? 'selected="selected"' : false ) . '>Amapá</option> 
								<option value="ba" ' . ( 'ba' == $Value->$Field ? 'selected="selected"' : false ) . '>Bahia</option> 
								<option value="ce" ' . ( 'ce' == $Value->$Field ? 'selected="selected"' : false ) . '>Ceará</option> 
								<option value="df" ' . ( 'df' == $Value->$Field ? 'selected="selected"' : false ) . '>Distrito Federal</option> 
								<option value="es" ' . ( 'es' == $Value->$Field ? 'selected="selected"' : false ) . '>Espírito Santo</option> 
								<option value="go" ' . ( 'go' == $Value->$Field ? 'selected="selected"' : false ) . '>Goiás</option> 
								<option value="ma" ' . ( 'ma' == $Value->$Field ? 'selected="selected"' : false ) . '>Maranhão</option> 
								<option value="mt" ' . ( 'mt' == $Value->$Field ? 'selected="selected"' : false ) . '>Mato Grosso</option> 
								<option value="ms" ' . ( 'ms' == $Value->$Field ? 'selected="selected"' : false ) . '>Mato Grosso do Sul</option> 
								<option value="mg" ' . ( 'mg' == $Value->$Field ? 'selected="selected"' : false ) . '>Minas Gerais</option> 
								<option value="pa" ' . ( 'pa' == $Value->$Field ? 'selected="selected"' : false ) . '>Pará</option> 
								<option value="pb" ' . ( 'pb' == $Value->$Field ? 'selected="selected"' : false ) . '>Paraíba</option> 
								<option value="pr" ' . ( 'pr' == $Value->$Field ? 'selected="selected"' : false ) . '>Paraná</option> 
								<option value="pe" ' . ( 'pe' == $Value->$Field ? 'selected="selected"' : false ) . '>Pernambuco</option> 
								<option value="pi" ' . ( 'pi' == $Value->$Field ? 'selected="selected"' : false ) . '>Piauí</option> 
								<option value="rj" ' . ( 'rj' == $Value->$Field ? 'selected="selected"' : false ) . '>Rio de Janeiro</option> 
								<option value="rn" ' . ( 'rn' == $Value->$Field ? 'selected="selected"' : false ) . '>Rio Grande do Norte</option> 
								<option value="ro" ' . ( 'ro' == $Value->$Field ? 'selected="selected"' : false ) . '>Rondônia</option> 
								<option value="rs" ' . ( 'rs' == $Value->$Field ? 'selected="selected"' : false ) . '>Rio Grande do Sul</option> 
								<option value="rr" ' . ( 'rr' == $Value->$Field ? 'selected="selected"' : false ) . '>Roraima</option> 
								<option value="sc" ' . ( 'sc' == $Value->$Field ? 'selected="selected"' : false ) . '>Santa Catarina</option> 
								<option value="se" ' . ( 'se' == $Value->$Field ? 'selected="selected"' : false ) . '>Sergipe</option> 
								<option value="sp" ' . ( 'sp' == $Value->$Field ? 'selected="selected"' : false ) . '>São Paulo</option> 
								<option value="to" ' . ( 'to' == $Value->$Field ? 'selected="selected"' : false ) . '>Tocantins</option>';
					}

					$HTML .= '</select>';

					break;

					case 'radio':

						foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
						
							$HTML .= '<input type="radio" name="' . $Field . '" value="' . $Value . '" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" ' . ( $Value == $Value->$Field ? 'checked="checked"' : false ) . ' tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '"> <label for="fld' . $Content . '">' . $Content . '</label>';
							$HTML .= '<br>';

						}
						break;

					case 'checkbox':

						foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
						
							$HTML .= '<input type="checkbox" name="' . $Field . '" value="' . $Value . '" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" ' . ( $Value == $Value->$Field ? 'checked="checked"' : false ) . '> <label for="fld' . $Content . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">' . $Content . '</label>';
							$HTML .= '<br>';

						}
						break;

					case 'file':
						$HTML 	.= '
						<input id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" name="' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" type="hidden" value="' . $Value->$Field . '">
						
						<div for="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" class="field_files" title="' . $Value->$Field . '">
							<span class="name_file">' . ( !empty( $Value->$Field ) ? $Value->$Field : 'Nenhum arquivo selecionado' ) . '</span>
						</div>

						<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored openModal" title="<i class=\'material-icons fL mR\'>&#xE02E;</i> Selecionar arquivo" data-parent="#Module' . $Url[1] . '" data-shadow="false" for="fileUpload" href="/Explorer?navPrev=true&type=' . $Array['Fields'][ $Field ]['Options']['Types'] . '&for=fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '">Selecionar arquivo</button>';
						break;

					case 'files':

						if(! file_exists( ROOT . '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] ) ){
							mkdir( ROOT . '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] );
							chmod( ROOT . '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1], 0777 );
						}

						if( $new ){
							$Folder = $this->tmp( $Array );
						} else {
							$Folder = '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] . '/' . $Url[2];
						}
						
						$HTML .= '<div class="multi_files" id="' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '"></div>
									<input id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" name="' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" type="hidden" value="' . ( $new ? $Folder : $Value->$Field ) . '">';
						$Script .= '$(\'#' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '\').load(\'/Explorer?Dir=' . $Folder . '\')';

						break;

					case 'cpf':
						$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						$Script .= '$("#fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '").mask("999.999.999-99");';
						break;

					case 'phone':
						$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						$Script .= "$('#fld" . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . "').focusout(function(){
								    var phone, element;
								    element = $(this);
								    element.unmask();
								    phone = element.val().replace(/\D/g, '');
								    if(phone.length > 10) {
								        element.mask('(99) 99999-999?9');
								    } else {
								        element.mask('(99) 9999-9999?9');
								    }
								}).trigger('focusout');";
						break;

					case 'simpleHour':
						$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						$Script .= '$("#fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '").mask("99:99");';
						break;

					case 'money':
					$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
					$Script .= "$('#fld" . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . "').priceFormat({
								    prefix: 'R$ ',
								    centsSeparator: ',',
								    thousandsSeparator: '.'
								});";
						break;

					default:
						$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
						break;
				}

				$HTML .= '</td></tr>';
			}
		}

		$HTML .= '</table> <br><br><br>';

		$ClassBtn = ( isset( $Array['Form']['Buttons']['Save']['Class'] ) ? $Array['Form']['Buttons']['Save']['Class'] : false );

		if( $Array['Form']['Buttons'] !== false ){
			if( !isset( $Array['Form']['Buttons']['Save']['Name'] ) ){
				$HTML .= '
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored ' . $ClassBtn . ' fR" type="submit" for="' . $Url[1] . '">
				  <i class="material-icons">&#xE161;</i>
				</button>';
			} else {
				$HTML .= '<button type="submit" class="' . $ClassBtn . '" for="' . $Url[1] . '">' . $Array['Form']['Buttons']['Save']['Name'] . '</button>';
			}
		}

		$HTML .= '</form>';

		if( isset( $Array['Form']['Scripts'] ) ){
			$Script .= $Array['Form']['Scripts'];
		}

		$HTML .= '<script>' . $Script . '</script>';

		return $HTML;
	}

	function tmp( $Array ){
		global $Url;

		$time = time();
		if( mkdir( ROOT . '/Application/Temp/' . $_SESSION['user']['id_user'] . '/tmp/' . $time ) ){
			chmod( '/Application/Temp/' . $_SESSION['user']['id_user'] . '/tmp/' . $time, 0777 );
			return '/Application/Temp/' . $_SESSION['user']['id_user'] . '/tmp/' . $time;
		} else {
			return false;
		}
	}

	function move( $Array, $move ){

		global $PDO, $Database;

		foreach( $move as $old => $values ){
			rename( ROOT . $old, ROOT . $values['new'] );
			$Database->Update( $Array['bd'], $values['Field'] . "='" . $values['new'] . "'", $Array['auto_increment'] . '=' . $values['Id']  );
		}
	}

	function post( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;

		if( !$_POST ){
			$Return['message'] = false;
		}

		$Return = '';

		$new = true;
		$Query = '';

		if( is_numeric( $Url[3] ) ){
			$new = false;
		}

		if( isset( $_POST['post'] ) ){
			$post = explode( '#&#', $_POST['post'] );
			$save = true;
			unset( $_POST );
			foreach ( $post as $thisPost ) {
				$value = explode( '#=#', $thisPost );
				if(
					$value[0] != 'onUpdate'  &&
					$value[0] != 'alterSess'
				)

				switch( $Array['Fields'][ $value[0] ]['Type'] ){
					
					case 'password':
						if( empty( $value[1] ) ){
							$save = false;
						} else {
							$value[1] = md5( $value[1] );
						}
						break;
				}

				if( $save ){
					$_POST[ $value[0] ] = $value[1];
				}
			}
		}

		if( $new ){

			if( $Array['Form']['Log']['Register'] == true ){
				$_POST['register']	=	date('Y-m-d i:h:s');
			}

			if( $Array['Form']['Log']['AddUser'] == true ){
				$_POST['adduser']	= $_SESSION['user']['id_user'];
			}

			// Insert
			$Query .= " INSERT INTO " . BD . "." . $Array['bd'] . "( ";

			foreach( $Array['Fields'] as $Field => $Data ){
				
				$Query .= $Field . ",";
			}

			$Query = substr( $Query, 0, -1 ) . ' ) VALUES ( ';

			foreach( $Array['Fields'] as $Field => $Data ){
				
				$Query .= "'" . addslashes( $_POST[ $Field ] ) . "',";
			}

			$Query = substr( $Query, 0, -1 ) . ' ) ';
		} else {
			// Update
			$Query .= " UPDATE " . BD . "." . $Array['bd'] . " SET ";
			
			foreach( $Array['Fields'] as $Field => $Data ){
				if( $Field != 'register' && $Field != 'AddUser' ){
					if( $Data['Type'] != 'password' || ( $Data['Type'] == 'password' && !empty( $_POST[ $Field ] ) ) )
					$Query .= $Field . " = '" . $_POST[ $Field ] . "', ";
				}
			}

			$Query = substr( $Query, 0, -2 ) . ' WHERE ' . $Array['auto_increment'] . " = " . $Url['3'];
		}

		$PDO->exec( $Query );

		if( $new ){

			$id = $PDO->lastInsertId();

			$move = false;

			foreach( $Array['Fields'] as $Field => $Data ){

				if( $Data['Type'] == 'files' ){

					if(! file_exists( ROOT . '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] . '/' . $id ) ){
						mkdir( ROOT . '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] . '/' . $id );
						chmod( ROOT . '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] . '/' . $id, 0777 );
					}

					$tmp = $Database->Search( $Array['bd'], $Field, $Array['auto_increment'] . '=' . $id );
					$move[ $tmp->$Field ]['new'] = '/Application/Groups/' . $_SESSION['user']['Path'] . '/' . $Url[1] . '/' . $id;
					$move[ $tmp->$Field ]['Field'] = $Field;
					$move[ $tmp->$Field ]['Id'] = $id;
				}
			}

			if( $move != false ){
				$this->move( $Array, $move );
			}
		}

		$Return['new']      = $new;
		$Return['message']  = $PDO->errorInfo();
		$Return['query']	= $Query;
		$Return['Location'] = '/' . $Url[1];

		return $Return;
	}
}

$autoSystem = new autoSystem;