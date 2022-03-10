<?php session_start();
Head('Форумы | Работа форума');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a href="/">Форумы</a>
    <i style="margin: 0 5px" class="fas fa-chevron-right"></i>
    <a href="/forum_work" style="color: #7082a7;font-weight: bold">Работа форума</a>
</section>

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
        <section class="row-glab">
            <div class="categories">
                <div class="row-div" id="work_forum">
                    <div class="logos-row">
                        <div>
                            <img src="/static/img/section/settings.png" alt="Работа форума">
                            <h1>Работа форума</h1>
                        </div>
                    </div>
                    <div class="categories-list">
                    <div class="row-list-section rf-div">
                    <ul>
                            <?php 
                                $fwSQL = $PDO->query("SELECT * FROM `forum_section` WHERE `forum_id` = 5");
                        
                                while ($fw = $fwSQL->fetch()) { 
                                    $sNumO = $PDO->query("SELECT count(*) FROM `threads` WHERE `forums_id` = $fw[id]");
                                    $rowSo = $sNumO->fetch();
                                
                                    $ssw  = $PDO->query("SELECT count(*) FROM `answer` WHERE `threads_forums_id` = " . $fw['id']);
                                    $rw = $ssw->fetch();
                            ?>
                            <li>
                                <span class="f-icon">
                                 <i class="mdi mdi-alert-outline"></i>
                                </span>
                                <div class="f-main"> 
                                    <a href="<?php echo 'forums?f='.$fw['link'].'&act='.$fw['id'].'&fd='.$fw['forum_id'] ?>"> <?php echo $fw['title'] ?></a>
                                    <div class="f-description"></div>
                                </div>
                                <div class="f-stats">
                                    <dl>
                                        <dd>Темы</dd>
                                        <dt><?php echo $rowSo['count(*)'] ?></dt>
                                    </dl>
                                    <dl>
                                        <dd>Комментарии</dd>
                                        <dt><?php echo $rw['count(*)'] ?></dt>
                                    </dl>
                                </div>
                                <div class="f-extra">
                                <?php 
                                    if ($rowSo['count(*)'] > 0) {

                                        $ssw  = $PDO->query("SELECT * FROM `threads` WHERE `forums_id` = $fw[id] ORDER BY `date` DESC LIMIT 1");
                                        $rw = $ssw->fetch();

                                        $ssu = $PDO->query("SELECT * FROM `users` WHERE `id` = $rw[author_id]");
                                        $ru = $ssu->fetch();

                                    ?>
                                    <div class="row-list-last-themes">
                                        <div class="image">
                                            <span><img src="/static/img/avatar/<?php echo $ru['avatar'] ?>" alt="logo"></span>
                                        </div>
                                        <div class="info">
                                            <div class="title"><a href="<?php echo '/threads?f='.$rw['forums_id'].'&act='.$rw['id']; ?>""><?php echo mb_strimwidth($rw['title'], 0, 30, "...") ?></a></div>
                                            <div class="tinf">
                                            <?php 
                                                if ($ru['role'] == 'admin') {
                                                    echo '<a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'" style="color:#ff6969">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
                                                } else {
                                                    echo '<a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
                                                }
                                            ?>
                                                <span><?php echo $rw['date'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    } else {
                                        echo '<span class="f-notheme">Тем нет</span>';
                                    }
                                    ?>
                                </div>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>



                     
                    </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
	<?php require('template/base/aside.php'); ?>
</main>

<?php require('template/base/footer.php'); ?>
</script>
</body>
</html>