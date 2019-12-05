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
        $db = db_connect();
      ?>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <?php
    if(isset($_SESSION['login']))
    {
      echo "connecte en tant que ".$_SESSION['pseudo'];
      echo "<a href='logout.php'>Logout</a>";
    }
    else {
      echo "<a href='login.php'>Login </a>";
      echo "<a href='register.php'> Register</a>";
    }?>
  </div>
</nav>
        <h1>Forum</h1>
        <?php
        /* AFFICHAGE DES TOPICS*/

          $req_topics = $db->prepare('SELECT * FROM topic');
          $req_topics->execute();
          echo "<ul>";
          while($donnee = $req_topics->fetch())
          {
            echo "<li>".$donnee['name']." | ".$donnee['author']." | Nombre de messages : ".$donnee['nb_message'];
            echo "<form method='POST' action='topic.php'>
            <input name='id_topic' type='hidden' value=".$donnee['id']."/>
            <input type='submit' value='Voir'/>
            </form>";
            echo "</li>";
          }
          echo "</ul>";
        ?>

        <h2>Poster un topic :</h2>

        <form method="post" target="forum.php">
          <input type="text" name="titre_topic"/>
          <textarea name="text_topic" rows="5" cols="33"></textarea>
          <input name="subpost" type="submit" value="Post"/>
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
