<?php
class autoSystem{
	function create( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;

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
				echo '<a href="/' . $Url[1] . '/Novo" class="openThisWindow btn btn-white">' . ( isset( $Array['Grid']['Buttons']['Label']['New'] ) ? $Array['Grid']['Buttons']['Label']['New'] : _('Novo registro') ) . ' <i class="material-icons fR">add</i></a>';
			}
		}

		$HTML .= '<table ' . ( isset( $Array['Grid']['Width'] ) ? 'width="' . $Array['Grid']['Width'] . '"' : false ) . ' class="tableDefault">';

			$HTML .= '<thead>';

				$HTML .= '<tr>';

				$SQLFields = $Database->Desc( $Array['bd'] );
				while ( $F = $SQLFields->fetch(PDO::FETCH_OBJ) ){
					$HTML .= '<td>' . $F->Field . '</td>';
					$Fields[ $F->Field ] = $F;
				}

				$HTML .= '</tr>';

			$HTML .= '</thead>';
			$HTML .= '<tbody>';
			
				$Result = $Database->Fetch( $Array['bd'] );
				while ( $Value = $Result->fetch(PDO::FETCH_OBJ) ){
					$HTML .= '<tr href="/' . $Url[1] . '/' . $Value->$Array['auto_increment'] . '">';
					foreach ( $Fields as $Field => $Info ){
						$HTML .= '<td>' . $Value->$Field . '</td>';
					}
					$HTML .= '</tr>';
				}

			$HTML .= '</tbody>';

		$HTML .= '</table>';

		return $HTML;

	}

	function form( $Array ){
		global $Database, $PDO, $Conf, $Domain, $Url;

		$new = false;

		$HTML = '';

		if( is_numeric( $Url[2] ) ){
			$new = true;
		}

		foreach ( $Array['Fields'] as $Field => $Data ){

			switch ( $Data['Type'] ) {
				
				case 'text':
					$HTML .= '<input type="text" Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Data['Value'] . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">';
					break;

			case 'hidden':
					$HTML .= '<input type="hidden" Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Data['Value'] . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">';
					break;

			case 'rand':
					$HTML .= '<input type="hidden" Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . ( empty( $Data['Value'] ) ? rand() : $Data['Value'] ) . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">';
					break;

				case 'password':
					if( $Data['Security'] === true && $Url[2] != 'Criar-Usuario' ){
						$HTML .= '<input type="password" Length="' . $Data['Length'] . '" placeholder="Senha Atual" name="Atual' . $Field . '" class="' . $Data['Class'] .'" id="fldAtual' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '"><br>';
					}
					$HTML .= '<input type="password" Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Data['Value'] . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">';
					if( $Data['Security'] === true ){
						$HTML .= '<br><input type="password" Length="' . $Data['Length'] . '" placeholder="Repetir ' . ( $Url[2] != 'Criar-Usuario' ? 'Nova Senha' : 'Senha' ) . '" name="ReNova' . $Field . '" class="' . $Data['Class'] .'" id="fldReNova' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '"><br>';
					}
					break;

				case 'textarea':
					$HTML .= '<textarea Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">' . $Data['Value'] . '</textarea>';
					break;

				case 'HTML':
					$HTML .= '<textarea Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" id="content" class="' . $Data['Class'] .' tinymce" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">' . $Data['Value'] . '</textarea>';
					$EditorHTML = true;
					break;

				case 'select':
					$HTML .= '<select name="' . $Field . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">';

					foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
					
						$HTML .= '<option value="' . $Value . '" ' . ( $Value == $Data['Value'] ? 'selected="selected"' : false ) . '>' . $Content . '</option>';

					}

					if( $thisForm['Fields'][ $Field ]['Stats'] === 'BR' ){
						$HTML .= '
								<option value="">Selecionar Estado</option>
								<option value="ac" ' . ( 'ac' == $Data['Value'] ? 'selected="selected"' : false ) . '>Acre</option> 
								<option value="al" ' . ( 'al' == $Data['Value'] ? 'selected="selected"' : false ) . '>Alagoas</option> 
								<option value="am" ' . ( 'am' == $Data['Value'] ? 'selected="selected"' : false ) . '>Amazonas</option> 
								<option value="ap" ' . ( 'ap' == $Data['Value'] ? 'selected="selected"' : false ) . '>Amapá</option> 
								<option value="ba" ' . ( 'ba' == $Data['Value'] ? 'selected="selected"' : false ) . '>Bahia</option> 
								<option value="ce" ' . ( 'ce' == $Data['Value'] ? 'selected="selected"' : false ) . '>Ceará</option> 
								<option value="df" ' . ( 'df' == $Data['Value'] ? 'selected="selected"' : false ) . '>Distrito Federal</option> 
								<option value="es" ' . ( 'es' == $Data['Value'] ? 'selected="selected"' : false ) . '>Espírito Santo</option> 
								<option value="go" ' . ( 'go' == $Data['Value'] ? 'selected="selected"' : false ) . '>Goiás</option> 
								<option value="ma" ' . ( 'ma' == $Data['Value'] ? 'selected="selected"' : false ) . '>Maranhão</option> 
								<option value="mt" ' . ( 'mt' == $Data['Value'] ? 'selected="selected"' : false ) . '>Mato Grosso</option> 
								<option value="ms" ' . ( 'ms' == $Data['Value'] ? 'selected="selected"' : false ) . '>Mato Grosso do Sul</option> 
								<option value="mg" ' . ( 'mg' == $Data['Value'] ? 'selected="selected"' : false ) . '>Minas Gerais</option> 
								<option value="pa" ' . ( 'pa' == $Data['Value'] ? 'selected="selected"' : false ) . '>Pará</option> 
								<option value="pb" ' . ( 'pb' == $Data['Value'] ? 'selected="selected"' : false ) . '>Paraíba</option> 
								<option value="pr" ' . ( 'pr' == $Data['Value'] ? 'selected="selected"' : false ) . '>Paraná</option> 
								<option value="pe" ' . ( 'pe' == $Data['Value'] ? 'selected="selected"' : false ) . '>Pernambuco</option> 
								<option value="pi" ' . ( 'pi' == $Data['Value'] ? 'selected="selected"' : false ) . '>Piauí</option> 
								<option value="rj" ' . ( 'rj' == $Data['Value'] ? 'selected="selected"' : false ) . '>Rio de Janeiro</option> 
								<option value="rn" ' . ( 'rn' == $Data['Value'] ? 'selected="selected"' : false ) . '>Rio Grande do Norte</option> 
								<option value="ro" ' . ( 'ro' == $Data['Value'] ? 'selected="selected"' : false ) . '>Rondônia</option> 
								<option value="rs" ' . ( 'rs' == $Data['Value'] ? 'selected="selected"' : false ) . '>Rio Grande do Sul</option> 
								<option value="rr" ' . ( 'rr' == $Data['Value'] ? 'selected="selected"' : false ) . '>Roraima</option> 
								<option value="sc" ' . ( 'sc' == $Data['Value'] ? 'selected="selected"' : false ) . '>Santa Catarina</option> 
								<option value="se" ' . ( 'se' == $Data['Value'] ? 'selected="selected"' : false ) . '>Sergipe</option> 
								<option value="sp" ' . ( 'sp' == $Data['Value'] ? 'selected="selected"' : false ) . '>São Paulo</option> 
								<option value="to" ' . ( 'to' == $Data['Value'] ? 'selected="selected"' : false ) . '>Tocantins</option>';
					}

					$HTML .= '</select>';

					break;

				case 'radio':

					foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
					
						$HTML .= '<input type="radio" name="' . $Field . '" value="' . $Value . '" id="fld' . $Content . '" ' . ( $Value == $Data['Value'] ? 'checked="checked"' : false ) . ' tabindex="' . $Data['Tabindex'] . '"> <label for="fld' . $Content . '">' . $Content . '</label>';
						$HTML .= '<br>';

					}
					break;

				case 'checkbox':

					foreach ( $thisForm['Fields'][ $Field ]['Options'] as $Value => $Content ) {
					
						$HTML .= '<input type="checkbox" name="' . $Field . '" value="' . $Value . '" id="fld' . $Content . '" ' . ( $Value == $Data['Value'] ? 'checked="checked"' : false ) . '> <label for="fld' . $Content . '" tabindex="' . $Data['Tabindex'] . '">' . $Content . '</label>';
						$HTML .= '<br>';

					}
					break;

				default:
				
					$HTML .= '<input type="text" Length="' . $Data['Length'] . '" placeholder="' . ( isset( $Data['Placeholder'] ) ? ucfirst( $Data['Placeholder'] ) : ucfirst( $Field ) ) . '" name="' . $Field . '" value="' . $Data['Value'] . '" class="' . $Data['Class'] .'" id="fld' . ( empty( $Data['ID'] ) ? $Field : $Data['ID'] ) . '" tabindex="' . $Data['Tabindex'] . '">';
					break;
			}

			$HTML .= '<br>';
		}

		$HTML .= '<button class="' . ( $new ? 'insert' : 'update' ) . '">' . _('Salvar') . '</button>';

		return $HTML;
	}
}

$autoSystem = new autoSystem;