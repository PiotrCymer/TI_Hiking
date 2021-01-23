<html>
<head>
    <title>Profil użytkownika</title>


    <link href="/assets/css/bootstrap.css" rel="stylesheet">

    <link href="/assets/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/css/brands.css" rel="stylesheet">
    <link href="/assets/css/solid.css" rel="stylesheet">
    <link href="/assets/css/userProfile.css" rel="stylesheet">
    <?php foreach ($stylesheets as $k): ?>
        <link href="<?php echo $k; ?>" rel="stylesheet">
    <?php endforeach; ?>


</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/profil-uzytkownika"><i class="fas fa-hiking" style="font-size: 60px;"></i></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
            aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/profil-uzytkownika">Lista wędrówek</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/profil-uzytkownika/nowa-wedrowka">Dodaj wędrówkę</a>
            </li>
            <li class="nav-item">
                <a class="nav-link logoutBtn" href="#">Wyloguj się</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <h2>Witaj <?php echo $_SESSION['user']['name']; ?>!</h2>
            <?php if (count($this->userHiking) == 0): ?>
                <div class="alert alert-success text-center" role="alert">
                    Aktualnie nie posiadasz żadnych wędrówek
                </div>
            <?php else: ?>
                Liczba dodanych wędrówek: <?php echo count($this->userHiking); ?>
            <?php endif; ?>
        </div>
        <div class="col-md-9">
            <?php echo $content; ?>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/userProfile.js"></script>


<?php foreach ($scripts as $k => $v): ?>
    <?php foreach ($v as $src): ?>
        <?php if ($k == 'module'): ?>
            <script src="<?php echo $src; ?>" type="module"></script>
        <?php else: ?>
            <script src="<?php echo $src; ?>"></script>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
</body>
</html>
