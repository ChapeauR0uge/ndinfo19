<!DOCTYPE html>
<html>
    <head>
      <!-- En-tête de la page -->
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>OuSuisJe: Forum</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->

      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </head>

    <body>
      <?php session_start(); ?>
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
      <?php
        require 'utils.php';
        require 'db_connect.php' ;
        $db = db_connect();

        $req_titre = $db->prepare("SELECT * FROM topic WHERE id = :id");
        if(isset($_GET['id_topic']))
        {
          $req_titre->execute(array("id"=>$_GET['id_topic']));
        }
        else {
          $req_titre->execute(array("id"=>$_POST['id_topic']));
        }
        $donnee=$req_titre->fetch();
        $id_topic = $donnee['id'];
        $nb_message= $donnee['nb_message'];
        echo "<h1>".$donnee['name']."</h1>";

        $req = $db->prepare("SELECT * FROM post WHERE id_topic=:idtopic");
        if(isset($_GET['id_topic']))
        {
          $req->execute(array("idtopic"=>$_GET['id_topic']));
        }
        else {
          $req->execute(array("idtopic"=>$_POST['id_topic']));
        }
        echo "<table class='table'>";
        echo "  <thead class='thead-light'>
                <tr>
                  <th scope='col'>Auteur</th>
                  <th scope='col'>Message</th>
                </tr>
                </thead>
                 <tbody>";
        while($donnee = $req->fetch())
        {
          echo "<tr scope='row'>";
          echo "<td>".$donnee['author']."</td>";
          echo "<td>".$donnee['content']."</td>";
          echo "</tr>";
        }
        echo " </tbody></table>";
      ?>
      <h2>Poster un message :</h2>

      <form method="post" action="topic.php">
        <textarea name="text_post" rows="5" cols="33"></textarea>
        <input name='id_topic' type='hidden' value="<?php echo $id_topic ?>"/>
        <input name="subpost" type="submit" value="Post"/>
      </form>

      <?php
      if(isset($_POST['subpost']))
      {
        echo "passage formulaire ok";

        $req3 = $db->prepare('INSERT INTO post(id_topic,author,content) VALUES (:id_topic,:author,:content)');
        $req3->execute(array('id_topic'=>$_POST['id_topic'],'content'=>$_POST['text_post'],'author'=>$_SESSION['pseudo']));

        $req4 = $db->prepare('UPDATE topic SET nb_message=:nb_message WHERE id = :id_topic');
        $req4->execute(array('nb_message'=>$nb_message+1,'id_topic'=>$id_topic));
        header("location:topic.php?id_topic=".$id_topic);
      }
      ?>
    </body>
</html>
