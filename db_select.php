<?php 
// list buku
$table = "buku"
$query = "SELECT * FROM " . $table;
$stmt = $this->conn->prepare($query);
$stmt->execute();
echo $stmt->fetchAll(PDO::FETCH_ASSOC);
// list penulis
$table = "penulis"
$query = "SELECT * FROM " . $table;
$stmt = $this->conn->prepare($query);
$stmt->execute();
echo $stmt->fetchAll(PDO::FETCH_ASSOC);
// list penerbit
$table = "penulis"
$query = "SELECT * FROM " . $table;
$stmt = $this->conn->prepare($query);
$stmt->execute();
echo $stmt->fetchAll(PDO::FETCH_ASSOC);

function select($table, $conn){
  $query = "SELECT * FROM " . $table;
  $stmt = $conn->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$conn = "";
select("penulis",$conn);
select("penerbit",$conn);
?>
