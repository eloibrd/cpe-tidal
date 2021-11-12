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
    if ($_SESSION) {
        include('../components/header/header_connected.php');
    } else {
        echo '<component name="header"></component>';
    }
    ?>
    <section class="main">
        <h2>Pathologies</h2>
        <?php
        if ($_SESSION) { ?>
            <section class="search_form_container">
                <input id="keywordSearch" class="form_input" type="text" placeholder="Mot clé">
                <div id="autocompletion"></div>
            </section>
        <?php } ?>
        <section id="pathologies_container" class="pathologies_container">
        </section>
    </section>
</body>
<script src="../JS/api_request.js"></script>
<script src="../JS/main.js"></script>

</html>
