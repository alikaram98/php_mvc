<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome</title>
<style>
    header {
        background-color: lightgreen;
        padding :20px;
        width: 80vw;
        margin: 20px auto;

        a {
            text-decoration: none;
            color:orangered;
        }
    }

    main {
        text-align:center;
        width: 30vw;
        margin:auto;
    }
</style>
</head>

<body>
    <header>
        <?php if ($auth->check()): ?>
            <a href="#">Hi <?= html($auth->user()->name) ?></a>
            <a href="<?= $router->urlFor('dashboard') ?>">Dashboard</a>
        <?php else: ?>
            <a href="<?= $router->urlFor('login') ?>">login</a>
            <a href="<?= $router->urlFor('register') ?>">register</a>
        <?php endif; ?>
    </header>
    <main>
        <h1>welcome page</h1>
    </main>
</body>

</html>