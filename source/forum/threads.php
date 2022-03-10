<?php session_start();

use Reensq\plugin\core\Parser;
use Reensq\plugin\lib\jQuery;

$idUser = (int) FormChars($_GET['act']);
$idSect = (int) FormChars($_GET['f']);

$sqlFors1 = "SELECT * FROM `threads` WHERE `id` = :aid AND `forums_id` = :fid";
$stmtFors1 = $PDO->prepare($sqlFors1);
$stmtFors1->bindParam(':aid', $idUser, PDO::PARAM_INT);
$stmtFors1->bindParam(':fid', $idSect, PDO::PARAM_INT);
$stmtFors1->execute();

if ($stmtFors1->rowCount() <= 0) {
    jQuery::notFound();
}

$rowFors1 = $stmtFors1->fetch();

$nameFsql = $PDO->query("SELECT * FROM `forum_section` WHERE `id` =" . $rowFors1['forums_id']);
$fn = $nameFsql->fetch();


if (isset($_POST['create_com'])) {

    $err = array();

    if (trim($_POST['content']) == '') $err[] = 'Введите контент комментария!';
    if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';

    if (isset($_POST['create_com']) && empty($err)) {

        $content = Parser::register($_POST['content']);

        $sql = "INSERT INTO `answer` (`author`, `author_id`, `date`, `threads_id`, `active_threads`, `threads_name`, 
                                      `threads_forums`, `text`, `threads_forums_id`) 
                VALUES(:user, :userid, :dat, :tid, :act, :tn, :tf, :text, :fid)";
        $stmt = $PDO->prepare($sql);
        if ($_SESSION['username'] == $rowFors1['author']) {
            $acts = 1;
        } else {
            $acts = 0;
        }
        $stmt->execute([
            ':user' => $_SESSION['username'],
            ':userid' => $_SESSION['id'],
            ':dat' => $Date,
            ':tid' => $rowFors1['id'],
            ':act' => $acts,
            ':tn' => $rowFors1['title'],
            ':tf' => $rowFors1['forums_name'],
            ':text' => $content,
            ':fid' => $rowFors1['forums_id']
        ]);


    }

}

$sqlGetU = $PDO->query("SELECT * FROM `users` WHERE id = " . $rowFors1['author_id']);

$rowGetU = $sqlGetU->fetch();

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
                            <a title="Автор публикации" href="/profile?name=<?php echo $rowFors1['author'] ?>&act=<?php echo $rowFors1['author_id'] ?>" class="info-user-img">
                                <img src="/static/img/avatar/<?php echo $rowGetU['avatar']; ?>" alt="avatar">
                            </a>
                            <span class="info-user-cnt">
                                <a title="Автор публикации" href="/profile?name=<?php echo $rowFors1['author'] ?>&act=<?php echo $rowFors1['author_id'] ?>"><i class="far fa-user"></i> <?php echo $rowFors1['author'] ?></a>
                                <a href=""><i class="far fa-clock"></i> <?php echo $rowFors1['date'] ?></a>
                            </span>
                        </div>
                        <h1><?php echo $rowFors1['title'] ?></h1>
                        <section class="navig-theme">
                        <a style="color: #a0afce;font-size: 16px; " href="<?php echo '/' ?>">
                            <?php
                                if ($fn['id'] == 1) {
                                    echo 'Информационная безопасность';
                                } else {
                                    echo $fn['forum_name'];
                                }
                            ?>
                        </a>
    <i style="margin: 0 5px;    font-size: 14px;
    color: #a0afce;" class="fas fa-chevron-right"></i>

    <a href="<?php echo 'forums?f='.$fn['link'].'&act='.$fn['id'].'&fd='.$fn['forum_id'] ?>" style="color: #7082a7;font-weight: bold">
        <?php
            if ($rowFors1['forums_id'] == 1) {
                echo 'Информационная безопасность';
            } else {
                echo $rowFors1['forums_name'];
            }
        ?>
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
                                        <span class="os_theme"><i title="Делиться темой" class="fas fa-share-alt"></i></span> 
                                        <span class="share_theme"><i title="В закладки" class="far fa-bookmark"></i></span> 
                                        <span class="num-us">#1</span>   
                                    </div>
                                </div>
                                <div class="t-cnt">
                                    <div class="in"><?php echo $rowFors1['text']; ?></div>
                                </div>
                                <div class="i-na">
                                    <a class="answer-ina"><i class="fa fa-reply"></i> Ответить</a>
                                    <div class="act-theme">Создатель темы</div>
                                </div>
                            </div>
                        </div>
                        <?php

                        $sqlComm = $PDO->query('SELECT * FROM `answer` WHERE `threads_id` = ' . $rowFors1['id'] . ' ORDER BY `id`');
                        while ($comm = $sqlComm->fetch()) {
                            $sqlUserth = $PDO->query('SELECT * FROM `users` WHERE `id` = ' . $comm['author_id']);
                            $userth = $sqlUserth->fetch();

                            $sqlnumT = $PDO->query("SELECT count(*) FROM `threads` WHERE `author_id` = $userth[id]");

                            $rowssT = $sqlnumT->fetch();
                        ?>
                            <div <?php if ($rowGetU['username'] == $comm['author']) {  ?> style="border: 2px solid #0083ec;" <?php } ?>  id="answer-<?php echo $comm['id']; ?>" class="base-content">
                                <div class="left-cnt">
                                    <div class="img-user-t">
                                        <img src="/static/img/avatar/<?php echo $userth['avatar']; ?>" alt="avatar">
                                    </div>
                                    <?php
                                    if ($userth['role'] == 'user') {
                                        echo '<div class="name-user-t"><a style="color:b1b0b0"  href="/profile?name='.$rowFors1['username'].'&act='.$rowFors1['id'].'">'.$userth['username'].'</a></div>';
                                    } else if ($userth['role'] == 'admin') {
                                        echo '<div class="name-user-t"><a style="color:#f00" href="/profile?name='.$rowFors1['username'].'&act='.$rowFors1['id'].'">'.$userth['username'].'</a></div>';
                                    } else if ($userth['role'] == 'moder') {
                                        echo '<div class="name-user-t"><a style="color:#6f0" href="/profile?name='.$rowFors1['username'].'&act='.$rowFors1['id'].'">'.$userth['username'].'</a></div>';
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
                                            <span class="os_theme"><i title="Делиться комментарием" class="fas fa-share-alt"></i></span>
                                            <span class="share_theme"><i title="В закладки" class="far fa-bookmark"></i></span>
                                            <span class="num-us">#NaN</span>
                                            
                                        </div>
                                    </div>
                                    <div class="t-cnt">
                                        <div class="in"><?php echo $comm['text']; ?></div>
                                    </div>
                                    <div class="i-na">
                                    <a class="answer-ina"><i class="fa fa-reply"></i> Ответить</a>
                                    <?php
                                    if ($rowGetU['username'] == $comm['author']) {
                                    ?>
                                        
                                            <div class="act-theme">Создатель темы</div>
                                       
                                    <?php
                                    }
                                    ?>
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
                            if ($rowFors1['title'] == 'Правила поведения на сайте' or $rowFors1['title'] == 'Добро пожаловать!') {
                                echo '<div style="padding: 16px"> Данную тему нельзя комментировать. </div>';
                            } else {
                        ?>
                            <form id="create-com-form" enctype="multipart/form-data" method="POST" action="">
                                <div class="form-cnt">
                                    <div id="editor"></div>
                                    <div style="margin: 16px 0 0 0;" class="captha-theme">
                                        <input class="input" type="text" id="capt-theme" name="captcha" placeholder="<?php captcha_show() ?>" required>
                                    </div>
                                </div>
                                <div class="buttons-cr">
                                <?php
                                    if (isset($_SESSION['username'], $_SESSION['password'])) {
                                        echo "<div class=\"inner-create\">
                                        <input id=\"create-com-buttons\" class=\"bth-thg\" type=\"submit\" name=\"create_com\" value=\"Ответить\">
                                    </div>
                                    <div class=\"inner-pred\">
                                        <input type=\"submit\" name=\"view_com\" value=\"Предпросмотр\">
                                    </div>";
                                    } else {
                                        echo '<div style="padding: 0 0 16px 16px"> Чтобы ответить: Вам нужно авторизироваться на форуме. </div>';
                                    }
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
<!-- / Include HTMLREditor -->

</body>
</html>