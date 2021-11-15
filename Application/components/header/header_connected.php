<link rel="stylesheet" href="../stylesheets/header/header.css">
<header>
    <a href="../../index.php">
        <h1 class="main_title">Acupuncture 3000</h1>
    </a>
    <nav>
        <p>Bonjour <?php echo $_SESSION['username'] ?> </p>
        <a href="../../Auth/logout.php">
            <button class="button">Deconnexion</button>
        </a>
    </nav>
</header>