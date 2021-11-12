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

<body><?php
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
                    <form class="search_container" action="Auth/login.php" method="post">
                        <input class="form_input" type="text" placeholder="Mot clé">
                    </form>
                    <div id="result"></div>
                </section>';
        ?>
        <script>
            function getPathoByKeywords() {
                var keyword = document.getElementById("form_input").value ;
                const response = await fetch('http://localhost:80/API/api.php/pathologies/byKeyword/'+keyword)
                console.log('localhost:80/pathologies/byKeyword/'+keyword)
                const data = await response.json()
                data.forEach(patho => {
                    var patho_html = `
                    <div class="pathologie_card">
                    <h3>${patho.desc}</h3>
                    <p class="meridien">Méridien : ${patho.mer.nom}</p>
                    <p class="symptomes_title">Symptômes<span class="chevron down" onclick="showSymptomes(this)"></span></p>
                    <ul class="sympthomes_container">
                    `
                    var i =0 
                    patho.symptomes.foreach(sympt => {
                        patho_html+=`
                        '<li>${sympt.desc}</li>'
                        `
                        if(i<patho.symptomes.length -1){
                            patho_html+='<hr>'
                        }
                        i+=1
                    })
                    patho_html+=`</ul>
                        </div>`    
                })
                document.getElementById("pathologies_container").innerHTML = patho_html
            }
            document.getElementById('form_input').onkeydown = function(e){
                if(e.keyCode == 13){
                    getPathoByKeywords()
                }
            };

        </script>
        <section class="pathologies_container">
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
<script type="module" src="../JS/main.js"></script>
</html>
