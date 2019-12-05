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
