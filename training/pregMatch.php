<?php

# это надо прописывать в index.php если хочу юзать, или отключать .htaccess autoload
//>Мои тренировки:

//require_once './training/pregMatch.php';

//<


echo 'Hi from: ' . __FILE__ . '<br>';


$string = '21-11-2020';

//Год 2020, месяц 11, день 21

$pattern = '#([0-9]{2})-([0-9]{2})-([0-9]{4})#';

//$replacement = 'Год $1, месяц $2, день $1';
$replacement = 'Month $2, day $1, yesr $3';

$result = preg_replace($pattern, $replacement, $string);

echo $result . '<br>';

echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
/*

//$string = 'Ученик сидит за партой';
$string = 'Он закончил школу в 2000 году. Стал студентом в 2002';
//$pattern = '/Ученик/';
$pattern = '/200[0-9]/';

$result = preg_match($pattern, $string);

var_dump($result);
//var_dump($pattern);


*/