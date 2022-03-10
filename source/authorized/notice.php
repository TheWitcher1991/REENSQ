<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

    $sql = "SELECT * FROM `notice` WHERE `who_id` = :who_id";
    $stmtNot = $PDO->prepare($sql);
    $stmtNot->bindParam(':who_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmtNot->execute();

    $stat = 1;

    if ($stmtNot->rowCount() > 0) {
        $row = $stmtNot->fetch();
        if ($row['who_id'] == $_SESSION['id']) {

            $sqlUp = $PDO->prepare("UPDATE `notice` SET `status` = :stat WHERE `who_id` = :who_id");
            $sqlUp->bindParam(':stat',$stat, PDO::PARAM_INT);
            $sqlUp->bindParam(':who_id', $_SESSION['id'], PDO::PARAM_INT);
            $sqlUp->execute();
            $rw = $sqlUp->fetch();
        }
    }





    Head('Уведомления | REENSQ');
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
    <a href="/account/notice" style="color: #7082a7;font-weight: bold">
        Уведомления
    </a>
</section>
<!-- / Maps site -->

<main id="main" >
    <article class="wrapper">
        <section class="notice-section">
            <div class="account--notice-div">
                <div class="rowss">
                    <?php

                    $sql = "SELECT * FROM `notice` WHERE `who_id` = :who_id  ORDER BY `id` DESC";
                    $stmtNot = $PDO->prepare($sql);
                    $stmtNot->bindParam(':who_id', $_SESSION['id'], PDO::PARAM_INT);
                    $stmtNot->execute();

                    if ($stmtNot->rowCount() <= 0) {
                        echo 'У вас нет новых уведомлений';
                    } else {
                        echo '<ul>';
                        while ($row = $stmtNot->fetch()) {
                            ?>
                            <li>
                                <div class="header-msg-img">
                                    <img style="height:100%;width:100%;border-radius: 50%;" src="/static/img/avatar/<?php echo $asa['avatar'] ?>" alt="avatar">
                                </div>
                                <div class="header-info-title">
                                    <div class='header-msg-title'><a href='/account/notice'><?php echo $row['text'] ?></a></div>
                                    <div class='header-msg-info'>
                                        <span style="margin: 0"><?php echo $row['date'] ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        echo '</ul>';
                    }

                    ?>
                </div>
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