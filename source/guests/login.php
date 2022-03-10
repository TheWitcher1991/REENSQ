<?php

use Reensq\plugin\lib\jQuery;

if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {

    if (isset($_POST['logins'])) {

        $_POST  = jQuery::sanitize($_POST);

        $err = array();

        if (trim($_POST['username']) == '') $err[] = 'Введите имя!';
        if ($_POST['password'] == '') $err[] = 'Введите пароль!';
        if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';
        //if (!$_POST['g-recaptcha-response']) $err[] = 'Заполните капчу!';

        if (empty($err)) {

            $user = $_POST['username'];
            $password = $_POST['password'];
	
            $sql = "SELECT * FROM `users` WHERE `username` = :username";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':username', $user, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch();

            if ($row['username'] == true) {

                if (md5(md5($password . 'Zix4j$v0pN9odzU' . $user)) == $row['password']) {
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['avatar'] = $row['avatar'];
                    $_SESSION['email'] = $row['email'];
                    $mhsgl = "Вы успешно вошли на сайт, $_SESSION[username]! <a href='/'> Главная</a>";
                    if ($mhsgl) {
                        header('Location: /');
                        exit;
                    }
                } else {
                    $err[] = 'Извините, введённые вами имя или пароль неверны.';  
                }

            } else {
                    $err[] = 'Извините, введённые вами имя или пароль неверны.'; 
            }
        }
    }

    if(isset($_POST["reset"])) {

        $_POST  = jQuery::sanitize($_POST);

        $err = array();
        
        if ($_POST['email'] == "") $err[] = 'Введите Email!';
    
        if (!preg_match ($rules['email']['pattern'], $_POST['email'])) $err[] = 'Email указан неверно';
    
        if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';
        //if (!$_POST['g-recaptcha-response']) $err[] = 'Заполните капчу!';
        
    
        if (empty($err)) {
    
            $recaptcha = $_POST['g-recaptcha-response'];
    
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $key = '6LdkLZAUAAAAAGV8dQfz0EF6X_UMXIOXoIGSX-6o';
            $ip = $_SERVER['REMOTE_ADDR'];
            $capt_query = $url . '?secret=' . $key . '&response=' . $recaptcha . '&remoteip=' . $ip;
    
            $data = json_decode(file_get_contents($capt_query));
    
            $email = FormChars($_POST['email']);

            $sql = "SELECT * FROM `users` WHERE `email` = :email";
            $stmt = $PDO->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

    
            if($stmt->rowCount() <= 0) {
                $err[] = 'Email не найден!';
            } else {
                $row = $stmt->fetch();

                $code = random_str(30);
    
                $_SESSION["$code-recovery"] = array(
                    'type' => 'recovery',
                    'login' => $row['username'],
                    'id' => $row['id'],
                    'email' => $email,
                    'code' => $code,
                    'msg' => "На Вашу электронную почту был отправлен запрос на сброс пароля. Пожалуйста, следуйте инструкциям в письме."
                );
            
                send_mail($email, 'Восстановление пароля', $row['username'], 'Для сброса Вашего пароля на сайте <a target="_blank" href="https://reensq.breusav.ru/">REENSQ</a>, пройдите по нижеследующей ссылке. Это позволит Вам выбрать новый пароль.',
                    '', 'Восстановить', "https://reensq.breusav.ru/lost-passwords/confirm?code=$code&name=$row[username]&act=$row[id]");

                
                header("Location: lost-passwords/requested?code=$code");
                exit;

                //$mhsgl = "Отлично! Прочитайте письмо отправленое на $email";
    
                //if ($mhsgl) header("Location: /restore?id=$row[id]");
            }
        }
    }
?>
<?php 
Head('Вход | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Main (site content) -->
<main id="main-form">
    <article class="wrapper">
        <?php if (!empty($err)) { ?><div class="search-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo array_shift($err); ?></div><?php } ?>
        <?php if (!empty($mhsgl)) { ?><div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $mhsgl; ?></div><?php } ?>
        <section class="row-glab">
                <div class="row-div">
                    <div class="wrapper-form">
                        <!--<div class="wp-f-h1">
                            <i class="fas fa-sign-in-alt"></i>
                            Вход
                        </div>-->
                        <form enctype="multipart/form-data" action="/login" id="sing-row" method="post" name="login">
                            <div class="form-in">
                                <div class="form-title">
                                    Авторизация
                                </div>
                            <label for="log-l">
                                <span class="exp-title">
                                    Логин: <span>обязательно</span>
                                </span>
                                <input class="input" type="text" id="log-l" name="username" placeholder="" value="<? echo $_POST['username'] ?>" required>
                            </label>

                            <label for="pass-l">
                                <span class="exp-title">
                                    Пароль: <span>обязательно</span>
                                </span>
                                <input class="input" type="password" id="pass-l" name="password" placeholder="" value="<? echo $_POST['password'] ?>" required>
                                <span class="explain lost-passwor-bth"><a href="#">Забыли свой пароль?</a></span>
                            </label>

                            <label for="capt-l">
                                <span class="exp-title">
                                    Проверка: <span>обязательно</span>
                                </span>
                                <input class="input" type="text" id="capt-l" name="captcha" placeholder="<?php captcha_show() ?>" required>
                            </label>

                            <div class="form-submit">
                                <input style="margin: 0;" name="logins" type="submit" id="inp-dd-syb" value="Войти" placeholder="Войти">
                            </div>
                            </div>

                            <div class="form-add-info">
                                <span>Нет аккаунта? <a href="/register">Создать аккаунт</a></span>
                            </div>      
                        </form>
                    </div>
                </div>
        </section>
    </article>
</main>
<!-- /Main (site content) -->

<!-- Popup lost-password -->
<section id="main-popup-form">
    <div class="wrapper-form fpopup">
        <div class="avaU-title" style="padding: 16px">
                Восстановление пароля
                <i class="fas fa-times close-fpopup"></i>
            </div>
        <form enctype="multipart/form-data" action="/login" id="sing-row" method="post" name="lost-password">
            <div class="form-in" style="border-radius: 0 0 7px 7px">
                <label for="emails-l">
                                <span class="exp-title">
                                    Email почта: <span>обязательно</span>
                                </span>
                                <input class="input" type="email" id="emails-l" name="email" placeholder="" value="<? echo $_POST['email'] ?>" required>
                                <span class="explain">Укажите адрес электронной почты, который Вы использовали при регистрации.</span>
                            </label>

                            <label for="capt-l">
                                <span class="exp-title">
                                    Проверка: <span>обязательно</span>
                                </span>
                                <input class="input" type="text" id="capt-l" name="captcha" placeholder="<?php captcha_show() ?>" required>
                            </label>

                            <div class="form-submit">
                                <input name="reset" style="margin: 0;" type="submit" id="inp-dd-syb" value="Сбросить" placeholder="Сбросить">
                            </div>
                        </div></div>
        </form>
    </div>
</section>
<!-- /Popup lost-password -->


<!-- jQuery -->
<script type="text/javascript" src="/static/js/vendor/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/static/js/vendor/jQuery/plugin.js"></script>

<script type="text/javascript" src="/static/js/core.js"></script>
<script type="text/javascript" src="/static/js/ajax.js"></script>
<script type="text/javascript" src="/static/js/browser.js"></script>

<script type="text/javascript">
$(function () {
    $('.lost-passwor-bth').on('click', () => {
        $('#main-popup-form').addClass('main-popup-form-active');
        $('.fpopup').addClass('factive');
    });
    $('.close-fpopup').on('click', () => {
        $('#main-popup-form').removeClass('main-popup-form-active');
        $('.fpopup').removeClass('factive');
    });
});
</script>

</body>
</html>
<?php
} else {
    echo "<p style='margin: 50px 100px;'>Вы уже авторизированы на сайте!</p>";
}
?>