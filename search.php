<?php
require_once('functions.php');

//Connexion a la BDD
$db = connectToDb('0000','video_game');

//Recherche par nom||année||note||nom d'editeur||nom de categorie
$criteria = "";
switch ($_POST['search_select']) {
  case 'game_name':
    $criteria = 'game.name';
    $search = "'" . $_POST['search_data'] . "'";
    break;
  case 'game_year':
    $criteria = 'game.year';
    $search =  $_POST['search_data'];
    break;
  case 'game_note':
    $criteria = 'game.note';
    $search =  $_POST['search_data'];
    break;
  case 'game_editor':
    $criteria = 'editor.name';
    $search = "'" . $_POST['search_data'] . "'";
    break;
  case 'game_categorie':
    $criteria = 'categorie.content';
    $search = "'" . $_POST['search_data'] . "'";
    break;
  default:
    session_start();
    $_SESSION['error_message']= 'Critere de recherche tout pourri';
    header("Location: index.php");
}
if($criteria != "")
{//Si la variable criteria est remplie
  $result=searchAllByCriteria($db,$criteria,$search);
  $htmlString= "<table id=\"monTableau2\">
        <th id=\"t11\">Nom du jeu</th>
        <th id=\"t11\">Année de sortie</th>
        <th id=\"t11\">Note</th>
        <th id=\"t11\">Categorie</th>
        <th id=\"t11\">Editeur</th>";
  while($data = mysqli_fetch_assoc($result))
  {
    $htmlString.="<tr id=\"t22\"><td id=\"t22\">";
    $htmlString.=$data['game_name'] . "</td><td id=\"t22\">" . $data['game_year'] . "</td><td id=\"t22\">" . $data['game_note'] . "</td><td id=\"t22\">" . $data['editor_name'] . "</td><td id=\"t22\">" . $data['categorie_name'];
    $htmlString.="</td></tr>";
  }
  $htmlString.="</table>";
  session_start();
  $_SESSION['searchResult']= $htmlString;
  header("Location: index.php");
}
else
{//Si la variable criteria et vide
  session_start();
  $_SESSION['error_message']= 'Recherche inccorect';
  header("Location: index.php");
}
