<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acupuncture 3000</title>
    <link rel="stylesheet" href="../stylesheets/normalize.css">
    <link rel="stylesheet" href="../stylesheets/style.css">
    <link href='https://fonts.googleapis.com/css?family=Sora' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet'>
</head>

<body>
    <?php
        session_start();
        // alert($_SESSION);
        // print_r($_SESSION);
    ?>
    <?php 
    if($_SESSION){
        echo include('../components/header/header_connected.php');
    }
    else{
        echo '<component name="header"></component>';
        // echo include('header/header.html');
    }
    ?>
    <section class="main">
        <h2>Pathologies</h2>
        <?php
            if($_SESSION)
        if($_SESSION) 
            if($_SESSION)
            echo
                '<section class="search_form_container">
                    <input id="keywordSearch" class="form_input" type="text" placeholder="Mot clé">
                    <div id="autocompletion"></div>
                </section>';
        ?>
        <section id="pathologies_container" class="pathologies_container">
        <?php
            include '../../API/DatabaseDriver.php';
            $dbd = new DatabaseDriver;
            $keywordChosen = "aisselle";
            $pathos = $dbd->getAllPatho();
            foreach($pathos as $patho){
                echo('<div class="pathologie_card">');
                echo('<h3>'.ucfirst($patho->__get("desc")).'</h3>');
                echo('<p class="meridien">Méridien : '.$patho->__get("mer")->__get("nom").'</p>');
                echo('<p class="symptomes_title">Symptômes<span class="chevron down" onclick="showSymptomes(this)"></span></p>');
                echo('<ul class="sympthomes_container">');
                $i = 0;
                foreach($patho->__get("symptomes") as $symp){
                    echo('<li>'.$symp->__get("desc").'</li>');
                    if($i < count($patho->__get("symptomes")) - 1) echo('<hr>');
                    $i ++;
                }
                echo('</ul>');
                echo('</div>');
            }
        ?>                
        </section>

    </section>
</body>
<script src="../JS/api_request.js"></script>
<script src="../JS/main.js"></script>
</html>
