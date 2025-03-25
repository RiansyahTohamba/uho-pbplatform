<?php
class Buku{
  // state/field
  var $penulis = "";
  var $judul = "";
  // command function
  function setPenulis($nama){
    $this->penulis = "Sang penulis $nama"
  }
  // query function
  function getPenulis($nama){
    return "Penulis: $nama"
  }

  function __construct(){
    echo 'otomatis <br>';
  }

  static function fungsi_kelas(){
    echo 'fungsi kelas<br>';
  }

  function fungsi_instance($nama){
    echo "fungsi milik instance kelas $nama <br>";
  }
}

function main(){
  echo 'hi, ini fungsi main <br>';
  Buku::fungsi_kelas();

  $bukuMatematika = new Buku();
  $bukuMatematika->setPenulis("rian");

  // $bukuMatematika->fungsi_instance("mtk");
  // $bukuKimia = new Buku();
  // $bukuKimia->fungsi_instance("kimia");
}


main();


?>