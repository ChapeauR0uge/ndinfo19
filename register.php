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
    </head>

    <body>
      <?php
        require 'utils.php';
        require 'db_connect.php' ;
        $db =  db_connect();
      ?>
      <nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
        <a class="navbar-brand" href="index.php">OuSuisJe</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="forum.php">Forum</a>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                if(isset($_SESSION['login']))
                {
                  echo $_SESSION['pseudo'];
                }
                else {
                  echo "Login";
                  /*echo "<a href='register.php'> Register</a>";*/
                }?>
                </a>
                <?php
                if(isset($_SESSION['login']))
                {?>
                <ul role="logout-dp" class="dropdown-menu dropdown-menu-right" >
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </ul>
                <?php }else{?>
                <ul role="login-dp" class="dropdown-menu dropdown-menu-right" >
                  <li>
          				<div class="text-center">Login</div>
          								 <form class="form" role="form" method="post" action="login.php" accept-charset="UTF-8" id="login-nav">
          										<div class="form-group">
          											 <label class="sr-only" for="examplePseudo">Pseudonyme</label>
          											 <input name="pseudo" class="form-control" id="examplePseudo" placeholder="Pseudonyme" required>
          										</div>
          										<div class="form-group">
          											 <label class="sr-only" for="exampleInputPassword1">Mot de Passe</label>
          											 <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de Passe" required>
          										</div>
          										<div class="form-group">
          											 <button name="ok" type="submit" class="btn btn-primary btn-block" value="ok">Se connecter</button>
          										</div>
          								 </form>

                        <div class="dropdown-divider"></div>
          							<div class="bottom text-center">
          								Nouveau ? <a href="register.php"><b>Rejoignez nous</b></a>
          							</div>

                </li>
                </ul>
              <?php } ?>
            </li>

          </ul>
        </div>
      </nav>
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
