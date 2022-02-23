<?php
session_start();
var_dump($_SESSION);
$reponse = $_POST['reponse'];
$reponse_joueur = $_POST['reponse_joueur'];
$id_question = $_POST['id_question'];
$question = $_POST['question'];


if($reponse === $reponse_joueur){
    $_SESSION['points'] = $_SESSION['points'] + 10;
}

if(isset($_SESSION['questions'])){
    array_push($_SESSION['questions'], $id_question);
}
else{
    $_SESSION['questions'] = [];
}

header('Location: ../index.php?start=true');
