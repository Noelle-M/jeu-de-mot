<?php
session_start();

if(!empty($_POST)){
    $reponse = $_POST['reponse'];
    $reponse_joueur = $_POST['reponse_joueur'];
    $id_question = $_POST['id_question'];
    $question = $_POST['question'];
    if($reponse === $reponse_joueur){
        $_SESSION['points'] = $_SESSION['points'] + 10;
        $_SESSION['questions'][$id_question][2] = "true";
    }else{
        $_SESSION['questions'][$id_question][2] = "false";
        $_SESSION['points'] = $_SESSION['points'] + 0;
    }
}

if(isset($_GET['action']) && $_GET['action'] =="passer"){
    $id_question = $_GET['idQ'];
    $_SESSION['questions'][$id_question][2] = "false";
    $reponse = '';
}
//supression de la question pour un affichage unique
unset($_SESSION['new_tab_questions'][$id_question]);

header('Location: ../index.php?action=start');