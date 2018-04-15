<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="icon" href="./template/img/icon.png" sizes="32x32"/>

    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="./template/libs/gijgo/css/gijgo.min.css">

    <link rel="stylesheet" href="./template/styles/style.css">

    <title><?php echo self::$page['title'] ?> - Web Application</title>
</head>
<body>

<div id="wrapper">
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">

                <button class="navbar-toggler" type="button"
                        data-toggle="collapse"
                        data-target="#navbarColor03"
                        aria-controls="navbarColor03"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarColor03">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./">Главная</a>
                        </li>

                        <?php if (self::$isGuest) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="./registration">Регистрация</a>
                            </li>
                        <?php } ?>
                    </ul>


                    <div class="form-inline my-2 my-lg-0 form-right">
                        <?php if (self::$isGuest) { ?>
                            <a href="./login">
                                <button type="button"
                                        class="btn btn-outline-light"><i
                                            class="material-icons">perm_identity</i>
                                    Войти
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="./account">
                                <button type="button"
                                        class="btn btn-outline-light"><i
                                            class="material-icons">perm_identity</i>
                                    Профиль
                                </button>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div id="content">