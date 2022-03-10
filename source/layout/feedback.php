<?php
session_start();

if (isset($_POST['send'])) {
    
    $err = array();

    if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
        if (trim($_POST['username']) == '') $err[] = 'Введите имя!';
        if (strlen ($_POST['username']) < 3) $err[] = 'Имя должно быть больше трёх символов';
    } 

    if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
        if (trim($_POST['email']) == '') $err[] = 'Введите e-mail!';
        if (!preg_match ($rules['email']['pattern'], $_POST['email'])) $err[] = $rules['email']['message'];
    }

    if (trim($_POST['theme']) == '') $err[] = 'Введите тему!';
    if (strlen ($_POST['theme']) < 6) $err[] = 'Тема должна быть больше шести символов';
    if (trim($_POST['message']) == '') $err[] = 'Введите сообщение!';
    if (strlen ($_POST['message']) < 10) $err[] = 'Сообщение должно быть больше десяти символов';
    if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';

    if (empty($err)) {
        if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
            $username = mysqli_real_escape_string($link, FormChars($_POST['username']));
            $email    = mysqli_real_escape_string($link, FormChars($_POST['email']));
        } else {
            $username = $_SESSION['username'];
            $email    = $_SESSION['email'];
        }
        
        $theme        = mysqli_real_escape_string($link, FormChars($_POST['theme']));
        $msg          = mysqli_real_escape_string($link, FormChars($_POST['message']));
        $to           = "alikzoy@gmail.com";
        
        //mail("=?$charset?B?".base64_encode($to)."?= <$to>",  "=?$charset?B?".base64_encode($subject)."?=", chunk_split(base64_encode($text)), $headers, "-f$from");

        $mhsgl = "Спасибо! Письмо будет отправлено на почту администрации";
    }
}
?>
<?php 
Head('Обратная связь | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>


    
    <!-- Main (site content) -->
    <main id="form-main-l">
        <div class="form-title-l">
            <h1>Обратная свазь</h1>
        </div>
        <?php if (!empty($err)) { ?><div class="search-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo array_shift($err); ?></div><?php } ?>
        <?php if (!empty($mhsgl)) { ?><div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $mhsgl; ?></div><?php } ?>
        <section class="form-section-l">


            <div class="wrapper-form">
                <form enctype="multipart/form-data" id="sing-row" action="/account/preferences" method="post">
                    <div class="form-in">
                        <label for="log-l">
                            <span class="exp-title">
                            Ваше имя: <span>обязательно</span>
                            </span>
                            <? 
                                if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) 
                                    echo "<input class='input' type='text' id='log-l' name='username' placeholder='' value='$_POST[username]' required>";
                                else 
                                    echo "<input class='input' type='text' id='log-l' name='username' style='cursor:not-allowed;background:rgb(28, 38, 47)' placeholder='$_SESSION[username]' value='$_POST[username]' disabled>";
                            ?>
                        </label>
                        <label for="pass-e">
                            <span class="exp-title">
                                Ваш адрес электронной почты: <span>обязательно</span>
                            </span>
                            <? 
                                        if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) 
                                            echo "<input class='input' type='email' id='pass-e' name='email' placeholder='' value='$_POST[email]' required>";
                                        else 
                                            echo "<input class='input' type='email' id='pass-e' name='email' style='cursor:not-allowed;background:rgb(28, 38, 47);' placeholder='$_SESSION[email]' value='$_POST[email]' disabled>";
                                    ?>
                                </label>
                        <label for="">
                                <span class="exp-title">
                                Контент сообщения: <span>обязательно</span>
                                </span>
                                <div class="editor-theme">
                                    <div id="editor"></div>
                                </div>
                            </label>
                        <label for="capt-l">
                            <span class="exp-title">
                                Кому: <b>admin@www.ru</b>
                            </span>
                        <label for="capt-l">
                            <span class="exp-title">
                                Проверка: <span>обязательно</span>
                            </span>
                            <input class="input" type="text" id="capt-l" name="captcha" placeholder="<?php captcha_show() ?>" required>
                        </label>
                        <div class="form-submit">
                            <input style="margin: 0;"  name="send" type="submit" id="inp-dd-syb" value="Отправить" placeholder="Отправить">
                            
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
    <!-- / Main (site content) -->

    <?php require('template/base/footer.php'); ?>

    <!-- Include HTMLREditor -->
<script src="/static/js/vendor/HTMLREditor/script/htmlreditor.bundle.js"></script>

<script>
    $(async function () {

        'use strict';

        await HTMLREditor
                .register('#editor')
				.catch(_err => console.error(_err))

    });
</script>
<!-- / Include HTMLREditor -->

</body>
</html>