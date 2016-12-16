<?php
//Fonction pour se connecter a la BDD
function connectToDb($pass,$database)
{
  return mysqli_connect('localhost','root', $pass , $database);
}
//Fonction pour se deconnecter a la BDD
function disconnectDb($db)
{
  return mysqli_close($db);
}
//Fonction pour les requétes a la BDD
function selectDataIntoDb($sql_request, $db)
{
  return mysqli_query($db,$sql_request);
}
//Fonction pour afficher les erreurs
function gestionErreurs()
{
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
}
//Fonction pour rechercher dans la BDD
function searchAllByCriteria($db,$criteria,$search)
{
  $request = "SELECT game.name game_name,game.year game_year,game.note game_note,categorie.content categorie_name,editor.name editor_name FROM game,categorie,game_editor,editor WHERE game.id_categorie = categorie.id AND game.id = game_editor.id_game AND editor.id = game_editor.id_editor AND $criteria = $search ORDER BY game.name ASC";
  return mysqli_query($db,$request);
}
