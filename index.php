<?php
session_start();
include "includes/questions.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.6.0/cosmo/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- timer -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timecircles/1.5.3/TimeCircles.min.js" integrity="sha512-FofOhk0jW4BYQ6CFM9iJutqL2qLk6hjZ9YrS2/OnkqkD5V4HFnhTNIFSAhzP3x//AD5OzVMO8dayImv06fq0jA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="assets/functions.js"></script>

    <title>Jeu de mots</title>
</head>

<body>
    <header class="bg-dark w-100 p-4 text-white">
        <h1 class="text-center mt-5">Jeu de mots</h1>
    </header>
    <main class="w-50 ml-auto mr-auto mb-5">
        
        <?php
        if(!isset($_GET['timeOut'])){
            if(!isset($_GET['start'])){
                ?>
                <h2 class="mt-5">Régles du jeu</h2>
                <p class="mt-5 mb-5">
                    En cliquant sur "Commencer", le compte à rebours est lancé.
                    <br>Le but du jeu est de répondre à un maximum de questions dans le temps imparti. Celles-ci sont générées aléatoirement. 
                    Pour valider votre réponse, appuyez sur la touche "Entrée" <img src="assets/2022-02-23_15h21_46.png" height="40"> de votre clavier.<br>
                    Si vous répondez juste, le jeu passe à la suivante. Si vous êtes bloqué sur une question, vous pouvez passer à la suivante en cliquant sur le bouton correspondant.
                    <br>
                    10 questions, 60 secondes par question. Si le compte à rebours arrive à 0 avant que vous ayez répondu, le jeu s'arrête et on compte les points.
                    <br>
                    <strong>A vos marques, prêt...</strong>
                </p>
                <button type="button" class="btn btn-success w-100" id="submited" onclick="start()">partez !</button>
            <?php
            }
           
            if(isset($_SESSION['questions'])){
                $count_sessions_questions = count($_SESSION['questions']);
            }else{
                $count_sessions_questions = 0;
            }
            
            if(isset($_GET['start'])){
                ?>
                <p>
                    <button class="btn btn-light mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" aria-controls="collapseWidthExample">
                    <h2>Régles du jeu <img src="assets/flechebas.png" height="20"></h2>
                    </button>
                </p>
                <div class="collapse collapse-horizontal" id="collapseWidthExample">
                    <div class="card card-body w-100">
                        <p class="mt-5 mb-5">
                            En cliquant sur "Commencer", le compte à rebours est lancé.
                            <br>Le but du jeu est de répondre à un maximum de questions dans le temps imparti. Celles-ci sont générées aléatoirement.
                            Pour valider votre réponse, appuyez sur la touche "Entrée" <img src="assets/2022-02-23_15h21_46.png" height="40"> de votre clavier.<br>
                            Si vous répondez juste, le jeu passe à la suivante. Si vous êtes bloqué sur une question, vous pouvez passer à la suivante en cliquant sur le bouton correspondant.
                            <br>
                            10 questions, 60 secondes par question. Si le compte à rebours arrive à 0 avant que vous ayez répondu, le jeu s'arrête et on compte les points.
                        </p>
                    </div>
                </div>
                <hr>

                <div class="shadow p-4">
                    <table class="table w-50 text-center">
                        <thead>
                            <tr>
                                <th>Points</th>
                                <th>Temps restant</th>
                                <th>Bonnes réponses</th>
                                <th>sur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> 
                                    <?php 
                                    if(isset($_SESSION['points'])){
                                        echo $_SESSION['points'];
                                    }else{
                                        $_SESSION['points'] = 0;
                                        echo 0;
                                    }?>
                                </td>
                                <td>
                                    <div onload="timer">
                                        <div id="secondes"></div></span>
                                    <div>
                                </td>
                                <td>
                                    <?php
                                    if(isset($count_sessions_questions)){
                                        echo $_SESSION['points'] / 10;
                                    }else{
                                        echo 0;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if(isset($_SESSION['questions'])){
                                        $count_sessions_questions = count($_SESSION['questions']) +1;
                                        echo $count_sessions_questions;
                                    }else{
                                        echo 0;
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                    $count_questions = count($questions);
                    $lance_le_jeu = 0;
                    foreach($questions as $question){
                        $rand_question = array_rand($questions,1);
                        $id_question = $rand_question;
                        $question = $questions[$id_question][0];
                        $reponse = $questions[$id_question][1];
                        //si la question est déjà dans session
                        if(isset($_SESSION['questions'][$id_question])){
                            //on passe à la suivante
                            $id_question++;
                            //si on est arrivé au bout du tableau + 1
                            if($id_question === $count_questions +1){
                                //on repart à zéro
                                $id_question = 0;
                            }
                            if($count_questions === $count_sessions_questions){$lance_le_jeu = 2;}
                            else{$lance_le_jeu = 1;}
                        }
                        else{$lance_le_jeu = 1;}
                    }
                }
                if(isset($lance_le_jeu) && $lance_le_jeu === 1){
                    ?>
                    <p>Question : <?= $question ?></p>
                    <p>Réponse : <?= $reponse ?></p>

                    <form method="post" action="includes/traitement.php" class="row mt-5 mb-5" 
                    onkeyup="return verifForm()" onsubmit="return verifForm()">
                        <div class="col-8">
                            <input id="reponse_joueur" type="text" name="reponse_joueur" class="w-100 shadow p-3 h-100 input_reponse" 
                            placeholder="<?= substr($reponse,0,1) ?>" autofocus/>
                            <input id="reponse" type="hidden" name="reponse" value="<?= $reponse ?>" style=""/>
                            <input type="hidden" name="question" value="<?= $question ?>" />
                            <input type="hidden" name="id_question" value="<?= $id_question ?>" />
                            <button type="submit" name="submit" hidden></button>
                        </div>
                        <div class="col-2 p-0 m-0">
                            <button type="button" name="resetAll" class="btn btn-primary w-100 h-100" onclick="start()">Passer</button>
                        </div>
                        <div class="col-2 p-0 m-0">
                            <a href="index.php?timeOut=true">
                                <button type="button" class="mb-3 text-center btn btn-danger w-100 h-100">Annuler</button>
                            </a>
                        </div>
                    </form>
                    <?php
                }elseif(isset($lance_le_jeu) && $lance_le_jeu === 2){
                    echo "This is end lalala lalala";
                }
        }else{
            ?>
            <div class="card shadow w-75 ml-auto mr-auto p-3 mt-5">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Points</th>
                            <th>Temps restant</th>
                            <th>Bonnes réponses</th>
                            <th>sur</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> 
                                <?php 
                                if(isset($_SESSION['points'])){
                                    echo $_SESSION['points'];
                                }else{
                                    $_SESSION['points'] = 0;
                                    echo 0;
                                }?>
                            </td>
                            <td>
                                <p>Terminé !</p>
                            </td>
                            <td>
                                <?= $_SESSION['points'] / 10 ?>
                            </td>
                            <td>
                            <?php
                                if(isset($_SESSION['questions'])){
                                    $count_sessions_questions = count($_SESSION['questions']) +1;
                                    echo $count_sessions_questions . " question(s)";
                                }else{
                                    echo 0 . " question(s)";
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="includes/unset-session.php"><div class="mb-3 text-center btn btn-danger w-100">Rejouer</div></a>
            </div>
            <?php
        }
        ?>
        </div>
        <hr>
        <div class="reponses_affichees">
                <?php
                var_dump($_SESSION);
                ?>
            </div>
        
    </main>
    <footer class="p-4 text-center text-white bg-dark">
        Noëlle
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>