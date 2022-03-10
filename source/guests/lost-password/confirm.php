<?php
session_start();

use Reensq\plugin\core\R;
use Reensq\plugin\lib\jQuery;

$GetNameR = $_GET['name'];
$GetCodeR = $_GET['code'];

if (isset($_SESSION["$GetCodeR-recovery"])) {

    if (isset($_POST['confcod'])) {

        $_POST  = jQuery::sanitize($_POST);

        #if ($_SESSION['recovery']['type'] == 'recovery') {
    
            $err = array();
    
            //if ($_SESSION['recovery']['code'] != $_POST['code']) $err[] = 'Код указан неверно!';
    
            if ($_POST['password'] == '') $err[] = 'Введите пароль!';
            
            if (strlen ($_POST['password']) < 6) $err[] = 'Пароль должен быть не меньше 6 символов';
    
            if ($_POST['password'] != $_POST['r-password']) $err[] = 'Пароли не совпадают!';
    
            if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';
            
            //if (!$_POST['g-recaptcha-response']) $err[] = 'Заполните капчу!';
            
            
            if (empty($err)) {
    
                $recaptcha = $_POST['g-recaptcha-response'];
    
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $key = '6LdkLZAUAAAAAGV8dQfz0EF6X_UMXIOXoIGSX-6o';
                $ip = $_SERVER['REMOTE_ADDR'];
                $capt_query = $url . '?secret=' . $key . '&response=' . $recaptcha . '&remoteip=' . $ip;
    
                $data = json_decode(file_get_contents($capt_query));
    
                $email = $_SESSION['recovery']['email'];
                $id = $_SESSION['recovery']['id'];
                $username = $_SESSION['recovery']['login'];
                $password = $_POST['password'];

                $password = md5(md5(FormCharsPass($password . 'Zix4j$v0pN9odzU' . $username)));

                $sql = "UPDATE `users` SET `password` = :pass WHERE `username` = :uname";
                $stmt = $PDO->prepare($sql);
                $stmt->bindValue(':pass', $password);
                $stmt->bindValue(':uname', $username);
                $stmt->execute();


                $rows = R::row("SELECT * FROM `users` WHERE `username` = :uname", [
                    ':uname' => $_SESSION["$GetCodeR-recovery"]['login'] 
                ]);
            

                if (isset($rows)) {
                    $_SESSION['username'] = $rows[0]['username'];
                    $_SESSION['password'] = $rows[0]['password'];
                    $_SESSION['id'] = $rows[0]['id'];
                    $_SESSION['email'] = $rows[0]['email'];
                    $mhsgl = 'Пароль успешно восстановлен! <a href="/login" style=\"font-size:0.999rem;\">Войдите</a>';
                    unset($_SESSION["$GetCodeR-recovery"]);
                    header("Location: /");
                    exit;
                } else {
                    $err[] = 'Произошла ошибка, повторите!';
                }
            #}
        }
    }
?>
<?php 
Head('Восстановить пароль | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


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
                        <form enctype="multipart/form-data" action="/lost-passwords/confirm?code=<?php echo $_SESSION["$GetCodeR-recovery"]['code'] ?>&<?php echo $_SESSION["$GetCodeR-recovery"]['login'] ?>&act=<?php echo $_SESSION["$GetCodeR-recovery"]['id'] ?>" id="sing-row" method="post" name="login">
                            <div class="form-in">
                                <div class="form-title">
                                    Восстановление пароля
                                </div>
                                <label class="us-l" for="us-l">
                                    <span>Ваш логин: <b><?php echo $_SESSION["$GetCodeR-recovery"]['login'] ?></b></span>
                                </label>

                                <label for="pass-l">
                                    <span class="exp-title">
                                        Новый пароль: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="password" id="pass-l" name="password" placeholder="" value="<? echo $_POST['password'] ?>" required>
                                </label>

                                <label for="pass-l">
                                    <span class="exp-title">
                                        Подтвердить пароль: <span>обязательно</span>
                                    </span>
                                    <input class="input" type="password" id="r-pass-l" name="r-password" placeholder="" value="<? echo $_POST['r-password'] ?>" required>
                                </label>

                                <label for="capt-l">
                                <span class="exp-title">
                                    Проверка: <span>обязательно</span>
                                </span>
                                    <input class="input" type="text" id="capt-l" name="captcha" placeholder="<?php captcha_show() ?>" required>
                                </label>

                                <div class="form-submit">
                                    <input style="margin: 0;" name="confcod" type="submit" id="inp-dd-syb" value="Восстановить" placeholder="Восстановить">
                                </div>
                            </div>

                            
                        </form>
                    </div>
                </div>
        </section>
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
