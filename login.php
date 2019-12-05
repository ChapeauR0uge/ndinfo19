<!DOCTYPE html>
<html>
    <head>
        <!-- En-tête de la page -->
        <meta charset="utf-8" />
        <title>PatateCuite</title>
        <link rel="stylesheet" type="text/css" href="source/style.css" media="all"/>
    </head>

    <body>
      <?php
        session_start();
        require 'utils.php';
        require 'db_connect.php' ;
        $db =  db_connect();
      ?>
      <h1>Connexion</h1>
      <form action="login.php" method="post">
        <div class="form-group">
          <label for="examplePseudo">Pseudo</label>
          <input name="pseudo" type="text" class="form-control" id="examplePseudo" placeholder="Enter pseudo">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <button name="ok" type="submit" class="btn btn-primary" value="ok">Submit</button>
    </form>

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
