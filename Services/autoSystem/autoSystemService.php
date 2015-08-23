<?php
class autoSystem{
	function create( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url, $Router;

		// Autobd
		$this->autobd( $Array );

		// Grid
		if( !isset( $Url[2] ) ){
			return $this->grid( $Array );
		}
		// Form
		else if( is_numeric( $Url[2] ) || $Url[2] == 'Novo' ){
			return $this->form( $Array );
		}
		else if(  $Url[2] == 'Salvar' ){

			$Module = $Router[ $Domain[0] ][ $Url[1] ];
			$Module = explode( '/', $Module );

			@include ROOT . '/Modules/' . $Module[1] . '/Valid.php';

			$Json = '';
			
			if( function_exists('onStart') ){
				onStart( $Array );
			}

			echo json_encode( $this->post( $Array ) );

			if( function_exists('onEnd') ){
				onEnd( $Array );
			}
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
			if( !isset( $Field[ $k ] ) ){
				
				$Type = $this->field_type( $v );

				$PDO->exec( " ALTER TABLE `" . BD . "`.`" . $Array['bd'] . "` 
				ADD COLUMN `" . $k . "` " . $Type . "  NULL " );
			}
			else if( $v['Type'] .'(' . $v['Lenght'] . ')' != $Field[ $k ]->Type ){

				$Type = $this->field_type( $v );

				$PDO->exec( " ALTER TABLE `" . BD . "`.`" . $Array['bd'] . "` 
							CHANGE COLUMN `" . $k . "` `" . $k . "` " . $Type . " NULL DEFAULT NULL " );

			}
		}
	}

	function field_type( $v ){
		switch ( $v['Type'] ){
			case 'text':
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
				break;
			default:
				$Type = "VARCHAR(" . ( isset( $v['Lenght'] ) ? $v['Lenght']: 45 ) . ")";
				break;
		}
		return $Type;
	}

	function grid( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;
		
		$HTML = '';

		if( $Array['Grid']['Buttons'] || !isset( $Array['Grid']['Buttons'] ) ){
			if( $Array['Grid']['Buttons']['New'] !== false || !isset( $Array['Grid']['Buttons']['New'] ) ){
				if( !isset( $Array['Grid']['Buttons']['Label']['New'] ) ){
					$HTML .= '<a href="/' . $Url[1] . '/Novo" class="openThisWindow mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored">
								<i class="material-icons">add</i>
							</a>';
				} else {
					$HTML .= '<a href="/' . $Url[1] . '/Novo" class="openThisWindow mdl-button mdl-js-button mdl-button--raised mdl-button--accent mdl-js-ripple-effect">' . $Array['Grid']['Buttons']['Label']['New'] . ' <i class="material-icons fR">add</i></a> <br><br>';
				}
			}
		}

		$HTML .= '<br><br>';

		$HTML .= '<table ' . ( isset( $Array['Grid']['Width'] ) ? 'width="' . $Array['Grid']['Width'] . '"' : false ) . ' class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp tableDefault">';

			$HTML .= '<thead>';

				$HTML .= '<tr>';

				$SQLFields = $Database->Desc( $Array['bd'] );

				$HTML .= '<td class="check"> 
							<label for="CheckAll" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
							  <input type="checkbox" id="CheckAll" class="mdl-checkbox__input" />
							</label>

						</td>';

				while ( $F = $SQLFields->fetch(PDO::FETCH_OBJ) ){
					$HTML .= '<td>' . ucfirst( $F->Field ) . '</td>';
					$Fields[ $F->Field ] = $F;
				}

				$HTML .= '<td></td>';

				$HTML .= '</tr>';

			$HTML .= '</thead>';
			$HTML .= '<tbody>';
			
				$Result = $Database->Fetch( $Array['bd'] );
				while ( $Value = $Result->fetch(PDO::FETCH_OBJ) ){
					$HTML .= '<tr href="/' . $Url[1] . '/' . $Value->$Array['auto_increment'] . '">';
						
						$HTML .= '<td class="check"> 
									<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-' . $Value->$Array['auto_increment'] . '">
									  <input type="checkbox" id="checkbox-' . $Value->$Array['auto_increment'] . '" class="mdl-checkbox__input" checked />
									</label>
								</td>';

					foreach ( $Fields as $Field => $Info ){

						$HTML .= '<td>' . $Value->$Field . '</td>';
					}

					$HTML .= '
					<td>
						<button id="' . $Value->$Array['auto_increment'] . '-menu"
						        class="mdl-button mdl-js-button mdl-button--icon">
						  <i class="material-icons">more_vert</i>
						</button>

						<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
						    for="' . $Value->$Array['auto_increment'] . '-menu">
						  <li class="mdl-menu__item" onclick="editRegister( $(this).parents(\'tr\') )"><i class="material-icons">&#xE254;</i> ' . _('Editar') . '</li>
						  <li class="mdl-menu__item"><i class="material-icons">&#xE872;</i> ' . _('Excluir') . '</li>
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
		$HTML .= '<h1>';
		
		if( isset( $Array['Form']['Title'] ) ){

			if( is_array( $Array['Form']['Title'] ) ){

				$HTML .= ( $new ? $Array['Form']['Title']['New'] : $Array['Form']['Title']['Edit'] );

			} else {
				$HTML .= $Array['Form']['Title'];
			}

		} else {

			$HTML .= ( $new ? _('Novo registro') : _('Editando registro') );

		}
		
		$HTML .= '</h1>';

		$HTML .= '<table>';

		foreach ( $Array['Fields'] as $Field => $Data ){

			$HTML .= '<tr><td>';

			$HTML .= '<label for="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '">' . ( isset( $Data['Label'] ) ? $Data['Label'] : ucfirst( $Field ) ) . ' </label>';

			$HTML .= '</td><td>';

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
					$HTML .= '<input type="password" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
					if( $Data['Security'] === true ){
						$HTML .= '<br><input type="password" maxlength="' . $Data['Lenght'] . '" placeholder="Repetir ' . ( $Url[2] != 'Criar-Usuario' ? 'Nova Senha' : 'Senha' ) . '" name="ReNova' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fldReNova' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '"><br>';
					}
					break;

				case 'textarea':
					$HTML .= '<textarea maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">' . $Value->$Field . '</textarea>';
					break;

				case 'HTML':
					$HTML .= '<textarea maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" id="content" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .' tinymce" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">' . $Value->$Field . '</textarea>';
					$EditorHTML = true;
					break;

				case 'select':
					$HTML .= '<select name="' . $Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';

					foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
					
						$HTML .= '<option value="' . $Value . '" ' . ( $Value == $Value->$Field ? 'selected="selected"' : false ) . '>' . $Content . '</option>';

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
					
						$HTML .= '<input type="radio" name="' . $Field . '" value="' . $Value . '" id="fld' . $Content . '" ' . ( $Value == $Value->$Field ? 'checked="checked"' : false ) . ' tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '"> <label for="fld' . $Content . '">' . $Content . '</label>';
						$HTML .= '<br>';

					}
					break;

				case 'checkbox':

					foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
					
						$HTML .= '<input type="checkbox" name="' . $Field . '" value="' . $Value . '" id="fld' . $Content . '" ' . ( $Value == $Value->$Field ? 'checked="checked"' : false ) . '> <label for="fld' . $Content . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">' . $Content . '</label>';
						$HTML .= '<br>';

					}
					break;

				default:
				
					$HTML .= '<input type="text" maxlength="' . $Data['Lenght'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Value->$Field . '" class="' . ( isset( $Data['Class'] ) ? $Data['Class'] : false ) .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . ( isset( $Data['Tabindex'] ) ? $Data['Tabindex'] : false ) . '">';
					break;
			}

			$HTML .= '</td></tr>';

		}

		$HTML .= '</table> <br>';

		$ClassBtn = ( isset( $Array['Form']['Buttons']['Save']['Class'] ) ? $Array['Form']['Buttons']['Save']['Class'] : false );

		if( $Array['Form']['Buttons'] !== false ){
			if( !isset( $Array['Form']['Buttons']['Save']['Name'] ) ){
				$HTML .= '
				<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored ' . $ClassBtn . '" type="submit">
				  <i class="material-icons">&#xE161;</i>
				</button>';
			} else {
				$HTML .= '<button type="submit" class="' . $ClassBtn . '">' . $Array['Form']['Buttons']['Save']['Name'] . '</button>';
			}
		}

		$HTML .= '</form>';

		return $HTML;
	}

	function post( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;

		$Return = '';

		$new = true;
		$Query = '';

		if( is_numeric( $Url[3] ) ){
			$new = false;
		}

		if( $new ){
			// Insert
			$Query .= " INSERT INTO " . BD . "." . $Array['bd'] . "( ";

			foreach( $Array['Fields'] as $Field => $Data ){
				
				$Query .= $Field . ",";
			}

			$Query = substr( $Query, 0, -1 ) . ' ) VALUES ( ';

			foreach( $Array['Fields'] as $Field => $Data ){
				
				$Query .= "'" . $_POST[ $Field ] . "',";
			}

			$Query = substr( $Query, 0, -1 ) . ' ) ';
		} else {
			// Update
			$Query .= " UPDATE " . BD . "." . $Array['bd'] . " SET ";
			
			foreach( $Array['Fields'] as $Field => $Data ){
				
				$Query .= $Field . " = '" . $_POST[ $Field ] . "', ";
			}

			$Query = substr( $Query, 0, -2 ) . ' WHERE ' . $Array['auto_increment'] . " = " . $Url['3'];
		}

		$PDO->exec( $Query );
		$Return['new']      = $new;
		$Return['message']  = $PDO->errorInfo();

		return $Return;
	}
}

$autoSystem = new autoSystem;