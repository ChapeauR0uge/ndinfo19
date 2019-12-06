<!DOCTYPE html>
<html>
    <head>
        <!-- En-tête de la page -->
        <meta charset="utf-8" />
        <title>PatateSautee</title>
        <link rel="stylesheet" type="text/css" href="source/style.css" media="all"/>
    </head>

    <body>
      <?php
        session_start();
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
        echo "<h1>".$donnee['name']."</h1>";

        $req = $db->prepare("SELECT * FROM post WHERE id_topic=:idtopic");
        if(isset($_GET['id_topic']))
        {
          $req->execute(array("idtopic"=>$_GET['id_topic']));
        }
        else {
          $req->execute(array("idtopic"=>$_POST['id_topic']));
        }
        while($donnee = $req->fetch())
        {
          echo "<ul>";
          echo "<li>Auteur :".$donnee['author']."</li>";
          echo "<li>".$donnee['content']."</li>";
          echo "</ul>";
        }
      ?>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="forum.php">Forum</a>
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

        header("location:topic.php?id_topic=".$id_topic);
      }
      ?>
    </body>
</html>
