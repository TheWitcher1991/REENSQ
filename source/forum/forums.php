<?php session_start();

$fID   = (int) FormChars($_GET['fd']);
$sID   = (int) FormChars($_GET['act']);
$sName = $_GET['f'];


$sqlFors1 = "SELECT * FROM `forum_section` WHERE `id` = :id AND `forum_id` = :fid";
$stmtFors1 = $PDO->prepare($sqlFors1 );
$stmtFors1->bindParam(':id', $sID, PDO::PARAM_INT);
$stmtFors1->bindParam(':fid', $fID, PDO::PARAM_INT);
$stmtFors1->execute();

if ($stmtFors1->rowCount() <= 0) {
    \Reensq\plugin\lib\jQuery::notFound();
}

$rowFors1 = $stmtFors1->fetch();

Head(''.$rowFors1['title'].'| REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a href="/">Форумы</a>
    <i style="margin: 0 5px" class="fas fa-chevron-right"></i>
    <a href="/forums/<?php echo 'forums?f='.$rowFors1['link'].'&act='.$rowFors1['id'].'&fd='.$rowFors1['forum_id'] ?>" style="color: #7082a7;font-weight: bold">
        <?php
            if ($rowFors1['forum_id'] == 1) {
                echo 'Информационная безопасность';
            } else {
                echo $rowFors1['forum_name'];
            }
        ?>
    </a>
</section>
<!-- / Maps site -->

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
        <section class="forums-section">
            <div class="row-section">
                <div class="name-forums-sect">
                    <div class="title-forums-sect">
                        <h1>
                            <?php 
                                echo $rowFors1['title'];
                            ?>
                        </h1>
                    </div>
                    <?php 
                    if (!isset($_SESSION['username'], $_SESSION['password'])) {
                        echo '<div><i>Чтобы создать тему Вам нужно авторизироваться на форуме.</i></div>';
                    } else {
                    ?>  
                        <div class="button-forums-create">
                            <a href="<?php echo 'create-threads?act='.$rowFors1['id'].'&f='.$rowFors1['forum_id'] ?>"><i class="mdi mdi-pencil"></i> Создать тему</a>
                        </div>
                    <?php 
                        }   
                    ?>
                </div>
                <?php
                    if ($rowFors1['threads_num'] <= 0) {
                ?>
                    <div class="search-danger">
                        <i class="fas fa-exclamation-triangle"></i> 
                        В этом форуме пока нет ни одной темы.
                    </div>
                <?php   
                    } else {
                        $stmts = $PDO->prepare("SELECT * FROM `threads` WHERE `forums_id` = :id ORDER BY `date`");
                        $stmts->execute([
                            ':id' => $rowFors1['id']
                        ]);

                        
                ?>
                    <div class="f-theme-list">
                        <div class="filter-theme"></div>
                        <ul>
                            <?php
                                while($themes = $stmts->fetch()) {

                                    $sqlUser = $PDO->query("SELECT * FROM `users` WHERE `id` = $themes[author_id]");
                                    $us = $sqlUser->fetch();

                                    $ssw  = $PDO->query("SELECT count(*) FROM `answer` WHERE `threads_id` = " . $themes['id']);
                                    $rw = $ssw->fetch();
                            ?>
                            <li>
                                <div class="info-theme">
                                    <div class="img-author-theme">
                                    <img style="height:100%;width:100%;border-radius: 50%;" src="/static/img/avatar/<?php echo $us['avatar']; ?>" alt="avatar">
                                    </div>
                                    <div class="info-author-theme">
                                        <div class="inf-title-name">
                                            <a href="threads?f=<?php echo $themes['forums_id'] ?>&act=<?php echo $themes['id'] ?>"><?php echo $themes['title'] ?></a>
                                        </div>
                                        <div class="inf-user-name">
                                            <a href="/profile?name=<?php echo $themes['author'] ?>&act=<?php echo $themes['author_id'] ?>"><?php echo $themes['author'] ?></a><i><?php echo $themes['date'] ?></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="stat-theme"><dl>
                                    <dt>Ответы:</dt>
                                    <dd><?php echo $rw['count(*)'] ?></dd>
                                </dl>
                                <dl>
                                    <dt>Просмотры:</dt>
                                    <dd><?php echo $themes['views'] ?></dd>
                                </dl></div>
                            </li> 
                            <?php  
                                }
                        ?>   
                        </ul>
                    </div>
                <?php  
                    }
                ?>
            </div>
        </section>
    </article>
</main>
<!-- / Main (site content) -->

<?php require('template/base/footer.php'); ?>
</body>
</html>