<?php

session_start();

use Reensq\plugin\lib\jQuery;

if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {

if(isset($_POST["register"])) {

    $_POST  = jQuery::sanitize($_POST);

    $err = array();
  
    if (trim($_POST['username']) == '') $err[] = 'Введите имя!';
    if (!preg_match ($rules['username']['pattern'], $_POST['username'])) $err[] = $rules['username']['message'];
    if (strlen ($_POST['username']) < 3 or strlen ($_POST['username']) > 30) $err[] = $rules['username']['message_two'];
    if (trim($_POST['emails']) == '') $err[] = 'Введите почту!';
    if (!preg_match ($rules['email']['pattern'], $_POST['emails'])) $err[] = $rules['email']['message'];
    if ($_POST['password'] == '') $err[] = 'Введите пароль!';
    if (strlen ($_POST['password']) < 6) $err[] = $rules['password']['message'];
    if ($_POST['R-password'] == '') $err[] = 'Подтвердите пароли!';
    if ($_POST['password'] != $_POST['R-password']) $err[] = 'Пароли не совпадают!';
    if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';
    if ( $_POST['accept'] == '') $err[] = 'Вы должны согласиться с условиями!';

    if (empty($err)) {
        // обрабатываем капчу
    	$recaptcha = $_POST['g-recaptcha-response'];

    	$url = 'https://www.google.com/recaptcha/api/siteverify';
    	$key = '6LdkLZAUAAAAAGV8dQfz0EF6X_UMXIOXoIGSX-6o';
    	$ip = $_SERVER['REMOTE_ADDR'];
    	$capt_query = $url.'?secret='.$key.'&response='.$recaptcha.'&remoteip='.$ip;

    	$data = json_decode(file_get_contents($capt_query));

        // обрабатываем поля ввода
        $username = $_POST['username'];
        $username = FormChars($username);
        $username = mysqli_real_escape_string($link, $username);

        $email = $_POST['emails'];
        $email = FormChars($email);
        $email = mysqli_real_escape_string($link, $email);

        $password = $_POST['password'];
        $passE = $_POST['password'];
        $passE = mysqli_real_escape_string($link, $passE );
        $password = mysqli_real_escape_string($link, $password);
        $password = md5(md5(FormCharsPass($password . 'Zix4j$v0pN9odzU' . $username)));

        $sql = "SELECT `id` FROM `users` WHERE `username`=':username'";
        $stmtu = $PDO->prepare($sql);
        $stmtu->bindParam(':username', $username, PDO::PARAM_STR);
        $stmtu->execute();

        $sql_emal = "SELECT `id` FROM `users` WHERE `email`=':email'";
        $stmte = $PDO->prepare($sql_emal);
        $stmte->bindParam(':email', $email, PDO::PARAM_STR);
        $stmte->execute();

        $myrow = $stmtu->fetch();
        $myrow_emal = $stmte->fetch();

        if (!empty($myrow['id'])) {
            $err[] = 'Извините, введённое вами имя уже зарегистрировано. Введите другое имя';
        } else if (!empty($myrow_emal['id'])) {
            $err[] = 'Извините, введённая электронная почта уже зарегистрирована. Введите другую почту';
        } else {

            $avatar = 'avatar-default.jpg';


            $code = random_str(25);

            $_SESSION["$username-confirm"] = array(
                'type' => 'register',
                'login' => $username,
                'email' => $email,
                'code' => $code,
                'password' => $password,
                'avatar' => $avatar,
                'msg' => "На Вашу почту был отправлен запрос на подтверждения Вашего аккаунта. Пожалуйста, следуйте инструкциям в письме.",
            );

            send_mail(
                    $email,
                    'Подтверждение почты',
                    'новый пользователь!',
                    "Для подтверждения почты и окончательной регистрации на сайте <a target='_blank' href='https://reensq.breusav.ru/'>REENSQ</a>, 
                    пройдите по нижеследующей ссылке. <br /> Ваш ник: $username <br /> Ваш пароль: $passE  <br /> Не теряйте! ",
                    '', 'Подтверждение',
                    "https://reensq.breusav.ru/registers/confirm?name=$username&code=$code"
            );

            header("Location: /registers/requested?name=$username");
            exit;

        } 
    }
} 
        
?>
<?php 
Head('Регистрация | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<main id="main-form">
    <article class="wrapper">
        <?php if (!empty($err)) { ?><div class="search-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo array_shift($err); ?></div><?php } ?>
        <?php if (!empty($mhsgl)) { ?><div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $mhsgl; ?></div><?php } else 
        { 
        ?>
        <section class="row-glab">
                <div class="row-div">
                    <div class="wrapper-form">
                        <form enctype="multipart/form-data" action="/register" id="sing-row" method="post" name="login">
                            <div class="form-in">   
                                <div class="form-title">
                                    Регистрация
                                </div>
                                <label for="log-l">
                                    <span class="exp-title">
                                        Логин: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="text" id="log-l" name="username" placeholder="" value="<? echo $_POST['username'] ?>" required>
                                    <span class="explain">Это имя будет отображаться в Ваших сообщениях. Его нельзя будет поменять после регистрации.</span>
                                </label>

                                <label for="email-l">
                                    <span class="exp-title">
                                        Email почта: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="email" id="email-l" name="emails" placeholder="" value="<? echo $_POST['emails'] ?>" required>
                                    <span class="explain">На эту электронную почту будет выслано письмо для подтверждения аккаунта.</span>
                                </label>

                                <label for="pass-l">
                                    <span class="exp-title">
                                        Пароль: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="password" id="pass-l" name="password" placeholder="" value="<? echo $_POST['password'] ?>" required>
                                </label>

                                <label for="r-pass-l">
                                    <span class="exp-title">
                                        Подтвердить пароль: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="password" id="r-pass-l" name="R-password" placeholder="" value="<? echo $_POST['R-password'] ?>" required>
                                </label>

                                <label for="capt-l">
                                    <span class="exp-title">
                                        Проверка: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="text" id="capt-l" name="captcha" placeholder="<?php captcha_show() ?>" required>
                                </label>

                                <label class="iconic" for="check-acc">
                                    <input type="checkbox" id="check-acc" name="accept" value="1" required>
                                    <i style="margin-right:3px;cursor:pointer" aria-hidden="true"></i>
                                    Я согласен(-на) с <a style="color: #1ed79d;margin:0" href="/threads?f=2&act=5">условиями</a> использования.
                                </label>

                                <div class="form-submit">
                                    <input style="margin: 0;" name="register" type="submit" id="inp-dd-syb" value="Регистрация" placeholder="Регистрация">
                                </div>
                            </div>

                            <div class="form-add-info">
                                <span>Уже имеете аккаунт? <a href="/login">Войти в свой аккаунт</a></span>
                            </div>                            
                        </form>
                    </div
                </div>
        </section>
        <?php
        }
        ?>
    </article>
</main>

<!-- jQuery -->
<script type="text/javascript" src="/static/js/vendor/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/static/js/vendor/jQuery/plugin.js"></script>

<script type="text/javascript" src="/static/js/core.js"></script>
<script type="text/javascript" src="/static/js/ajax.js"></script>
<script type="text/javascript" src="/static/js/browser.js"></script>

<script type="text/javascript">
    function getFileName () {

        let file = $('#file-l').val();

        file = file.replace(/\\/g, '/').split('/').pop();

        $('#file-name').html(file);

    }
</script>
</body>
</html>
<?php
} else {
    echo "<p style='margin: 50px 100px;'>Для регистрации выйдете с аккаунта!</p>";
}
?>
