<?php
session_start();

use Reensq\plugin\lib\jQuery;

if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {

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
Head('Восстановление пароля | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<main id="main-form">
    <article class="wrapper">
        <?php if (!empty($err)) { ?><div class="search-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo array_shift($err); ?></div><?php } ?>
        <?php if (!empty($_SESSION['recg'])) { ?><div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $_SESSION['recg']; unset($_SESSION['recg']); ?></div><?php } else 
        {
        ?>
        <section class="row-glab">
            <div class="row-div">
                <div class="wrapper-form">
                    <!--<div class="wp-f-h1">
                        <i class="fas fa-sign-in-alt"></i>
                        Вход
                    </div>-->
                    <form enctype="multipart/form-data" action="/lost-password" id="sing-row" method="post" name="login">
                        <div class="form-in">
                            <div class="form-title">Восстановление пароля</div>
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
                        </div>

                        
                    </form>
                </div>
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

</body>
</html>
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>