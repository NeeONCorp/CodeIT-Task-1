<?php include(ROOT . '/views/layouts/header.php') ?>

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-md-6 login">
                    <div class="card">
                        <h5 class="card-header">Авторизация</h5>
                        <div class="card-body">
                            <form action="#">
                                <input type="text" class="form-control"
                                       placeholder="Email или логин"
                                       name="identifier"
                                       maxlength="55">
                                <input type="password" class="form-control"
                                       placeholder="Пароль"
                                       name="password" maxlength="25">
                                <button class="btn btn-success"
                                        data-action="login">Войти
                                </button>
                            </form>

                            <p class="text-register ">
                                У Вас еще нету аккаунта? <a
                                        href="./registration">Создайте его</a>
                                сейчас.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php include(ROOT . '/views/layouts/footer.php') ?>