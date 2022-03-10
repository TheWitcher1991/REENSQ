<?php session_start();

use Reensq\plugin\core\Parser;
use \Reensq\plugin\lib\jQuery;

if (!isset($_SESSION['username'], $_SESSION['password'])) {
    jQuery::notFound();
}

$sID   = (int) FormChars($_GET['f']);
$fID   = (int) FormChars($_GET['act']);


$sqlFors1 = "SELECT * FROM `forum_section` WHERE `id` = :id AND `forum_id` = :fid";
$stmtFors1 = $PDO->prepare($sqlFors1 );
$stmtFors1->bindParam(':id', $fID, PDO::PARAM_INT);
$stmtFors1->bindParam(':fid', $sID, PDO::PARAM_INT);
$stmtFors1->execute();

if ($stmtFors1->rowCount() <= 0) {
    jQuery::notFound();
}


$rowFors1 = $stmtFors1->fetch();


if (isset($_POST['create_theme']) || isset($_POST['view_theme'])) {

    $err = array();

    if (trim($_POST['title']) == '') $err[] = 'Введите заголовок темы!';
    if (trim($_POST['content']) == '') $err[] = 'Введите контент темы!';
    if (strlen ($_POST['title']) < 6 or strlen ($_POST['title']) > 100) $err[] = $rules['title_theme']['message_two'];
    if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';

    // Создать тему
    if (isset($_POST['create_theme']) && empty($err)) {
        
        $title = FormChars($_POST['title']);
        $content = Parser::register($_POST['content']);

        $sql = "INSERT INTO `threads` (`author`, `author_id`, `title`, `date`, `forums_id`, `forums_name`, `text`) 
                VALUES(:user, :userid, :title, :dates, :fid, :fname, :content)";
        $stmt = $PDO->prepare($sql);
        $stmt->execute([
            ':user' => $_SESSION['username'],
            ':userid' => $_SESSION['id'],
            ':title' => $title,
            ':dates' => $Date,
            ':fid' => $rowFors1['id'],
            ':fname' => $rowFors1['title'],
            ':content' => $content
        ]);

        $nums = (int) $rowFors1['threads_num'] + 1;

        $sr = $PDO->prepare("UPDATE `forum_section` SET `threads_num` = :inte WHERE `id` LIKE :fids");
        $sr->execute([
            ':inte' => $nums,
            ':fids' => $rowFors1['id']
        ]);
        
        header('Location: /');
        exit;

    }

    // Предпросмотр
    if (isset($_POST['view_theme']) && empty($err)) {
        return false;
    }

}

Head('Создать тему | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a href="<?php echo '' ?>">
        <?php
            if ($rowFors1['forum_id'] == 1) {
                echo 'Информационная безопасность';
            } else {
                echo $rowFors1['forum_name'];
            }

        ?>
    </a>
    <i style="margin: 0 5px" class="fas fa-chevron-right"></i>
    <a href="<?php echo 'forums?f=novosti&act=2&fd=5' ?>" style="color: #7082a7;font-weight: bold">
        <?php
            echo $rowFors1['title'];
        ?>
    </a>
</section>
<!-- / Maps site -->

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
    <?php if (!empty($err)) { ?><div class="search-danger"><i class="fas fa-exclamation-triangle"></i> <?php echo array_shift($err); ?></div><?php } ?>
        <section class="theme-section">
            <div style="box-shadow: none" class="row-section create-th-row wrapper-form">
                <div class="name-forums-sect">
                    <div class="title-forums-sect">
                        <h1>Создать тему</h1>
                    </div>
                </div> 
                <form id="create-theme-form" enctype="multipart/form-data" method="post" action="<?php echo '/create-threads?act='.$rowFors1['id'].'&f='.$rowFors1['forum_id']?>">
                    <div class="button-forums-create">
                        <div class="content-create">
                            <label for="log-l">
                                <span class="exp-title">
                                 Заголовок темы: <span>обязательно</span>
                                </span>
                                <input style="font-size: 24px" class="input" type="text" id="log-l" name="title" required>
                            </label>
                            <label for="">
                                <span class="exp-title">
                                Контент темы: <span>обязательно</span>
                                </span>
                                <div class="editor-theme">
                                    <div id="editor"></div>
                                </div>
                            </label>
                            <label for="capt-l">
                                <span class="exp-title">
                                    Проверка: <span>обязательно</span>
                                </span>
                                <input style="border-radius:3px" class="input" type="text" id="capt-theme" name="captcha" placeholder="<?php captcha_show() ?>" required>
                            </label>
                        </div>
                        <div class="buttons-cr">
                            <div class="inner-create">
                                <input class="bth-thg" id="ct-bth" type="submit" name="create_theme" value="Создать тему">
                            </div>
                            <div class="inner-pred">
                                <input type="submit" name="view_theme" value="Предпросмотр">
                            </div>
                        </div>
                    </div> 
                </form>
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

    });
</script>
<!-- / Include HTMLREditor -->

</body>
</html>
