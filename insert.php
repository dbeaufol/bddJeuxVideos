<?php
require_once('functions.php');

//Recherche si les champs son vides
$validate = true;
if($_POST['game_name'] == '' && $_POST['game_year'] == '' && $_POST['game_note'] == '')
{
   $validate = false;
}

//Connexion a la BDD
$db = connectToDb('0000','video_game');

//Recherche dans la table game le nom du jeu
$search_sql = "SELECT * FROM game WHERE name='" . strtolower($_POST['game_name']) . "'";
$search_result = mysqli_query($db, $search_sql);
if(mysqli_num_rows($search_result) !== 0)
{//Si le jeu existe
  session_start();
  $_SESSION['error_message'] = "Jeu deja existant, noob !";
  header("Location: index2.php");
}
else
{//Si le jeu n'existe pas
  $insert_sql ="INSERT INTO game (name,year,note,id_categorie) VALUES ('" . strtolower($_POST['game_name']) . "','" . $_POST['game_year'] . "','" . $_POST['game_note'] . "','" . $_POST['categorie_select'] . "')";
  if($validate == true)
  {
  $insert_result = mysqli_query($db,$insert_sql);
  }
  else
  {
    session_start();
    $_SESSION['error_message'] = "Vous devez remplir les champs";
    header("Location: index2.php");
    exit;
  }
  if($insert_result === TRUE)
  {//Pas d'erreur d'insertion
    $insert_intermediary_sql = "INSERT INTO game_editor (id_game,id_editor) VALUES ('" . mysqli_insert_id($db) . "','" . $_POST['editor_select'] . "')";
    $result = mysqli_query($db,$insert_intermediary_sql);

    session_start();
    $_SESSION['success_message'] = "Insertion du jeu " . $_POST['game_name'] . " effectuée";
    header("Location: index2.php");
  }
  else
  {//Erreur d'insertion
    session_start();
    $_SESSION['error_message'] = "Erreur d'insertion, noob !";
    header("Location: index2.php");
  }
}
//fermer la connexion a la BDD
disconnectDb($db);
