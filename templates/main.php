<html>
<head>
    <title>Hiking test page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link href="./assets/css/fontawesome.css" rel="stylesheet">
    <link href="./assets/css/brands.css" rel="stylesheet">
    <link href="./assets/css/solid.css" rel="stylesheet">
    <?php foreach ($stylesheets as $k): ?>
        <link href="<?php echo $k; ?>" rel="stylesheet">
    <?php endforeach; ?>


</head>
<body>
<?php echo $content; ?>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
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
