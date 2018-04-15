<?php include(ROOT . '/views/layouts/header.php') ?>

    <section id="account">
        <div class="container">
            <div class="row">
                <div class="col-md-5 account">
                    <div class="card">
                        <h5 class="card-header">Ваш
                            профиль, <?php echo $user['name'] ?>!</h5>
                        <div class="card-body">
                            <p>Email: <?php echo $user['email'] ?></p>

                            <a href="./account/logout">
                                <button class="btn btn-success">Покинуть профиль</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include(ROOT . '/views/layouts/footer.php') ?>