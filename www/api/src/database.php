<?php 
	class Database {
		public function connect(){
			try {
				$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
				return $conn;
			} catch (Exception $e) {
				die(json_encode([
					'cod' => 500,
					'message' => 'Erro ao se conectar com o banco de dados'
				]));
			}
		}
		
		public function destroy($conn){
			mysqli_close($conn);
		}

		public function insert($table, $data){
			if(count($data) > 0){
				$conn = $this->connect();
	
				if($conn != null){
					$colunas = array();
					$values = array();
	
					foreach ($data as $coluna => $value) {
						$colunas[] = mysqli_real_escape_string($conn, trim($coluna));
						$values[] = "'".mysqli_real_escape_string($conn, trim($value))."'";
					}
	
					$colunas = implode(', ', $colunas);
					$values = implode(', ', $values);
	
					$sql = "INSERT INTO $table ($colunas) VALUES ($values)";
					$result = $conn->query($sql);
	
					if($result){
						$log['cod'] = 200;
						$log['id'] = $conn->insert_id;
						$log['id_format'] = str_pad($log['id'], 4, "0", STR_PAD_LEFT);
					} else {
						$log['cod'] = 500;
						$log['message'] = 'Erro ao cadastrar no banco de dados';
						$log['error'] = mysqli_error($conn);
					}
					$this->destroy($conn);
				} else {
					$log['cod'] = 500;
					$log['message'] = 'Erro ao se conectar com o banco de dados';
				}
			} else {
				$log['cod'] = 500;
				$log['message'] = 'Nenhum dado para inserção';
			}
			return $log;
		}

		public function update($table, $data = [], $where = [], $operator = '='){
			if(count($data) > 0){
				$conn = $this->connect();
	
				if($conn != null){
					$values = array();
					$wheres = array();
	
					foreach ($data as $coluna => $value) {
						if(!is_array($value)){
							$values[] = "$coluna = '".mysqli_real_escape_string($conn, trim($value))."'";
						}
					}
					$values = implode(', ', $values);
	
					foreach ($where as $coluna => $value) {
						if(!is_array($value)){
							if($operator == '=') {
								$wheres[] = "$coluna = '".mysqli_real_escape_string($conn, trim($value))."'";
							} else {
								$wheres[] = "$coluna in (".mysqli_real_escape_string($conn, trim($value)).")";
							}
						}
					}
					if(DEBUG){
						$log['data'] = $values;
						$log['where'] = $wheres;
					}
	
					if(count($wheres) > 0){
						$wheres = implode(' AND ', $wheres);
						
						$sql = "UPDATE $table SET $values WHERE $wheres";
					} else {
						$sql = "UPDATE $table SET $values";
					}
					$result = $conn->query($sql);
	
					if($result){
						$log['cod'] = 200;
						
						$createLog['data'] = $data;
						$createLog['where'] = $where;
					} else {
						$log['cod'] = 500;
						$log['message'] = 'Erro ao cadastrar no banco de dados';
						$log['error'] = mysqli_error($conn);
					}
					$this->destroy($conn);
				} else {
					$log['cod'] = 0;
					$log['message'] = 'Erro ao se conectar com o banco de dados';
				}
			} else {
				$log['cod'] = 500;
				$log['message'] = 'Nenhum dado para inserção';
			}
			return $log;
		}

		public function select($table, $where=array(), $order=array(), $operator = '=', $paginate = []){
			$conn = $this->connect();
	
			if($conn != null){
				$wheres = array();
				if(is_array($where) AND count($where) > 0){
					foreach ($where as $coluna => $value) {
						if(!is_array($value)){
	
							if($operator == 'in' || $operator == 'IN'){
								$wheres[] = "$coluna in (".mysqli_real_escape_string($conn, trim($value)).")";
							} else if($operator == 'not in' || $operator == 'NOT IN') {
								$wheres[] = "$coluna not in (".mysqli_real_escape_string($conn, trim($value)).")";
							} else if($operator == 'like' || $operator == 'LIKE'){
								$wheres[] = "$coluna LIKE '".mysqli_real_escape_string($conn, trim($value))."'";
							} else {
								$wheres[] = "$coluna = '".mysqli_real_escape_string($conn, trim($value))."'";
							}
						}
					}
				}
				if(DEBUG){
					$log['where'] = $wheres;
				}
				$wheres = implode(' AND ', $wheres);
	
				$orders = array();
				if(is_array($order) AND count($order) > 0){
					foreach ($order as $coluna => $value) {
						if(!is_array($value)){
							$value = mysqli_real_escape_string($conn, trim($value));
							$value = ($value === true || $value === 'ASC' || $value === 'asc') ? 'ASC' : 'DESC';
							$orders[] = $coluna.' '.$value; 
						}
					}
				}
				if(DEBUG){
					$log['order'] = $orders;
				}
				$orders = implode(', ', $orders);
	
				$sql = "SELECT * FROM $table";
				if($wheres != ''){
					$sql .= ' WHERE '.$wheres;
				}
				if($orders != ''){
					$sql .= ' ORDER BY '.$orders;
				}
				
				if(@$paginate['page'] AND @$paginate['limit']){
					$paginate = $this->scape_string($paginate);
					$limit  =  (@$paginate['limit'] AND is_numeric(@$paginate['limit'])) ? 
								intval($paginate['limit']) : 
								10;
								
					$page   =  (@$paginate['page'] AND is_numeric($paginate['page'])) ? 
								intval($paginate['page']) : 
								1;
					
					$start  = ($page - 1) * $limit;
					
					$sql .= ' LIMIT '.$start.', '.$limit;
				}
				
				$result = $conn->query($sql);
				$log['result'] = array();
	
				if($result){
					$log['cod'] = 200;
					if(DEBUG){
						$log['query'] = $sql;
						$log['operator'] = $operator;
					}
	
					while ($dado = mysqli_fetch_assoc($result)) {
						if(@$dado['id']){
							$dado['id_format'] = str_pad($dado['id'], 4, "0", STR_PAD_LEFT);
						}
						$log['result'][] = $dado;
					}
				} else {
					$log['cod'] = 500;
					$log['message'] = 'Erro ao buscar no banco de dados';
					$log['error'] = mysqli_error($conn);
				}
				$this->destroy($conn);
			} else {
				$log['cod'] = 0;
				$log['message'] = 'Erro ao se conectar com o banco de dados';
			}
			return $log;
		}

		public function delete($table, $where=array()){
			// $log['type'] = 'delete';
	
			if(count($where) > 0){
				$conn = $this->connect();
	
				if($conn != null){
					$wheres = array();
	
					foreach ($where as $coluna => $value) {
						if(!is_array($value)){
							$wheres[] = "$coluna = '".mysqli_real_escape_string($conn, trim($value))."'";
						}
					}
					if(DEBUG){
						$log['where'] = $wheres;
					}
	
					$wheres = implode(' AND ', $wheres);
	
					$sql = "DELETE FROM $table WHERE $wheres";
					$result = $conn->query($sql);
	
					if($result){
						$log['cod'] = 200;
					} else {
						$log['cod'] = 500;
						$log['message'] = 'Erro ao deletar no banco de dados';
						$log['error'] = mysqli_error($conn);
					}
					$this->destroy($conn);
				} else {
					$log['cod'] = 500;
					$log['message'] = 'Erro ao se conectar com o banco de dados';
				}
			} else {
				$log['cod'] = 500;
				$log['message'] = 'Nenhum dado para deletar';
			}
			return $log;
		}
		
		public function selectQuery($sql, $paginate = []){
			// $log['type'] = 'select';
			if(DEBUG){
				$log['query'] = $sql;
			}
	
			$conn = $this->connect();
	
			if($conn != null){
				if(@$paginate['page'] AND @$paginate['limit']){
					$paginate = $this->scape_string($paginate);
					$limit  =  (@$paginate['limit'] AND is_numeric(@$paginate['limit'])) ? 
								intval($paginate['limit']) : 
								10;
								
					$page   =  (@$paginate['page'] AND is_numeric($paginate['page'])) ? 
								intval($paginate['page']) : 
								1;
					
					$start  = ($page - 1) * $limit;
					
					$sql .= ' LIMIT '.$start.', '.$limit;
				}
				
				$result = $conn->query($sql);
				$log['result'] = array();
	
				if($result){
					$log['cod'] = 200;
	
					while (@$dado = mysqli_fetch_assoc($result)) {
						if(@$dado['id']){
							$dado['id_format'] = str_pad($dado['id'], 4, "0", STR_PAD_LEFT);
						}
	
						foreach ($dado as $col => $value) {
							if(strpos($col, '|') !== false) {
								$dataEx = explode('|', $col);
			
								$colName = $dataEx[0];
								$colVal = $dataEx[1];
								$dado[$colName][$colVal] = $value;
			
								unset($dado[$col]);
							}
						}
						
						$log['result'][] = $dado;
					}
				} else {
					$log['cod'] = 500;
					$log['message'] = 'Erro ao buscar no banco de dados';
					$log['error'] = mysqli_error($conn);
				}
				$this->destroy($conn);
			} else {
				$log['cod'] = 500;
				$log['message'] = 'Erro ao se conectar com o banco de dados';
			}
			return $log;
		}
		
		public function scape_string($data){
			$conn = $this->connect();
			
			if($conn != null){
				if(is_array($data)){
					foreach ($data as $key => $value) {
						$data[mb_strtolower($key)] = mysqli_real_escape_string($con, $value);
					}
				} else {
					$data = mysqli_real_escape_string($con, $data);
				}
		
				$this->destroy($con);
				return $data; 
			} else {
				$log['cod'] = 500;
				$log['message'] = 'Erro ao se conectar com o banco de dados';
				
				return $log;
			}
		}
	}
?>