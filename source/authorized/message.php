<?php
session_start();
use Reensq\plugin\core\Parser;
use Reensq\plugin\lib\jQuery;
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

$whom = FormChars($_GET['whom']);
$act = (int) FormChars($_GET['act']);

$sqlFors1 = "SELECT * FROM `lmessage` WHERE `id` = :act AND `who` = :whom";
$stmtFors1 = $PDO->prepare($sqlFors1);
$stmtFors1->bindParam(':act', $act, PDO::PARAM_INT);
$stmtFors1->bindParam(':whom', $whom , PDO::PARAM_STR);
$stmtFors1->execute();

if ($stmtFors1->rowCount() <= 0) {
    jQuery::notFound();
}

$rowFors1 = $stmtFors1->fetch();

if ($_SESSION['username'] == $rowFors1['who'] || $_SESSION['username'] == $rowFors1['author']) {

$sqlGetU = $PDO->query("SELECT * FROM `users` WHERE id = " . $rowFors1['author_id']);

$rowGetU = $sqlGetU->fetch();

if (isset($_POST['create_com'])) {

    $err = array();

    if (trim($_POST['content']) == '') $err[] = 'Введите контент комментария!';
    if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';

    if (empty($err)) {

        $content = Parser::register($_POST['content']);

        $sql = "INSERT INTO `lmessage_answer` 
            (`author`, `author_id`, `message_id`, `date`, `text`) 
            VALUES(:people, :people_id, :msg_id, :dates, :cnt)";

        $stmt = $PDO->prepare($sql);

        $stmt->execute([
            ':people' => $_SESSION['username'],
            ':people_id' => $_SESSION['id'],
            ':msg_id' => $rowFors1['id'],
            ':dates' => $Date,
            ':cnt' => $content
        ]);

    }
}

$stat = 1;


if ($rowFors1['who_id'] == $_SESSION['id']) {
    $sqlUp = $PDO->prepare("UPDATE `lmessage` SET `status` = :stat WHERE `id` = :id");
    $sqlUp->bindParam(':stat',$stat, PDO::PARAM_INT);
    $sqlUp->bindParam(':id', $rowFors1['id'], PDO::PARAM_INT);
    $sqlUp->execute();
    $rw = $sqlUp->fetch();
}




Head("$rowFors1[title] | REENSQ");
?>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
    <?php if (!empty($err)) { ?><div class="search-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo array_shift($err); ?></div><?php } ?>
    <section class="theme-section">
            <div class="row-section create-th-row">
                <div class="name-forums-sect">
                    <div class="title-forums-sect">
                        <div class="info-user-theme">
                            <a title="Автор сообщения" href="/profile?name=<?php echo $rowFors1['author'] ?>&act=<?php echo $rowFors1['author_id'] ?>" class="info-user-img">
                                <img src="/static/img/avatar/<?php echo $rowGetU['avatar']; ?>" alt="avatar">
                            </a>
                            <span class="info-user-cnt">
                                <a style="margin:0" title="Автор сообщения" href="/profile?name=<?php echo $rowFors1['author'] ?>&act=<?php echo $rowFors1['author_id'] ?>"><i class="far fa-user"></i> <?php echo $rowFors1['author'] ?></a>
                                <i style="font-size: 14px;
    color: #8c9cbd;">&</i>
                                <a title="Кому отправлено сообщение" href="/profile?name=<?php echo $rowFors1['who'] ?>&act=<?php echo $rowFors1['who_id'] ?>"><i class="far fa-user"></i> <?php echo $rowFors1['who'] ?></a>
                                <a href=""><i class="far fa-clock"></i> <?php echo $rowFors1['date'] ?></a>
                            </span>
                        </div>
                        <h1><?php echo $rowFors1['title'] ?></h1>
                        <section class="navig-theme">
                        <a style="color: #a0afce;font-size: 16px; " href="<?php echo '/' ?>">
                           Аккаунт
                        </a>
    <i style="margin: 0 5px;    font-size: 14px;
    color: #a0afce;" class="fas fa-chevron-right"></i>

    <a href="/account/messages" style="color: #7082a7;font-weight: bold">
       Личные сообщения
    </a>
</section>
                    </div>
                </div> 
                <div class="theme-content">
                    <div class="theme">
                        <div class="base-content ">
                            <div class="left-cnt">
                                
                                <div class="img-user-t">
                                    <img src="/static/img/avatar/<?php echo $rowGetU['avatar']; ?>" alt="avatar">
                                </div>
                                <?php 
                                    if ($rowGetU['role'] == 'user') {
                                        echo '<div class="name-user-t"><a style="color:b1b0b0" href="/profile?name='.$rowFors1['author'].'&act='.$rowFors1['author_id'].'">'.$rowGetU['username'].'</a></div>';
                                    } else if ($rowGetU['role'] == 'admin') {
                                        echo '<div class="name-user-t"><a style="color:#f00" href="/profile?name='.$rowFors1['author'].'&act='.$rowFors1['author_id'].'">'.$rowGetU['username'].'</a></div>';
                                    } else if ($rowGetU['role'] == 'moder') {
                                        echo '<div class="name-user-t"><a style="color:#6f0" href="/profile?name='.$rowFors1['author'].'&act='.$rowFors1['author_id'].'">'.$rowGetU['username'].'</a></div>';
                                    }
                                ?>
                                <div class="status-user-t">
                                    <div class="prof-role">
                                    <?php 
                                        if ($rowGetU['role'] == 'user') {
                                            echo "<span class=\"prof-role-user\">Пользователь</span>";
                                        } else if ($rowGetU['role'] == 'admin') {
                                            echo "<span class=\"prof-role-admin\">Администратор</span>";
                                        } else if ($rowGetU['role'] == 'moder') {
                                            echo "<span class=\"prof-role-moder\">Модератор</span>";
                                        }

                                        $sqlnumT = $PDO->query("SELECT count(*) FROM `threads` WHERE `author_id` = $rowGetU[id]");

                                        $rowssT = $sqlnumT->fetch();

                                        $sqlnumG = $PDO->query("SELECT count(*) FROM `answer` WHERE `author_id` = $rowGetU[id]");
                    
                                        $rowssG = $sqlnumG->fetch();
                                    ?>
                                    </div>
                                    <div class="prof-param">
                                        <ul>
                                            <li>
                                                <span class="topss" title="Сообщения"><i class="far fa-comments"></i></span>
                                                <span class="botss"><?php echo $rowssG['count(*)'] ?></span>
                                            </li>
                                            <li>
                                                <span class="topss" title="Публикации"><i class="far fa-clone"></i></span>
                                                <span class="botss"><?php echo $rowssT['count(*)']; ?></span>
                                            </li>
                                            <li>
                                                <span class="topss" title="Симпатии"><i class="far fa-thumbs-up"></i></span>
                                                <span class="botss"><?php echo $rowGetU['like']; ?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="right-cnt">
                                <div class="info-r-t">
                                    <div class="l"><?php echo $rowFors1['date']; ?></div>
                                    <div class="r">
                                        <span class="share_theme"><i title="В закладки" class="far fa-bookmark"></i></span> 
                                        <span class="num-us">#1</span>   
                                    </div>
                                </div>
                                <div class="t-cnt">
                                    <div class="in"><?php echo $rowFors1['text']; ?></div>
                                </div>
                                <div class="i-na">
                                    <a class="answer-ina"><i class="fa fa-reply"></i> Ответить</a>
                                </div>
                            </div>
                        </div>
                        <?php

                        $sqlComm = $PDO->query('SELECT * FROM `lmessage_answer` WHERE `message_id` = ' . $rowFors1['id'] . ' ORDER BY `id`');
                        while ($comm = $sqlComm->fetch()) {
                            $sqlUserth = $PDO->query('SELECT * FROM `users` WHERE `id` = ' . $comm['author_id']);
                            $userth = $sqlUserth->fetch();

                            $sqlnumT = $PDO->query("SELECT count(*) FROM `answer` WHERE `author_id` = $userth[id]");

                            $rowssT = $sqlnumT->fetch();
                        ?>
                            <div id="answer-<?php echo $comm['id']; ?>" class="base-content">
                                <div class="left-cnt">
                                    <div class="img-user-t">
                                        <img src="/static/img/avatar/<?php echo $userth['avatar']; ?>" alt="avatar">
                                    </div>
                                    <?php
                                    if ($userth['role'] == 'user') {
                                        echo '<div class="name-user-t"><a style="color:b1b0b0"  href="/profile?name='.$userth['username'].'&act='.$userth['id'].'">'.$userth['username'].'</a></div>';
                                    } else if ($userth['role'] == 'admin') {
                                        echo '<div class="name-user-t"><a style="color:#f00" href="/profile?name='.$userth['username'].'&act='.$userth['id'].'">'.$userth['username'].'</a></div>';
                                    } else if ($userth['role'] == 'moder') {
                                        echo '<div class="name-user-t"><a style="color:#6f0" href="/profile?name='.$userth['username'].'&act='.$userth['id'].'">'.$userth['username'].'</a></div>';
                                    }
                                    ?>
                                    <div class="status-user-t">
                                        <div class="prof-role">
                                            <?php
                                            if ($userth['role'] == 'user') {
                                                echo "<span class=\"prof-role-user\">Пользователь</span>";
                                            } else if ($userth['role'] == 'admin') {
                                                echo "<span class=\"prof-role-admin\">Администратор</span>";
                                            } else if ($userth['role'] == 'moder') {
                                                echo "<span class=\"prof-role-moder\">Модератор</span>";
                                            }

                                            $sqlnumG = $PDO->query("SELECT count(*) FROM `answer` WHERE `author_id` = $userth[id]");
                    
                                            $rowssG = $sqlnumG->fetch();
                                            ?>
                                        </div>
                                        <div class="prof-param">
                                            <ul>
                                                <li>
                                                    <span class="topss" title="Сообщения"><i class="far fa-comments"></i></span>
                                                    <span class="botss"><?php echo $rowssG['count(*)'] ?></span>
                                                </li>
                                                <li>
                                                    <span class="topss" title="Публикации"><i class="far fa-clone"></i></span>
                                                    <span class="botss"><?php echo $rowssT['count(*)']; ?></span>
                                                </li>
                                                <li>
                                                    <span class="topss" title="Симпатии"><i class="far fa-thumbs-up"></i></span>
                                                    <span class="botss"><?php echo $userth['like'] ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="right-cnt">
                                    <div class="info-r-t">
                                        <div class="l"><?php echo $comm['date']; ?></div>
                                        <div class="r">
                                            <span class="share_theme"><i title="В закладки" class="far fa-bookmark"></i></span>
                                            <span class="num-us">#NaN</span>
                                            
                                        </div>
                                    </div>
                                    <div class="t-cnt">
                                        <div class="in"><?php echo $comm['text']; ?></div>
                                    </div>
                                    <div class="i-na">
                                    <a class="answer-ina"><i class="fa fa-reply"></i> Ответить</a>
                                   
                                     </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="comment-edit feed">
                        <div class="comm-edit-div-editor">
                        <?php
                            if ($rowFors1['complete'] == 1) {
                                echo '<div style="padding: 16px"> На данное сообщение нельзя отвечать. </div>';
                            } else {
                        ?>
                            <form id="create-com-form" enctype="multipart/form-data" method="POST" action="">
                                <div class="form-cnt">
                                    <div id="editor"></div>
                                    <div style="margin: 16px 0 0 0;" class="captha-theme">
                                        <input style="background: #303943" class="input" type="text" id="capt-theme" name="captcha" placeholder="<?php captcha_show() ?>" required>
                                    </div>
                                </div>
                                <div class="buttons-cr">
                                <?php
                                        echo "<div class=\"inner-create\">
                                        <input id=\"create-com-buttons\" class=\"bth-thg\" type=\"submit\" name=\"create_com\" value=\"Ответить\">
                                    </div>
                                    <div class=\"inner-pred\">
                                        <input type=\"submit\" name=\"view_com\" value=\"Предпросмотр\">
                                    </div>";
                                ?>
                                </div>
                            </form>
                        <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
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
                
        
        $('#tools-block-6').fadeOut();

    });
</script>
<script type="text/javascript" src="/static/js/ajax.js"></script>
<!-- / Include HTMLREditor -->

</body>
</html>
<?php

    } else {
        jQuery::notFound();
    }

} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>