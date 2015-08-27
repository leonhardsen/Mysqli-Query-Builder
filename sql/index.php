<?php 
require('queryBuilder.class.php');

$qb = new queryBuilder();
$qb->table('produtos');
$qb->lists(array('id','nome'));
$qb->where('categoria_id','=','1');
$qb->where('valor','>','40');
$qb->where('valor','<','5','or');
$qb->orderby('valor', 'ASC');
$qb->orderby('categoria_id', 'DESC');
$qb->limit(5);
$sql = $qb->get();
echo $sql;

echo "<br><br>";

$qb2 = new queryBuilder();
$qb2->table('produtos');
$qb2->lists(array('nome'));
$qb2->between('valor', array(25,65));
$qb2->orderby('valor', 'DESC');
//$qb2->limit(5,1);
$sql2 = $qb2->get();
echo $sql2;

echo "<br><br>";

$qb3 = new queryBuilder();
$qb3->table('produtos');
$qb3->notbetween('valor', array(10,20));
$qb3->orderby('valor','DESC');
//$qb3->limit(10,5);
$sql3 = $qb3->get();
echo $sql3;

echo "<br><br>";

$qb4 = new queryBuilder();
$qb4->table('produtos');
$data = array('nome' => 'Produto BD', 'valor' => '25.56', 'categoria_id' => '1');
$sql4 = $qb4->insert($data);
echo $sql4;

echo "<br><br>";

$qb5 = new queryBuilder();
$qb5->table('produtos');
$qb5->where('id','=','1');
$data = array('nome' => 'Produto BD Updated', 'valor' => '55.56');
$sql5 = $qb5->update($data);
echo $sql5;

echo "<br><br>";

$qb6 = new queryBuilder();
$qb6->table('produtos');
$qb6->where('id','=','7');
$sql6 = $qb6->delete();
echo $sql6;

?>