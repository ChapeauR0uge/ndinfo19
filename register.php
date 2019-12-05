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
        require 'utils.php';
        require 'db_connect.php' ;
        $db =  db_connect();
      ?>
      <h1>Inscription</h1>
      <form action="register.php" method="post">
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
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
      echo $_POST['pseudo'];
      $req = $db->prepare('INSERT INTO user(pseudo,password,mail) VALUES (:pseudo,:password,:mail)');

      $req->execute(array('pseudo'=>$_POST['pseudo'],'password'=>$_POST['password'],'mail'=>$_POST['email']));
    }
    ?>
    </body>
</html>
