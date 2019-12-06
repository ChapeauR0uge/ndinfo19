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

      <?php
        session_start();
        require 'utils.php';
        require 'db_connect.php' ;
        $db = db_connect();
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
      <h1>Forum</h1>
      <?php
      /* AFFICHAGE DES TOPICS*/

        $req_topics = $db->prepare('SELECT * FROM topic');
        $req_topics->execute();
        echo "<table class='table'>";
        echo "  <thead>
                <tr>
                  <th scope='col'>Auteur</th>
                  <th scope='col'>Titre</th>
                  <th scope='col'>Message</th>
                  <th scope='col'></th>
                </tr>
                </thead>
                 <tbody>";
        while($donnee = $req_topics->fetch())
        {
          echo "<tr scope='row'>";
          echo "<td>".$donnee['author']."</td>";
          echo "<td>".$donnee['name']."</td>";
          echo "<td>".$donnee['nb_message']."</td>";
          echo "<td>";
          echo "<form method='POST' action='topic.php'>
          <input name='id_topic' type='hidden' value=".$donnee['id']."/>
          <input type='submit' value='Voir'/>
          </form>";
          echo "</td>";
          echo "</tr>";
        }
        echo " </tbody></table>";
      ?>

      <h2>Poster un topic :</h2>
      <form method="post" target="forum.php">
        <input type="text" name="titre_topic" placeholder="Titre"/>
      </br>
        </br>
        <textarea name="text_topic" rows="5" cols="33"></textarea>
      </br>  </br>
        <input name="subpost" type="submit" value="Poster"/>
      </form>

      <?php
        if(isset($_POST['subpost']))
        {
          echo "passage formulaire ok";
          $req = $db->prepare('INSERT INTO topic(name,author,nb_message) VALUES (:name,:author,1)');

          $req->execute(array('name'=>$_POST['titre_topic'],'author'=>$_SESSION['pseudo']));

          $req2 = $db->prepare("SELECT MAX(id) as max_id from topic");
          $req2->execute();
          $donnee = $req2->fetch();
          $max_id = $donnee['max_id'];

          $req3 = $db->prepare('INSERT INTO post(id_topic,author,content) VALUES (:id_topic,:author,:content)');
          $req3->execute(array('id_topic'=>$max_id,'content'=>$_POST['text_topic'],'author'=>$_SESSION['pseudo']));

          header("location:forum.php");
        }
        ?>


    </body>
</html>
