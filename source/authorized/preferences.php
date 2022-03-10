<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    

    $useeds = $PDO->query("SELECT * FROM `users` WHERE `id` = " . $_SESSION['id']);
    $usde = $useeds->fetch();

    if(isset($_POST["avatarup"])) {

        $avatar = '';
    
        if(file_exists($_FILES['file-up']['tmp_name']) || is_uploaded_file($_FILES['file-up']['tmp_name'])) {
            $avatar = $_FILES['file-up'];
            move_uploaded_file($avatar['tmp_name'], '/home/host1380908/breusav.ru/htdocs/reensq/static/img/avatar/' . $_SESSION['username'] . '_' . $avatar['name']);
            $avatar = $_SESSION['username'] . '_' . $avatar['name'];
        } else {
            $avatar = 'avatar-default.jpg';
        }
    
        //PDO::PARAM_INT
        $username = $_SESSION['username'];
    
        $sqlAvatar = "UPDATE `users` SET `avatar` = :img WHERE `username` = :uname";
    
        $stmtA = $PDO->prepare($sqlAvatar);
        $stmtA->bindParam(':img', $avatar, PDO::PARAM_STR);
        $stmtA->bindParam(':uname', $username, PDO::PARAM_STR);
        $stmtA->execute();
    
        if ($stmtA == 'TRUE') {
            header("Location: /profile?name=$_SESSION[username]&act=$_SESSION[id]");
        }
    
    }

    if(isset($_POST["save"])) {
        $err = array();

        if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';

        if (empty($err)) {

            $site = $_POST['site'];
            $about = $_POST['content-area'];
            $skype = $_POST['skype'];
            $discord = $_POST['discord'];
            $vk = $_POST['vk'];
            $telegram = $_POST['telegram'];

            $sqlus = "UPDATE `users` SET 
                `website` = :website, 
                `about_user` = :about, 
                `skype` = :skype,
                `discord` = :dis,
                `vk` = :vk, 
                `telegram` = :telegram WHERE `id` = :id";
            $stmt = $PDO->prepare($sqlus);
            $stmt->execute([
                ':website' => $site,
                ':about' => $about,
                ':skype' => $skype,
                ':dis' => $discord,
                ':vk' => $vk,
                ':telegram' => $telegram,
                ':id' => $_SESSION['id']
            ]);
        }


    }
?>
<?php 
Head('Настройки | REENSQ');
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
            <h1 style="margin: 0 0 10px 0;">Настройки</h1>
    </div>
    <a style="color: #7082a7;font-weight: bold" href="/profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>">Ваш акаунт</a>
</section>

<section class="sect-avatar-up">
        <form enctype="multipart/form-data" action="/account/preferences" method="post">
        <div class="div-avatar-up">
            <div class="avaU-title">
                Аватар
                <i class="fas fa-times closeAva-up"></i>
            </div>
            <div class="avaU-cont">
                <div class="flex1" style="width: 96px; height: 96px;">
                    
                    <img style="width: 96px;height:96px;border-radius: 50%;" src="/static/img/avatar/<?php echo $usde['avatar']; ?>" alt="avatar">
                </div>
                <div class="flex2">
                    <p>Загрузите новый аватар</p>
                    <input type="file" name="file-up" id="file-up">
                </div>
            </div>
            <div class="avaU-comp">  
                <input name="avatarup" type="submit" id="avatarup" value="Загрузить">
            </div>  
        </div>
        </form>
</section>

<main id="main" >
    <article style="border-top: 6px solid #0083ec;" class="wrapper">
        <section class="account-prefences-wrapper form-section-l">
            <div class="page-content">
                <div class="wrapper-form">
                    <form enctype="multipart/form-data" action="/account/preferences" id="sing-row" method="post" name="login">
                        <div class="form-in">
                            <label class="us-l" for="us-l">
                                <span>Ваша email почта: <?php echo $usde['email'] ?></span>
                                <span class="change-email"><i class="fas fa-pen"></i> Изменить</span>
                            </label>

                            <label class="de-l" for="de-l">
                                <select name="dual_auh" id="">
                                    <option value="0">Двухфакторная аутентификация выкл.</option>
                                    <option value="1">Двухфакторная аутентификация вкл.</option>
                                </select>
                            </label>

                            <label for="logs-l">
                                <span class="exp-title">
                                    Аватар:
                                    <span>Нажмите на аватар</span>
                                </span>
                                <span class="ava-pref">
                                    <img style="width: 96px;height: 96px;border-radius: 60%;cursor: pointer;" src="/static/img/avatar/<?php echo $usde['avatar'] ?>" alt="avatar">
                                </span>  
                            </label>

                            <label for="logs-l">
                                <span class="exp-title">
                                    Веб-сайт:
                                </span>
                                <input class="input" type="text" id="site" name="site" placeholder="<? echo $usde['website'] ?>" value="<? echo $usde['website'] ?>">
                            </label>

                            <label for="pass-l">
                                <span class="exp-title">
                                    Обо мне:
                                </span>
                                <div id="editor"></div>
                            </label>
                        </div>

                        <h2 class="hr-div">
                            Средства коммуникаций
                        </h2>

                        <div class="form-in">
                            <label for="pass-l">
                                <span class="exp-title">
                                    Skype:
                                </span>
                                <input class="input" type="text" id="skype" name="skype" placeholder="<? echo $usde['skype'] ?>" value="<? echo $usde['skype'] ?>">
                            </label>

                            <label for="pass-l">
                                <span class="exp-title">
                                    Discord:
                                </span>
                                <input class="input" type="text" id="discord" name="discord" placeholder="<? echo $usde['discord'] ?>" value="<? echo $usde['discord'] ?>">
                            </label>

                            <label for="pass-l">
                                <span class="exp-title">
                                    Vk:
                                </span>
                                <input class="input" type="text" id="vk" name="vk" placeholder="<? echo $usde['vk'] ?>" value="<? echo $usde['vk'] ?>">
                            </label>

                            <label for="pass-l">
                                <span class="exp-title">
                                    Telegram:
                                </span>
                                <input class="input" type="text" id="telegram" name="telegram" placeholder="<? echo $usde['telegram'] ?>" value="<? echo $usde['telegram'] ?>">
                            </label>

                            <label for="capt-l">
                                <span class="exp-title">
                                    Проверка: <span>обязательно</span>
                                </span>
                                <input style="border-radius:3px" class="input" type="text" id="capt-theme" name="captcha" placeholder="<?php captcha_show() ?>" required>
                            </label>

                            <div class="form-submit">
                                <input style="margin: 0;" name="save" type="submit" id="inp-dd-syb" value="Сохранить" placeholder="Сохранить">
                            </div>
                        </div>

                        
                    </form>
                </div>
            </div>
        </section>
    </article>
    <?php require('template/more/base/accountAside.php'); ?>
</main>

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

<script type="text/javascript">
$(function () {

    $('.ava-pref').on('click', function (e) {
        e.preventDefault();

        $('.sect-avatar-up').fadeIn(300);
    });

    $('.closeAva-up').on('click', function (e) {
        e.preventDefault();

        $( '.sect-avatar-up').fadeOut(300);
    });

});
</script>

</body>
</html>
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>