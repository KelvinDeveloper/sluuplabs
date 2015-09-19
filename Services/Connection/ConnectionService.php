<?php
$PDO = new PDO( strtolower( $Conf['Database']['Type'] ) .  ':host=' . $Conf['Database']['Server'] . ';dbname=' . $Conf['Database']['Global'] , $Conf['Database']['User'], $Conf['Database']['Password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $Conf['Database']['Decode'] ) ); 

class Database{

	function Search( $Table, $Fields, $Where, $Order, $Group, $Limit, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) ){
			$query = " SELECT ";
			if( !empty( $Fields ) ){
				$query .= str_replace( ';', '', str_replace( ' ', '', $Fields ) ) . " FROM ";
			} else {
				$query .= " * FROM ";
			}
			$query .= $Database . "." . $Table . " ";
			if( !empty( $Where ) ){
				$query .= " WHERE " . $Where;	
			}
			if( !empty( $Order ) ){
				$query .= ' ORDER BY ' . $Order;
			}
			if( !empty( $Group ) ){
				$query .= ' GROUP BY ' . $Group;
			}
			if( !empty( $Limit ) ){
				$query .= ' LIMIT ' . $Limit;
			}
			$List = $PDO->query( $query );
			return $List->fetch(PDO::FETCH_OBJ);
		} else {
			return 'ERROR SYNTAX';
			exit;
		}

	}

	function Fetch( $Table, $Fields, $Where, $Order, $Group, $Limit, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) ){
			$query = ' SELECT ';
			if( !empty( $Fields ) ){
				$query .= str_replace( ';', '', str_replace( ' ', '', $Fields ) );
			} else {
				$query .= ' * ';
			}
			$query .= ' FROM ' . $Database . "." . $Table . ' ';
			if( !empty( $Where ) ){
				$query .= ' WHERE ' . $Where;	
			}
			if( !empty( $Order ) ){
				$query .= ' ORDER BY ' . $Order;
			}
			if( !empty( $Group ) ){
				$query .= ' GROUP BY ' . $Group;
			}
			if( !empty( $Limit ) ){
				$query .= ' LIMIT ' . $Limit;
			}
			return $PDO->query( $query );
		} else {
			return 'ERROR SYNTAX';
			exit;
		}

	}

	function Assoc( $Table, $Where, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) ){
			$query = " SELECT * FROM " . $Database . "." . $Table . " ";
			if( !empty( $Where ) ){
				$query .= " WHERE " . $Where;	
			}
			$List = $PDO->query( $query );
		} else {
			return 'ERROR SYNTAX';
			exit;
		}

	}

	function Desc( $Table, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) ){
			$query = " DESC " . $Database . "." . $Table . " ";
			return $Desc = $PDO->query( $query );
		} else {
			return 'ERROR SYNTAX';
			exit;
		}

	}

	function Update( $Table, $Update, $Where, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) || empty( $Update ) ){
			$query = ' UPDATE ' . $Database . "." . $Table . ' SET ' . $Update;
		
			if( !empty( $Where ) ){
				$query .= " WHERE " .  $Where;	
			}
			$Exec = $PDO->exec( $query );
			if( $Exec !== false ){
				return true;
			} else {
				echo 'Error Update  => ' . $query;
				return false;
			}
		} else {
			return 'ERROR SYNTAX';
			exit;
		}

	}

	function Insert( $Table, $Fields, $Values, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) || empty( $Values ) ){
			$query = ' INSERT INTO ' . $Database . "." . $Table;
			if( $Fields ){
				$query .= ' (' . $Fields . ') ';
			}
			$query .= ' VALUES (' . $Values . ') ';
			$Exec = $PDO->exec( $query );
			if( $Exec !== false ){
				return $PDO->lastInsertId();
			} else {
				echo 'Error Insert => ' . $query;
				return false;
			}
		} else {
			return 'ERROR SYNTAX';
			exit;
		}

	}

	function Delete( $Table, $Where, $Database ){

		global $PDO;

		if( !$Database ){ $Database = BD; }

		if( !empty( $Database ) || !empty( $Table ) || empty( $Values ) ){
			$query = " DELETE FROM " . $Database . "." . $Table . " WHERE " . $Where;
			$Exec = $PDO->exec( $query );
			if( !$Exec ){
				echo 'Error Delete => ' . $query;
			} else {
				return true;
			}
		} else {
			return 'ERROR SYNTAX';
		}
	}


}

$Database = new Database;