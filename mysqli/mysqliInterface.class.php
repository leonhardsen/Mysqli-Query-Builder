<?php 

class mysqliInterface{

	private $mysqli;
	private $stmt;

	private function open(){
		$this->mysqli = new mysqli('localhost', 'root', '', 'basedb');
	}

	private function close(){
		$this->stmt->close();
		$this->mysqli->close();
	}

	public function execute($sql){
		$this->open();		
		$this->stmt = $this->mysqli->prepare($sql);
		$this->stmt->execute();
	}

	public function select($sql){
		$this->execute($sql);
		$metas = $this->stmt->result_metadata();
		$model = new stdClass();
		while($field = $metas->fetch_field()){
			$f_name = $field->name;
			$model->$f_name = NULL;	
			$fields[] = $f_name;
			$fields_reference[] = &$model->$f_name;
		}
		$this->stmt->store_result();
		call_user_func_array(array($this->stmt, 'bind_result'), $fields_reference);
		$result = array();
		while($this->stmt->fetch()){	
			$row = new stdClass();
			foreach($fields as $fd){
				$row->$fd = $model->$fd;
			}
			$result[] = $row;
		}
		return $result;
		$this->close();
	}

	public function insert($sql){
		$this->execute($sql);
		return $this->mysqli->insert_id;
		$this->close();
	}

	public function update($sql){
		$this->execute($sql);
		return $this->mysqli->affected_rows;
		$this->close();
	}

	public function delete($sql){
		$this->execute($sql);
		return $this->mysqli->affected_rows;
		$this->close();
	}


}

?>