<?php
require_once('functions.php');

//Gestion des errreurs
gestionErreurs();

//Connexion a la BDD
$db = connectToDb('0000','video_game');

//Recherche dans la table categorie
$categorie_result = selectDataIntoDb("SELECT * FROM categorie",$db);

//Recherche dans la taable editor
$editor_result = selectDataIntoDb("SELECT * FROM editor",$db);

//Récupérer et afficher les infos de la BDD
$request = "SELECT game.name game_name,game.year game_year,game.note game_note,categorie.content categorie_name,editor.name editor_name FROM game,categorie,game_editor,editor WHERE game.id_categorie = categorie.id AND game.id = game_editor.id_game AND editor.id = game_editor.id_editor ORDER BY game.name ASC";
$getAllGames = selectDataIntoDb($request,$db);

//fermer la connexion a la BDD
disconnectDb($db);

?>
<!-- HTML page utilisateur -->
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="style.css"/>
    <meta charset="utf-8">
    <title>Jeu-video</title>
  </head>
  <body>
    <h3 id="h3">Bienvenue sur ma base de donnée des jeux vidéos</h3>
    <?php
    session_start();
    if(isset($_SESSION['error_message']))
    {
      echo "<h2>" . $_SESSION['error_message'] . "</h2>";
      unset($_SESSION['error_message']);
    }

    if(isset($_SESSION['success_message']))
    {
      echo "<h2>" . $_SESSION['success_message'] . "</h2>";
      unset($_SESSION['success_message']);
    }
     ?>
    <form action="insert.php" method="post">
      <p id="monP">Categorie:
      <select name="categorie_select">
        <?php
        while($data = mysqli_fetch_assoc($categorie_result))
        {
          echo "<option value='" . $data['id'] . "'>" . $data['content'] . "</option>";
        }
        ?>
      </select>
      Editeur:
      <select name="editor_select">
        <?php
        while($data = mysqli_fetch_assoc($editor_result))
        {
          echo "<option value='" . $data['id'] . "'>" . ucfirst($data['name']) . "</option>";
        }
        ?>
      </select>

      <label name="game_name">Nom du jeu:</label>
      <input type="text" name="game_name">

      <label name="game_year">Année de sortie:</label>
      <input type="number" name="game_year" min="1950" max="3000">

      <label name="game_note">Note:</label>
      <input type="number" name="game_note" min="0" max="100">

      <input type="submit" value="Créer">
      </p>
    </form>
    <br/>
    <form action="search.php" method="post">
      <select name="search_select">
        <option value="game_name">Nom du jeu</option>
        <option value="game_year">Année de sortie</option>
        <option value="game_note">Note du jeu</option>
        <option value="game_editor">Editeur</option>
        <option value="game_categorie">Categorie</option>
      </select>
      <input type="text" name="search_data">
      <input type="submit" value="Rechercher">
    </form>
    <br/>
    <?php
    if(isset($_SESSION['searchResult']))
    {
      echo $_SESSION['searchResult'];      
    }
     ?>
    <br/>
    <?php if (isset($_SESSION['searchResult']))
      {
      echo '<div style="diplay: none; visibility: hidden;" >';
      unset($_SESSION['searchResult']);
      }
      else
      {
      echo '<div>';
      } ?>
    <table id="monTableau">
      <th id="t1">Nom du jeu</th>
      <th id="t1">Année de sortie</th>
      <th id="t1">Note</th>
      <th id="t1">Categorie</th>
      <th id="t1">Editeur</th>
      <?php
      while($data = mysqli_fetch_assoc($getAllGames))
      {
        $return = '<tr id="t2">';
        $return .= '<td id="t2">' . ucfirst($data['game_name']) . '</td>';
        $return .= '<td id="t2">' . ucfirst($data['game_year']) . '</td>';
        $return .= '<td id="t2">' . ucfirst($data['game_note']) . '</td>';
        $return .= '<td id="t2">' . ucfirst($data['categorie_name']) . '</td>';
        $return .= '<td id="t2">' . ucfirst($data['editor_name']) . '</td>';
        $return .= '</tr>';
        echo $return;
      }
      ?>
    </table>
  </div>
  </body>
</html>
