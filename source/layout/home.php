<?php session_start();
Head('Форумы | REENSQ');

use Reensq\plugin\core\R;

?>
<body>
<?php 

// ! IP клиента
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
if (filter_var($client, FILTER_VALIDATE_IP)) 
    $ip = $client;
elseif (filter_var($forward, FILTER_VALIDATE_IP)) 
    $ip = $forward;
else 
    $ip = $remote;

# echo $ip . '<br />';

?>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>



<!-- Maps site -->
<section class="navig">
    <a href="/" style="color: #7082a7;font-weight: bold">Форумы</a>
</section>
<!-- / Maps site -->

<!-- Main (site content) -->
<section class="index-forum-news-section">
        <div class="index-forum-news-div">
            <ul class="if-news">
                <li class="themes_s np activs dtheme">Новые публикации</li>
                <li class="comments pp dtheme">Популярные публикации</li>
                <li class="inform la dtheme">Последние ответы</li>
                <li class="likes lu dtheme">Новые пользователи</li>
            </ul>

            <div class="if-news-cnt dtheme">
                <div class="if-n-txt npd activs">
                    <ul class="txt_ul">
                        <?php
                        $sqlNew = $PDO->query('SELECT * FROM `threads` ORDER BY `id` DESC LIMIT 10');

                        while ($new = $sqlNew->fetch()) {
                            ?>
                            <li>
                                <div class="flex-1">
                                    <div class="cat"><?php echo $new['forums_name'] ?></div>
                                    <div class="title"><a href="<?php echo '/threads?f='.$new['forums_id'].'&act='.$new['id']; ?>"><?php echo $new['title'] ?></a></div>
                                </div>
                                <div class="flex-2">
                                    <div class="time"><?php echo $new['date'] ?></div>
                                </div>
                                <div class="flex-3">
                                    <div class="username"><a href="<?php echo '/profile?name='.$new['author'].'&act='.$new['author_id'] ?>"><?php echo $new['author'] ?></a></div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="if-n-txt ppd">
                    <ul class="txt_ul">
                        <?php
                        $sqlNews = $PDO->query('SELECT * FROM `threads` ORDER BY `views` DESC LIMIT 10');

                        while ($news = $sqlNews->fetch()) {
                            ?>
                            <li>
                                <div class="flex-1">
                                    <div class="cat"><?php echo $news['forums_name'] ?></div>
                                    <div class="title"><a href="<?php echo '/threads?f='.$news['forums_id'].'&act='.$news['author_id']; ?>"><?php echo $news['title'] ?></a></div>
                                </div>
                                <div class="flex-2">
                                    <div class="time">Просмотров: <?php echo $news['views'] ?></div>
                                </div>
                                <div class="flex-3">
                                    <div class="username"><a href="<?php echo '/profile?name='.$news['author'].'&act='.$news['author_id'] ?>"><?php echo $news['author'] ?></a></div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="if-n-txt lad">
                    <ul class="txt_ul">
                        <?php
                        $sqlNewth = $PDO->query('SELECT * FROM `answer` ORDER BY `id` DESC LIMIT 10');
                        while ($news = $sqlNewth->fetch()) {
                            $sqlUserth = $PDO->query('SELECT * FROM `users` WHERE `id` = ' . $news['author_id']);
                            $userth = $sqlUserth->fetch();

                            $sqlNewst = $PDO->query('SELECT * FROM `threads` WHERE `id` = ' . $news['threads_id']);
                            $newst = $sqlNewst->fetch();
                            ?>
                            <li>
                                <div class="flex-1">
                                    <div class="cat"><?php echo $newst['forums_name'] ?></div>
                                    <div class="title"><a href="<?php echo '/threads?f='.$newst['forums_id'].'&act='.$newst['id']; ?>"><?php echo mb_strimwidth($news['text'], 0, 20, "..."); ?></a></div>
                                </div>
                                <div class="flex-2">
                                    <div class="time"><?php echo $news['date'] ?></div>
                                </div>
                                <div class="flex-3">
                                    <div class="username"><a href="<?php echo '/profile?name='.$news['author'].'&act='.$news['author_id'] ?>"><?php echo mb_strimwidth($news['author'], 0, 20, "..."); ?></a></div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <div class="if-n-txt lud">
                    <ul class="txt_ul txt-ul-us">
                        <?php
                        $list = $PDO->query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 6");
                        while ($ar = $list->fetch()) {
                            ?>
                            <li>
                                <span>
                                    <i class="far fa-user"></i>
                                    <a href="/profile?name=<?php echo $ar['username'] ?>&act=<?php echo $ar['id'] ?>" ><?php echo $ar['username']; ?></a>
                                </span>
                                <i title="<?php echo 'Регистрация ' . $ar['date'] ?>" class="far fa-clock"></i>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<main id="main">
    
	<?php require('template/more/base/contentHome.php'); ?>
</main>
<!-- / Main (site content) -->

<?php require('template/base/footer.php'); ?>
</body>
</html>