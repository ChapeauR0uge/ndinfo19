<!DOCTYPE html>
<html>
  <head>
      <!-- En-tête de la page -->
      <meta charset="utf-8" />
      <title>PatateFarcie</title>
      <link rel="stylesheet" type="text/css" href="source/style.css" media="all"/>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </head>

    <body>
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
      header("location:forum.php");
    }
    ?>
    </body>
</html>
