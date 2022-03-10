<?php session_start();

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

?>
<?php 

$res = (int) FormChars($_GET['act']);

$sql1 = "SELECT * FROM `users` WHERE `id` = :id";
$stmt1 = $PDO->prepare($sql1);
$stmt1->bindParam(':id', $res, PDO::PARAM_INT);
$stmt1->execute();

if ($stmt1->rowCount() <= 0) {
    \Reensq\plugin\lib\jQuery::notFound();
}

$row1 = $stmt1->fetch();

Head(''.$row1['username'].' | REENSQ');

$curl = getUrl();
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a style="color: #7082a7;font-weight: bold" href="/members">Пользователи</a>
</section>
<!-- / Maps site -->

<?php
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    ?>
    <section class="sect-avatar-up">
        <form enctype="multipart/form-data" action="/profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>" method="post">
        <div class="div-avatar-up">
            <div class="avaU-title">
                Аватар
                <i class="fas fa-times closeAva-up"></i>
            </div>
            <div class="avaU-cont">
                <div class="flex1" style="width: 96px; height: 96px;">
                    <?php

                    

                    $sqlAD = "SELECT * FROM `users` WHERE `id` = :id ";

                    $stmtAD = $PDO->prepare($sql1);
                    $stmtAD->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                    $stmtAD->execute();

                    $asas = $stmtAD->fetch();

                    ?>
                    <img style="width: 96px;border-radius: 3px;" src="/static/img/avatar/<?php echo $asas['avatar']; ?>" alt="avatar">
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
<?php 
}
?>

<main id="main">
    <article class="wrapper">
    <?php

        $get = (int) FormChars($_GET['act']);

        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':id', $get, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            \Reensq\plugin\lib\jQuery::notFound();
        } else {
            $use = $stmt->fetch();
    ?>
        <section class="wrapper-profile">
            <div class="profile-header-zinfo">
                <div style="background-image: url(/static/img/def-3.jpg)" class="head-profile">
                    <div class="profile-head-avatar">
                        <span>
                            <img src="/static/img/avatar/<?php echo $use['avatar']; ?>" alt="">
                        </span>
                    </div>
                    <div class="profile-head-name">
                        <?php 
                            if ($use['role'] == 'admin') {
                                echo '<h1 style="color:#ff6969">'.$use['username'].'</h1>';
                            } else {
                                echo "<h1>".$use['username']."</h1>";
                            }
                        ?>
                        <div class="prof-role">
                        <?php 
                            if ($use['role'] == 'user') {
                                echo "<span class=\"prof-role-user\">Пользователь</span>";
                            } else if ($use['role'] == 'admin') {
                                echo "<span class=\"prof-role-admin\">Администратор</span>";
                            } else if ($use['role'] == 'moder') {
                                echo "<span class=\"prof-role-moder\">Модератор</span>";
                            }

                            $sqlnumT = $PDO->query("SELECT count(*) FROM `threads` WHERE `author_id` = $use[id]");
                    
                            $rowssT = $sqlnumT->fetch();

                            $ssw  = $PDO->query("SELECT count(*) FROM `answer` WHERE `author_id` = " . $use['id']);
                            $rw = $ssw->fetch();


                        ?>
                        </div>
                        <div class="profile-head-info">
                            <dl class="info-dl">
                                <dt>Регистрация</dt>
                                <dd><?php echo $use['date']; ?></dd>
                            </dl>
                            <dl class="infos-dl">
                                <dt>Публикации</dt>
                                <dd><?php echo $rowssT['count(*)']; ?></dd>
                            </dl>
                            <dl class="info-dl">
                                <dt>Сообщения</dt>
                                <dd><?php echo $rw['count(*)']; ?></dd>
                            </dl>
                            <dl class="infos-dl">
                                <dt>Симпатии</dt>
                                <dd><?php echo $use['like']; ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-bottom-content">
                <div class="wrap-prof-list">
                    <ul class="tabsi">
                        <!--<li class="activs communist">Сообщения</li>-->
                        <li class="themes_s activs">Публикации</li>
                        <li class="comments">Комментарии</li>
                        <li class="inform">Информация</li>
                        <li class="likes">Симпатии</li>
                    </ul>

                    <section class="tabsi-cnt">
                        <!--<div data-index="0" class="prof_txt cmd activs">Сообщений профиля нет</div>-->
                        <div data-index="3" class="prof_txt thd activs">
                            <ul>
                        <?php
                            if ($rowssT['count(*)'] > 0) {
                                $sqlth = $PDO->query("SELECT * FROM `threads` WHERE `author_id` = $use[id] ORDER BY `date` DESC LIMIT 15");
                                while ($tha = $sqlth->fetch()) {
                                    ?>
                                    <li>
                                        <div class="profile-left-cts">
                                            <span>
                                                <img src="/static/img/avatar/<?php echo $use['avatar'] ?>" alt="avatar">
                                            </span>
                                        </div>
                                        <div class="profile-right-cts">
                                            <div class="title">
                                                <span><?php echo $tha['forums_name'] ?></span>
                                                <a href="<?php echo '/threads?f='.$tha['forums_id'].'&act='.$tha['id']; ?>"><?php echo mb_strimwidth($tha['title'], 0, 50, "..."); ?></a>
                                            </div>
                                            <div class="info">
                                                <a href="<?php echo '/profile?name='.$use['username'].'&act='.$use['id'] ?>">
                                                <?php
                                                    if ($use['role'] == 'admin') {
                                                        echo '<span style="color:#ff6969">'.mb_strimwidth($use['username'], 0, 40, "...").'</span>';
                                                    } else {
                                                        echo "<span>".mb_strimwidth($use['username'], 0, 40, "...")."</span>";
                                                    }
                                                ?>
                                                </a>
                                                <span><?php echo $tha['date'] ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo 'У ' . $use['username'] . ' нет ни одной публикации';
                            }
                        ?>
                            </ul>
                        </div>
                        <div data-index="4" class="prof_txt ced">
                            <ul>
                        <?php
                            if ($rw['count(*)'] > 0) {
                                $sqlce = $PDO->query("SELECT * FROM `answer` WHERE `author_id` = $use[id] ORDER BY `date` DESC LIMIT 15");
                                while ($cea = $sqlce->fetch()) {
                                    $sqlNewst = $PDO->query('SELECT * FROM `threads` WHERE `id` = ' . $cea['threads_id']);
                                    $ths = $sqlNewst->fetch();
                                    ?>
                                    <li>
                                        <div class="profile-left-cts">
                                            <span>
                                                <img src="/static/img/avatar/<?php echo $use['avatar'] ?>" alt="avatar">
                                            </span>
                                        </div>
                                        <div class="profile-right-cts">
                                            <div class="title">
                                                <span><?php echo $ths['forums_name'] ?></span>
                                                <a href="<?php echo '/threads?f='.$ths['forums_id'].'&act='.$ths['id']; ?>"><?php echo mb_strimwidth($ths['title'], 0, 50, "..."); ?></a>
                                            </div>
                                            <div class="cnt">
                                                <span><?php echo mb_strimwidth($cea['text'], 0, 60, "..."); ?><span>
                                            </div>
                                            <div class="info">
                                                <a href="<?php echo '/profile?name='.$use['username'].'&act='.$use['id'] ?>">
                                                    <?php
                                                    if ($use['role'] == 'admin') {
                                                        echo '<span style="color:#ff6969">'.mb_strimwidth($use['username'], 0, 40, "...").'</span>';
                                                    } else {
                                                        echo "<span>".mb_strimwidth($use['username'], 0, 40, "...")."</span>";
                                                    }
                                                    ?>
                                                </a>
                                                <span><?php echo $cea['date'] ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            } else {
                                echo $use['username'] . ' не оставил(-а) ни одного комментария';
                            }
                        ?>
                            </ul>
                        </div>
                        <div data-index="1" class="prof_txt ind"><?php

                            if (!empty($use['website'])) {

                                echo '<dl>
                                    <dt>Веб-сайт:</dt>
                                    <dd>'.$use['website'].'</dd>
                                </dl>';

                            } 
                            
                            if (!empty($use['skype'])) {

                                echo '<dl>
                                    <dt>Skype:</dt>
                                    <dd>'.$use['skype'].'</dd>
                                </dl>';

                            } 
                            
                            if (!empty($use['discord'])) {

                                echo '<dl>
                                    <dt>Discord:</dt>
                                    <dd>'.$use['discord'].'</dd>
                                </dl>';

                            } 
                            
                            if (!empty($use['vk'])) {

                                echo '<dl>
                                    <dt>Vk:</dt>
                                    <dd>'.$use['vk'].'</dd>
                                </dl>';

                            } 
                            
                            if (!empty($use['telegram'])) {

                                echo '<dl>
                                    <dt>Telegram:</dt>
                                    <dd>'.$use['telegram'].'</dd>
                                </dl>';

                            } 

                            ?></div>
                        <div data-index="2" class="prof_txt lid"><?php echo 'У ' . $use['username'] . ' нет симпатий, или пользователь не поставил(-а) никому симпатию' ?></div>
                    </section>
                </div>
            </div>
        </section>
    <?php
        }
    ?>
    </article>
</main>

<!-- / Main (site content) -->

<?php require('template/base/footer.php'); ?>

<script type="text/javascript">
$(function () {

    $('#file--up').on('click', function (e) {
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
