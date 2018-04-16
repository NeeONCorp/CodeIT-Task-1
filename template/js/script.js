$App = {

    _do: {
        createAccount: function ($button) {
            $error = false;
            $data = {};
            $form = $($button).parents('form');

            $form.find('input, select').each(function () {
                $name = $(this).attr('name');
                $elType = $(this).attr('type');
                $elTag = $(this).prop('tagName');

                if (($elTag === 'INPUT' && $elType === 'text') || ($elTag === 'INPUT' && $elType === 'password')
                    || $elTag === 'SELECT') {
                    $data[$name] = $(this).val();
                }

                if ($elTag === 'INPUT' && $elType === 'checkbox') {
                    $data[$name] = $(this).prop('checked');
                }
            });

            if($form.find('select[name="country"]').val() === 'no-select') {
                swal("Упис, ошибка!", "Выберете свою страну из списка.", "error");
                $error = true;
            }

            if($error === false) {
                // Отправляем ajax запрос
                $.post('./ajax/registration', $data, onAjaxSuccess);

                function onAjaxSuccess(response) {
                    if (response === 'success') {
                        swal("Отлично!", "Вы зарегистрировались в системе.", "success").
                        then((value) => {
                            window.location.href = './account';
                        });
                    } else {
                        swal("Упис, ошибка!", response, "error");
                    }
                }
            }
        },

        login: function($button) {
            $data = {};
            $form = $($button).parents('form');

            $data['identifier'] = $form.find('input[name="identifier"]').val();
            $data['password'] = $form.find('input[name="password"]').val();

            $.post('./ajax/login', $data, onAjaxSuccess);

            function onAjaxSuccess (response) {
                if(response === 'success') {
                    window.location.href = './account';
                } else {
                    swal({
                        icon: "error",
                        title: "Упс, ошибка!",
                        text: response,
                    });

                    $('input[name="password"]').val('');
                }
            }
        }
    },

    pluginActive: function () {

        // Регистрация
        if ($('section#register').length) {

            // Выбор даты
            $('#datepicker').datepicker({
                maxDate: function() {
                    var date = new Date();
                    date.setDate(date.getDate());
                    return new Date(date.getFullYear(), date.getMonth(), date.getDate());
                },

                format: 'dd/mm/yyyy',
                uiLibrary: 'bootstrap4',
                header: true,
                modal: true,
                footer: true,
            });

            $('.gj-modal .modal-footer button:eq(1)').removeClass('btn-default').addClass('btn-success');

            // Чекбокс
            $('#chkb-rules').checkbox();
        }

    },

    event: function () {
        // Регистрация - выбор даты
        $('#register input#datepicker').on('change paste input keyup keypress', function (e) {
            return false;
        });

        $datepickerOpen = false;

        $('#register input#datepicker').focus(function () {
            $parent = $(this).parent();

            $button = $parent.find('button');

            $button.click();

            $(this).blur();

            if(!$datepickerOpen) {
                $('.gj-picker').find('[role=period]').click().click();
                $('.gj-picker').find('.chevron-left').click().click();

                $datepickerOpen = true;
            }
        });

        // Регистрация - создать аккаунт
        $('#register form').find('[data-action="create-account"]').on('click', function (e) {
            e.preventDefault();
            $App._do.createAccount(this);
            return false;
        });

        // Авторизация
        $('#login form').find('[data-action="login"]').on('click', function (e) {
            e.preventDefault();
            $App._do.login(this);
            return false;
        });
    },

    init: function () {
        $App.event();
        $App.pluginActive();
    }
};

$App.init();