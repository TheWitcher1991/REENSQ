<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

    if (isset($_POST['remove-msg'])) {
        $id = (int) $_POST['msg_id'];

        $stmts = $PDO->prepare("DELETE FROM `lmessage` WHERE `id` = :id");
        $stmts->bindParam(':id', $id, PDO::PARAM_INT);
        $stmts->execute();


        $mhsgl = 'Диалог успешно удалён!';
    }

?>
<?php 
Head('Личные сообщения | REENSQ');
?>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a href="/">Аккаунт</a>
    <i style="margin: 0 5px;
    font-size: 14px;
    color: #a0afce;
}" class="fas fa-chevron-right"></i>
    <a href="/account/messages" style="color: #7082a7;font-weight: bold">
        Личные сообщения
    </a>
</section>
<!-- / Maps site -->

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
        <?php if (!empty($mhsgl)) { ?><div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $mhsgl; ?></div><?php } ?>
        <div class="name-forums-sect">
            <div class="title-forums-sect">
                <h1>Личные сообщения</h1>
            </div>
            <div class="button-forums-create">
                <a href="/account/message_add"><i class="mdi mdi-pencil"></i> Отправить сообщение</a>
            </div>
        </div>
    <?php

    $sql = "SELECT * FROM `lmessage` WHERE `who_id` = :who_id ORDER BY `id` DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':who_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();

    $sql2 = "SELECT * FROM `lmessage` WHERE `author_id` = :auh_id ORDER BY `id` DESC";
    $stmt2 = $PDO->prepare($sql2);
    $stmt2->bindParam(':auh_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt2->execute();

    if ($stmt2->rowCount() > 0) {
    ?>
        <section class="messages-section">
            <div class="row-messages">
                <ul>
                <?php
                    while($msg = $stmt2->fetch()) {

                    $sqlAuh = $PDO->query("SELECT * FROM `users` WHERE `id` = $msg[author_id]");
                    $auh = $sqlAuh->fetch();
                ?>
                <li <?php if ($msg['status'] == 0) { echo "style='background: #303942;border: 1px solid rgb(65, 77, 88);'"; } ?> >
                    <div class="info-msg">

                        <div class="img-author-msg">
                            <img style="height:100%;width:100%;border-radius: 50%;" src="/static/img/avatar/<?php echo $auh['avatar']; ?>" alt="avatar">
                        </div>
                        <div class="info-author-msg">
                            <div class="inf-title-name">
                                <?php if ($msg['status'] == 0) { echo "<span>Не прочитано принимателем</span>"; } ?>
                                <a href="/account/message?whom=<?php echo $msg['who'] ?>&act=<?php echo $msg['id'] ?>"><?php echo $msg['title'] ?></a>
                            </div>
                            <div class="inf-user-name">
                                <?php
                                
                                if ($auh['role'] == 'admin') {
                                    echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'" style="color:#ff6969">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                } else if ($auh['role'] == 'moder') {
                                    echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'" style="color:#6f0">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                } else {
                                    echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                }
                                
                                ?>

                                <i><?php echo $msg['date'] ?></i>
                            </div>
                        </div>
                    </div>
                    <div class="remove-msg">
                        <form enctype="multipart/form-data" method="post" id="remove-msg-form">
                            <span id="mess-span" style="display: none"><?php echo $msg['id']; ?></span>
                            <input type="text" style="display: none" name="msg_id" id="mess-inp">
                            <button title="Удалить переписку" class="remove-pop-open" type="button"><i class="fas fa-trash-alt"></i> Удалить</button>
                        </form>
                    </div>
                </li> 
                <?php
                    }
                ?>
                </ul>
                
            </div>
        </section>
    <?php
    }

    if ($stmt->rowCount() > 0) {
    ?>
        <section class="messages-section">
            <div class="row-messages">
                <ul>
                <?php
                    while($msg = $stmt->fetch()) {

                    $sqlAuh = $PDO->query("SELECT * FROM `users` WHERE `id` = $msg[author_id]");
                    $auh = $sqlAuh->fetch();
                ?>
                <li <?php if ($msg['status'] == 0) { echo "style='background: #303942;border: 1px solid rgb(65, 77, 88);'"; } ?> >
                    <div class="info-msg">
                        <div class="img-author-msg">
                            <img style="height:100%;width:100%;border-radius: 50%;" src="/static/img/avatar/<?php echo $auh['avatar']; ?>" alt="avatar">
                        </div>
                        <div class="info-author-msg">
                            <div class="inf-title-name">
                                <?php if ($msg['status'] == 0) { echo "<span>Новое</span>"; } ?>
                                <a href="/account/message?whom=<?php echo $msg['who'] ?>&act=<?php echo $msg['id'] ?>"><?php echo $msg['title'] ?></a>
                            </div>
                            <div class="inf-user-name">
                                <?php
                                
                                if ($auh['role'] == 'admin') {
                                    echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'" style="color:#ff6969">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                } else if ($auh['role'] == 'moder') {
                                    echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'" style="color:#6f0">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                } else {
                                    echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                }
                                
                                ?>

                                <i><?php echo $msg['date'] ?></i>
                            </div>
                        </div>
                    </div>
                </li> 
                <?php
                    }
                ?>
                </ul>
                
            </div>
        </section>
    <?php
        } else {
            echo ' <section class="messages-section">
            <div class="row-messages">У Вас нет личных сообщений</div>
            </section>';
        }
    ?>
    </article>
    <?php require('template/more/base/accountAside.php'); ?>
</main>
<!-- / Main (site content) -->

<!-- Popup remove-msg -->
<section id="main-popup-form">
    <div class="wrapper-form fpopup">
        <div class="avaU-title" style="padding: 16px">
            Удалить диалог
            <i class="fas fa-times close-fpopup"></i>
        </div>
        <form enctype="multipart/form-data" id="pop-form-rows" method="post" name="lost-password">
            <div class="form-in" style="border-radius: 0 0 7px 7px">
                Вы уверены, что хотите удалить диалог? После удаления его не будет возможно восстановить.
                <div style="padding: 16px 0 0 0" class="form-submit">
                    <input name="remove-msg" style="margin: 0;width: 100px;padding: 10px;" type="submit" id="inp-dd-syb" value="Удалить" placeholder="Удалить">
                </div>
            </div>
        </form>
    </div>
</section>
<!-- /Popup remove-msg -->

<?php require('template/base/footer.php'); ?>

<script type="text/javascript">
    $(function () {
        $('.remove-pop-open').on('click', () => {
            $('#main-popup-form').addClass('main-popup-form-active');
            $('.fpopup').addClass('factive');
            $('#mess-inp').val($('#mess-span').text());
        });
        $('.close-fpopup').on('click', () => {
            $('#remove-msg-form').trigger('reset');
            $('#main-popup-form').removeClass('main-popup-form-active');
            $('.fpopup').removeClass('factive');
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