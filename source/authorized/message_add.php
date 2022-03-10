<?php
session_start();
use Reensq\plugin\core\Parser;
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
?>
<?php 
Head('Отправить сообщение | REENSQ');

if (isset($_POST['send'])) {

    $err = array();

    if (trim($_POST['users']) == '') $err[] = 'Введите получателя!';
    if (trim($_POST['title']) == '') $err[] = 'Введите заголовок!';
    if (trim($_POST['content']) == '') $err[] = 'Введите контент сообщения!';
    if (trim($_POST['users']) == $_SESSION['username']) $err[] = 'Нельзя отправить сообщение себе!';
    if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';

    if (empty($err)) {

        $content = Parser::register($_POST['content']);

        $stmt = $PDO->prepare("SELECT * FROM `users` WHERE `username` = :names");
        $stmt->bindParam(':names', $_POST['users'], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            $err[] = 'Данный пользователь не найден!';
        } else {

            $row = $stmt->fetch();

            $sqlM = "INSERT INTO `lmessage` 
            (`author`, `author_id`, `who`, `who_id`, `date`, `title`, `text`)
            VALUES(:auh, :auh_id, :who, :who_id, :dates, :title, :cnt)";

            $stmtM = $PDO->prepare($sqlM);
            $stmtM->execute([
                ':auh' => $_SESSION['username'],
                ':auh_id' => $_SESSION['id'],
                ':who' => $row['username'],
                ':who_id' => $row['id'],
                ':dates' => $Date,
                ':title' => $_POST['title'],
                ':cnt' => $content
            ]);

            $mhsgl = 'Ваше сообщение успешно отправлено!';

        }

     }

}

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
    <?php if (!empty($mhsgl)) { ?><div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $mhsgl; ?></div><?php } ?>
        <section class="theme-section">
            <div style="box-shadow: none" class="row-section create-th-row wrapper-form">
                <div class="name-forums-sect">
                    <div class="title-forums-sect">
                        <h1>Отправить сообщение</h1>
                        <section class="navig-theme">
    <a href="" style="color: #a0afce;
    font-size: 16px;">
        Аккаунт
    </a>
    <i style="margin: 0 5px" class="fas fa-chevron-right"></i>
    <a style="color: #7082a7;
    font-weight: bold;" href="/account/message_add">
        Отправить сообщение
    </a>
</section>
<!-- / Maps site -->
                    </div>
                </div> 
                <form id="create-theme-form" enctype="multipart/form-data" method="post" action="">
                    <div class="button-forums-create">
                        <div class="content-create">
                            <label style="padding: 0 0 20px 0;border-bottom: 2px solid #414d58;" for="log-l">
                                <span class="exp-title">
                                 Получатель: <span>обязательно</span>
                                </span>
                                <input style="font-size: 18x" class="input" type="text" id="log-l" name="users" required>
                            </label>
                            <label for="log-l">
                                <span class="exp-title">
                                 Заголовок сообщения: <span>обязательно</span>
                                </span>
                                <input style="font-size: 24px" class="input" type="text" id="log-l" name="title" required>
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
                                    Проверка: <span>обязательно</span>
                                </span>
                                <input style="border-radius:3px" class="input" type="text" id="capt-theme" name="captcha" placeholder="<?php captcha_show() ?>" required>
                            </label>
                            <label class="iconic" for="check-acc">
                                    <input type="checkbox" id="check-acc" name="accept" value="1">
                                    <i style="margin-right:3px;cursor:pointer" aria-hidden="true"></i>
                                    Закрыть переписку (нельзя будет больше отвечать)
                            </label>
                        </div>
                        <div class="buttons-cr">
                            <div class="inner-create">
                                <input class="bth-thg" id="ct-bth" type="submit" name="send" value="Отправить">
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
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>