<!-- Header -->
<header id="header">
    <section class="header-section">
        <div class="nav-header dtheme">

            <!-- Создаем экземпляр компонента navigator -->
            <navigator></navigator> 
            <?php
            if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
                ?>

            <!-- Создаем экземпляр компонента right-navigator -->
            <right-navigator :aside="false"></right-navigator>

                <?php 
            } else if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
             
                $use = $PDO->query("SELECT * FROM `users`")->fetch();

                #?id=<?php echo $_SESSION['id']

                $ava = "SELECT * FROM `users` WHERE `id` = :id";

                $stmta = $PDO->prepare($ava);
                $stmta->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $stmta->execute();

                $asa = $stmta->fetch();

                $sql = "SELECT * FROM `notice` WHERE `who_id` = :who_id AND `status` = 0";
                $stmtNot = $PDO->prepare($sql);
                $stmtNot->bindParam(':who_id', $_SESSION['id'], PDO::PARAM_INT);
                $stmtNot->execute();

                $sql = "SELECT * FROM `lmessage` WHERE `who_id` = :who_id AND `status` = 0";
                $stmtMsg = $PDO->prepare($sql);
                $stmtMsg->bindParam(':who_id', $_SESSION['id'], PDO::PARAM_INT);
                $stmtMsg->execute();
                ?>  
                <div class="right">
                    <div class="right-bar-row">
                            <div class="p-popup-acount">
                                <div class="p-navgroup-popup">
                                    <a id="ls-nav" title="Личные сообщения" href="#" class="nav-group-popup1">
                                        <i class="far fa-envelope"></i>
                                        <?php
                                        if ($stmtMsg->rowCount() > 0) {
                                            echo '<em></em>';
                                        }
                                        ?>
                                    </a>
                                    <a id="notice-nav" title="Оповещения" href="#" class="nav-group-popup2">
                                        <i class="far fa-bell"></i>
                                        <?php
                                        if ($stmtNot->rowCount() > 0) {
                                            echo '<em></em>';
                                        }
                                        ?>
                                    </a>
                                    <span class="nav-group-span">
                                        <a class="nav-group-popup" style="cursor:pointer">
                                            <img style="width:32px;height:32px;border-radius:50%" src="/static/img/avatar/<?php echo $asa['avatar'] ?>" alt="avatar">
                                        </a>
                                        <a class="nav-group-popup" style="cursor:pointer;margin: 0 0 0 8px;color: #f3f3f3;">
                                            <?php echo $asa['username'] ?>
                                            <i style="font-size: 16px;margin: 0 0 0 4px;" class="fas fa-caret-down"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="account--message-popup" style="display: none;">
                                    <div class="row-mes titles">
                                        <h1>Личные сообщения</h1>
                                    </div>
                                    <div class="row-mes mains">
                                        <?php

                                        if ($stmtMsg->rowCount() <= 0) {
                                            echo '<div style="padding: 10px">У вас нет новых сообщений</div>';
                                        } else {
                                            echo '<ul>';
                                            while ($row = $stmtMsg->fetch()) {
                                                ?>
                                                <li>
                                                    <div class='header-msg-title'><a href='/account/message?whom=<?php echo $row['who'] ?>&act=<?php echo $row['id'] ?>'><?php echo $row['title'] ?></a></div>
                                                    <div class='header-msg-info'>
                                                        <?php
                                                        $sqlAuh = $PDO->query("SELECT * FROM `users` WHERE `id` = $row[author_id]");
                                                        $auh = $sqlAuh->fetch();

                                                        if ($auh['role'] == 'admin') {
                                                            echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'" style="color:#ff6969">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                                        } else if ($auh['role'] == 'moder') {
                                                            echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'" style="color:#6f0">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                                        } else {
                                                            echo '<a href="/profile?name='.$auh['username'].'&act='.$auh['id'].'">'.mb_strimwidth($auh['username'], 0, 30, "...").'</a>';
                                                        }
                                                        ?>
                                                        <span><?php echo $row['date'] ?></span>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            echo '</ul>';
                                        }

                                        ?>
                                    </div>
                                    <div class="row-mes bottoms">
                                        <a class="all-mes a-mes" href="/account/messages">Всё</a>
                                        <a class="new-mes a-mes" href="/account/message_add">Отправить сообщение</a>
                                    </div>
                                </div>
                                <div class="account--notice-popup" style="display: none;">
                                    <div class="row-mes titles">
                                        <h1>Уведомления</h1>
                                    </div>
                                    <div class="row-mes mains">
                                        <?php

                                        if ($stmtNot->rowCount() <= 0) {
                                            echo '<div style="padding: 10px">У вас нет новых уведомлений</div>';
                                        } else {
                                            echo '<ul>';
                                            while ($row = $stmtNot->fetch()) {
                                                ?>
                                                <li>
                                                    <div class="header-msg-img">
                                                        <img style="height:100%;width:100%;border-radius: 50%;" src="/static/img/avatar/<?php echo $asa['avatar'] ?>" alt="avatar">
                                                    </div>
                                                    <div class="header-info-title">
                                                        <div class='header-msg-title'><a href='/account/notice><?php echo $row['text'] ?></a></div>
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
                                    <div class="row-mes bottoms">
                                        <a class="all-mes a-mes" href="/account/notice">Показать всё</a>
                                    </div>
                                </div>
                                <div class="account--menu-popup" style="display: none;">
                                    <div class="menu-row">
                                        <div class="avatar-wrapper">
                                            <img style="width:96px;height:96px;border-radius:50%" src="/static/img/avatar/<?php echo $asa['avatar'] ?>" alt="avatar">
                                        </div>
                                        <div class="menu-row-content">
                                            <h3><a style="color: rgb(222, 229, 242);font-size: 21px;font-weight: 600;" href="/profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>"><?php echo $_SESSION['username'] ?></a></h3>
                                            <div style="margin: 0;" class="prof-param">
                                                <ul>
                                                    <li>
                                                        <span class="topss" title="Сообщения"><i class="far fa-comments"></i></span>
                                                        <span class="botss"><?php
                                                        
                                                        $sqlnumG = $PDO->query("SELECT count(*) FROM `answer` WHERE `author_id` = $_SESSION[id]");
                    
                                                        $rowssG = $sqlnumG->fetch();
                                                        
                                                        echo $rowssG['count(*)']; ?></span>
                                                    </li>
                                                    <li>
                                                        <span class="topss" title="Публикации"><i class="far fa-clone"></i></span>
                                                        <span class="botss"> <?php $sqlnumT = $PDO->query("SELECT count(*) FROM `threads` WHERE `author_id` = $_SESSION[id]");

                                                            $rowssT = $sqlnumT->fetch();  echo $rowssT['count(*)']; ?></span>
                                                    </li>
                                                    <li>
                                                        <span class="topss" title="Симпатии"><i class="far fa-thumbs-up"></i></span>
                                                        <span class="botss"><?php echo $asa['like'] ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="padding: 0;
                                    margin: 0;
                                    border: none;
                                    border-top: 1px solid rgb(65, 77, 88)">
                                    <ul class="menu-pop-list">
                                        <li><a href="/profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>">Ваш аккаунт</a></li>
                                        <li><a href="/account/preferences">Настройки</a></li>
                                        <li><a href="/account/security">Безопасность</a></li>
                                        <li><a href="/account/messages">Личные сообщения</a></li>
                                        <li><a href="/account/notice">Уведомления</a></li>
                                        <li><a href="/account/ref">Реферальная система</a></li>
                                    </ul>
                                    <hr style="margin: 0 6px;
                                    padding: 0;
                                    border: none;
                                    border-top: 1px solid rgb(65, 77, 88)">
                                    <a class="menu-logout" href="/logout">Выход</a>
                                </div>
                            </div>
                    </div>
                </div>
                <?php 
                }
            ?>
            
        </div>
    </section>
</header>
<!-- / Header -->

<!-- Header mobile -->
<div id="header-mobile-open">
    <i class="fas fa-bars"></i>
</div>

<div id="header-mobile">
    <section class="header-mobile-section">
        <nav class="nav-mobile-header">
            <div class="nav-mobile-logo">
                <h1>Меню</h1>
                <i class="fas fa-times"></i>
            </div>
            <ul class="ul-nav-mobile">
                <li>
                    <div class="ul-div-nav forum-m">
                        <div>
                            <a class="forum-a-mobile" href="/">Форумы </a>
                            <div class="i-d">
                                <i class="fas fa-chevron-down tog-for"></i>
                            </div> 
                        </div>
                    </div>
                </li>
                <li>
                    <div class="ul-div-nav m-no">
                        <a class="regul-a-mobile" href="/rules">Правила</a>
                    </div>
                </li>
                <li>
                    <div class="ul-div-nav m-no">
                        <a class="users-a-mobile" href="/members">Пользователи</a>
                    </div>
                </li>
                <?php 
                if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
                    ?>
                    <li>
                        <div class="ul-div-nav m-no">
                            <a class="log-a-mobile" href="/login"><i class="fas fa-sign-in-alt"></i> Вход</a>
                        </div>
                    </li>
                    <li>
                        <div class="ul-div-nav m-no">
                            <a class="reg-a-mobile" href="/register"><i class="fas fa-user-plus"></i> Регистрация</a>
                        </div>
                    </li>
                    <?php
                } else if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    $user_bd = mysqli_query($link, "SELECT * FROM `users`");
                    $usr = mysqli_fetch_assoc($user_bd);

                    #?id=<?php echo $_SESSION['id']
                        
                    $avt = mysqli_query($link, "SELECT * FROM `users` WHERE `id` = " . $_SESSION['id']);
                    $avn = mysqli_fetch_assoc($avt);
                    ?>
                    <li>
                        <div class="ul-div-nav prof-m">
                            <div>
                                <a class="nama-a-mobile" href="/profile?id=<?php echo $_SESSION['id'] ?>">
                                    <img style="width:32px;height:32px;border-radius:3px" src="/static/img/avatar/<?php echo $asa['avatar'] ?>" alt="avatar">
                                    <span><?php echo $_SESSION['username'] ?></span>
                                </a>
                                <div class="i-d">
                                    <i class="fas fa-chevron-down tog-prof"></i>
                                </div>
                                
                            </div>
                        </div>
                    </li>
                    <?php 
                }  
                ?>
            </ul>
        </nav>
    </section>
</div>
<!-- / Header mobile -->


<!-- Header block add -->
<section class="header-section-bottom">
    <nav class="hs-bottom-nav">
        <div class="flex-1 search-forum-block">
            <input autocompletetype="off" placeholder="Поиск..." type="search" name="search" id="search-forum-inp">
            <button type="submit" id="search-forum-bth">
                <i class="fa fa-search"></i>
            </button>
        </div>
        <div class="flex-2"></div>
    </nav>
</section>
<!-- / Header mobile -->

<!-- Arrow up -->
<div class="arrow-up-site">
	<div class="arrow-div">
		<i class="fas fa-angle-up"></i>
	</div>
</div>
<!-- / Arrow up -->
