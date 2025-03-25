<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
  $vari = 100;
//   int $var = "100.21213";
//   string $var = "100"
//   double $var = 10.22
  echo "<b>nilai ini dari php $vari</b> ";  
  echo date("Y-m-d  H:i:s");

  
?>
<br>
<?php 
$team = array('Bill', 'Mary', 'Mike', 'Chris', 'Anne');
?>

<?php foreach ($team as $el): ?>
    <li> <?= "kiri $el kanan" ?> </li>
<?php endforeach?>



<p>ini text biasa ji 1000</p>

<?php 
$pi = "3";
$radius = 5;
echo $pi * ($radius * $radius);

?>
</body>
</html>
