<!DOCTYPE html>
<html>
    <head>
      <!-- En-tête de la page -->
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>OuSuisJe: Register</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <style>
      .divider-text {
        position: relative;
        text-align: center;
        margin-top: 15px;
        margin-bottom: 15px;
        }
        .divider-text span {
            padding: 7px;
            font-size: 12px;
            position: relative;
            z-index: 2;
        }
        .divider-text:after {
            content: "";
            position: absolute;
            width: 100%;
            border-bottom: 1px solid #ddd;
            top: 55%;
            left: 0;
            z-index: 1;
        }
      </style>
    </head>

    <body>
      <?php
        require 'utils.php';
        require 'db_connect.php' ;
        $db =  db_connect();
      ?>

    <div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<h4 class="card-title mt-3 text-center">Creation de compte</h4>
	<p class="divider-text">
        <span class="bg-light"/>
  </p>
	<form method="post" action="register.php">
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email address" id="exampleInputEmail1" type="email" required>
    </div> <!-- form-group// -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-pseudo"></i> </span>
		</div>
    	<input name="pseudo" class="form-control" placeholder="Pseudonyme" type="text" required>
    </div> <!-- form-group// -->
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe" required>
    </div> <!-- form-group// -->
    <div class="form-group">
        <button name="ok" type="submit" class="btn btn-primary btn-block" value="ok" > Créer le compte </button>
    </div> <!-- form-group// -->
</form>
</article>
</div> <!-- card.// -->
    <?php
    if(isset($_POST['ok']) && isset($_POST['password']) && isset($_POST['pseudo']) && isset($_POST['email']))
    {
      echo "passage formulaire ok";
      echo $_POST['pseudo'];
      $req = $db->prepare('INSERT INTO user(pseudo,password,mail) VALUES (:pseudo,:password,:mail)');

      $req->execute(array('pseudo'=>$_POST['pseudo'],'password'=>$_POST['password'],'mail'=>$_POST['email']));
        header("location:index.php");
    }
    ?>
    </body>
</html>
