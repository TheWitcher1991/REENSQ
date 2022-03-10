<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

    $useeds = $PDO->query("SELECT * FROM `users` WHERE `id` = " . $_SESSION['id']);
    $usde = $useeds->fetch();
?>
<?php 
Head('Безопасность | REENSQ');
?>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>

<!-- Maps site -->
<section class="navig">
    <div class="form-title-l">
            <h1 style="margin: 0 0 10px 0;">Безопасность</h1>
    </div>
    <a style="color: #7082a7;font-weight: bold" href="/profile?id=<?php echo $_SESSION['id'] ?>">Ваш акаунт</a>
</section>

<main id="main">
    <article style="border-top: 6px solid #0083ec;" class="wrapper">
    <section class="account-prefences-wrapper form-section-l">
            <div class="wrapper-form">
                <form enctype="multipart/form-data" id="sing-row" action="/account/preferences" method="post">
                    <div class="form-in">
                        <label for="tec-pass">
                            <span class="exp-title">
                                Ваш текущий пароль: <span>обязательно</span>
                            </span>
                            <input class="input" type="password" id="tec-pass" name="tec-password" placeholder="" value="" required="">
                            <span class="explain">Для изменения пароля, пожалуйста, введите старый пароль.</span>
                        </label>
                        <label for="pass">
                            <span class="exp-title">
                                Новый пароль: <span>обязательно</span>
                            </span>
                            <input class="input" type="password" id="pass" name="password" placeholder="" value="" required="">
                        </label>
                        <label for="r-pass">
                            <span class="exp-title">
                                Подтвердить новый пароль: <span>обязательно</span>
                            </span>
                            <input class="input" type="password" id="r-pass" name="r-password" placeholder="" value="" required="">
                        </label>
                        <label for="capt-l">
                            <span class="exp-title">
                                Проверка: <span>обязательно</span>
                            </span>
                            <input class="input" type="text" id="capt-l" name="captcha" placeholder="<?php captcha_show() ?>" required>
                        </label>
                        <div class="form-submit">
                            <input style="margin: 0;" name="save" type="submit" id="inp-dd-syb" value="Сохранить" placeholder="Сохранить">
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </article>
    <?php require('template/more/base/accountAside.php'); ?>
</main>

<?php require('template/base/footer.php'); ?>
</body>
</html>
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>