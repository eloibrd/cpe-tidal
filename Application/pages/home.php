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
        include('../components/header/header_connected.php');
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
                echo
                    '<section class="search_form_container">
                        <form class="search_container" action="Auth/login.php" method="post">
                            <input class="form_input" type="text" placeholder="Mot clé">
                        </form>
                        <div id="result"></div>
                    </section>';
        ?>
        <section class="pathologies_container">            
        </section>

    </section>
</body>
<script src="../JS/api_request.js"></script>
<script src="../JS/main.js"></script>
</html>
