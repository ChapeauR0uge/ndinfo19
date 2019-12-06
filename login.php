<?php
        session_start();
        require 'utils.php';
        require 'db_connect.php' ;
        $db =  db_connect();
?>
<?php
  if(isset($_POST['ok']))
    {
      echo "passage formulaire ok";
      $req = $db->prepare('SELECT * FROM user WHERE pseudo=:pseudo AND password=:password');

      $req->execute(array('pseudo'=>$_POST['pseudo'],'password'=>$_POST['password']));

      while($donnee = $req->fetch())
      {
        $_SESSION['login'] = true;
        $_SESSION['pseudo'] = $donnee['pseudo'];
      }
      header("location:".$_SERVER['HTTP_REFERER']);
    }
?>
