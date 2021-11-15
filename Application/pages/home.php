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
        <section class="search_form_container">
            <h2>Filtre</h2>
            <form class="search_container" method="post" onsubmit="return false">
                <label class="formLabel" for="mer">Méridien</label>
                <select class="form_input" name="mer" id="mer" placeholder="méridien">
                    <option value="rien">Selectionez un méridien</option>
                    <option value="Coeur">Coeur</option>
                    <option value="Chong Mai">Chong Mai</option>
                    <option value="Dai Mai">Dai Mai</option>
                    <option value="Du Mai">Du Mai</option>
                    <option value="Estomac">Estomac</option>
                    <option value="Foie">Foie</option>
                    <option value="Gros intestin">Gros intestin</option>
                    <option value="Intestin Grêle">Intestin Grêle</option>
                    <option value="Protecteur du coeur">Protecteur du coeur</option>
                    <option value="Poumon">Poumon</option>
                    <option value="Yang Qiao Mai">Yang Qiao Mai</option>
                    <option value="Yin Qiao Mai">Yin Qiao Mai</option>
                    <option value="Rein">Rein</option>
                    <option value="Ren Mai">Ren Mai</option>
                    <option value="Rate Pancréas">Rate Pancréas</option>
                    <option value="Triple réchauffeur">Triple réchauffeur</option>
                    <option value="Vessie">Vessie</option>
                    <option value="Vésicule Biliaire">Vésicule Biliaire</option>
                    <option value="Yang Wei Mai">Yang Wei Mai</option>
                    <option value="Yin Wei Mai">Yin Wei Mai</option>
                </select>
                <?php
                    if($_SESSION){
                        ?>
                            <label class="formLabel" for="keywordSearch">Recherche</label>
                            <input class="form_input" name='keywordSearch' id="keywordSearch" type="text" placeholder="Mot clé" autocomplete="off">
                        <?php
                    }
                ?>
            </form>
            <ul id="autocompletion"></ul>
        </section>
        <h2>Pathologies</h2>
        <section class="pathologies_container" id='pathologies_container'>            
        </section>
    </section>
</body>
<script src="../JS/api_request.js"></script>
<script src="../JS/main.js"></script>

</html>
