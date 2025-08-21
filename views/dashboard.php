<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            padding:0;
            margin:0;
        }

        body { 
            background-color: bisque;
        }
        .wrapper {
            background-color: #a08216ff;
            text-align: center;
            width: 500px;
            margin: 30px auto;
            border-radius: 20px;
            line-height: 3rem;
            
            button {
                padding: 10px;
            }            
        }
    </style>
</head>
<body>
<div class="wrapper">
   <h3>Dashboard page</h3> 
   <form method="POST" action="<?= $router->urlFor('logout') ?>">
    <?= $csrf['fields'] ?>
    <button>Logout</button>
   </form>
</div>
</body>
</html>