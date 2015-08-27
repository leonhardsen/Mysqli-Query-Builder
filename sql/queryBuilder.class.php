<?php 

class queryBuilder{

	private $table;
	private $lists;
	private $where;
	private $between;
	private $notbetween;
	private $orderby;
	private $limit;

	public function table($table){
		$this->table = $table;
	}

	public function lists($array){		
		$this->lists = $array;
	}

	public function where($field,$operator,$value,$concat = NULL){	
		$array = array($field,$operator,$value,$concat);	
		$this->where[] = $array;
	}

	public function between($field,$values){	
		$array = array($field,$values[0],$values[1]);	
		$this->between = $array;
	}

	public function notbetween($field,$values){	
		$array = array($field,$values[0],$values[1]);	
		$this->notbetween = $array;
	}
	
	public function orderby($field,$order = 'ASC'){	
		$array = array($field,$order);	
		$this->orderby[] = $array;
	}

	public function limit($limit,$offset = NULL){	
		$array = array($limit,$offset);	
		$this->limit = $array;
	}

	private function makeWhere(){
		$sql_where = '';
		$first_where = 0;
		foreach($this->where as $where){
			if($first_where == 0){
				$sql_where .= ' WHERE ';
			}else{
				if($where[3] == 'or'){
					$sql_where .= ' OR ';
				}else{
					$sql_where .= ' AND ';
				}
			}
			$sql_where .= $where[0].$where[1].$where[2];
			$first_where++;
		}
		return $sql_where;
	}

	public function get(){		
		$sql = 'SELECT ';

		if(empty($this->lists)){
			$sql .= '*';
		}else{
			foreach($this->lists as $list){
				$sql .= $list.', ';
			}
			$sql = substr($sql,0,-2);
		}

		$sql .= ' FROM '.$this->table;

		//where
		if(!empty($this->where)){
			$sql .= $this->makeWhere();
		}

		//between
		if(!empty($this->between)){
			$sql .= ' WHERE '.$this->between[0].' BETWEEN '.$this->between[1].' AND '.$this->between[2];
		}

		//notbetween
		if(!empty($this->notbetween)){
			$sql .= ' WHERE '.$this->notbetween[0].' NOT BETWEEN '.$this->notbetween[1].' AND '.$this->notbetween[2];
		}

		//orderby
		if(!empty($this->orderby)){
			$first_order = 0;
			foreach($this->orderby as $orderby){
				if($first_order == 0){
					$sql .= ' ORDER BY ';
				}
				$sql .= $orderby[0].' '.$orderby[1].', ';
				$first_order++;
			}
			$sql = substr($sql,0,-2);
		}

		//limit
		if(!empty($this->limit)){
			if($this->limit[1] == NULL){
				$sql .= ' LIMIT '.$this->limit[0];
			}else{
				$sql .= ' LIMIT '.$this->limit[1].', '.$this->limit[0];
			}
		}

		return $sql;
	}

	public function insert($data){
		$sql = 'INSERT INTO '.$this->table.' (';
		$fields = '';
		$values = '';
		foreach($data as $f => $d){
			$fields .= $f.', ';
			$values .= '"'.$d.'", ';
		}
		$fields = substr($fields,0,-2);
		$values = substr($values,0,-2);
		$sql .= $fields.') VALUES ('.$values.')';
		return $sql;
	}

	public function update($data){
		$sql = 'UPDATE '.$this->table.' SET ';		
		foreach($data as $f => $d){
			$sql .= $f.'="'.$d.'", ';
		}
		$sql = substr($sql,0,-2);

		//where
		if(!empty($this->where)){
			$sql .= $this->makeWhere();
		}	
		
		return $sql;
	}

	public function delete(){
		$sql = 'DELETE FROM '.$this->table;		

		//where
		if(!empty($this->where)){
			$sql .= $this->makeWhere();
		}	
		
		return $sql;
	}

}

?>