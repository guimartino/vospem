<?php
  define( 'MYSQL_HOST', 'localhost' );
  define( 'MYSQL_USER', 'vospem_q' );
  define( 'MYSQL_PASSWORD', 'Wrgw0nyGnZ6R4Ji4' );
  define( 'MYSQL_DB_NAME', 'chatbot' );
  $PDO = null;
  function con(){
    global $PDO;
    try{
        $PDO = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD );
        $PDO->exec("set names utf8");
        return $PDO;
    }catch ( PDOException $e )
    {
      return null; //echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
    }
    return null;
  }



  //vospem_e - EKHpx6lVwyyy4dnt
 ?>
