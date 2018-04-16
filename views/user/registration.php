<?php include(ROOT . '/views/layouts/header.php') ?>

    <section id="register">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h5 class="card-header">Регистрация</h5>
                        <div class="card-body">
                            <form action="#">
                                <input type="text" class="form-control"
                                       placeholder="Логин" name="login"
                                       maxlength="20">

                                <input type="text" class="form-control"
                                       placeholder="Email" name="email"
                                       maxlength="55">

                                <input type="text" class="form-control"
                                       placeholder="Имя" name="name"
                                       maxlength="50">

                                <input type="password" class="form-control"
                                       placeholder="Пароль" name="password"
                                       maxlength="25">

                                <input type="text" class="form-control"
                                       placeholder="Дата рождения"
                                       id="datepicker"
                                       name="date_birth">

                                <select class="form-control" name="country">
                                    <option value="no-select">Выберете свою
                                        страну из списка
                                    </option>
                                    <?php foreach ($countriesArr as $country) { ?>
                                        <option value="<?php echo $country['id'] ?>">
                                            <?php echo $country['name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <p class="accept-rules">
                                    <input type="checkbox" id="chkb-rules"
                                           name="rules">
                                    <label for="chkb-rules" class="text">Я
                                        согласен с
                                        <a href="#">условиями использования</a>
                                        сайта.</label>
                                </p>

                                <button class="btn btn-success"
                                        data-action="create-account">Создать
                                    аккаунт
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include(ROOT . '/views/layouts/footer.php') ?>