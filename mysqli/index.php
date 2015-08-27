<?php 
require('queryBuilder.class.php');
require('mysqliInterface.class.php');

$qb = new queryBuilder();
$qb->table('produtos');
$qb->lists(array('nome'));
$qb->where('categoria_id','=','2');
$qb->where('valor','>','40');
$qb->where('valor','<','5','or');
$qb->orderby('valor', 'ASC');
$qb->orderby('categoria_id', 'DESC');
$qb->limit(5);
$result = $qb->get();

var_dump($result);

/*
$qb4 = new queryBuilder();
$qb4->table('produtos');
$data = array('nome' => 'Produto Insert Mysqli', 'valor' => '85.56', 'categoria_id' => '2');
$lastInserted = $qb4->insert($data);
echo $lastInserted;



$qb5 = new queryBuilder();
$qb5->table('produtos');
$qb5->where('id','=','1');
$data = array('nome' => 'Produto BD Updated', 'valor' => '55.58');
$affected = $qb5->update($data);
echo $affected;


$qb6 = new queryBuilder();
$qb6->table('produtos');
$qb6->where('id','=','18');
$deleted = $qb6->delete();
echo $deleted;
*/


?>