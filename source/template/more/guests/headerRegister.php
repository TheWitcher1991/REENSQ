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
            <right-navigator :register="true"></right-navigator>
                <?php 
            } else if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

                $use = $PDO->query("SELECT * FROM `users`")->fetch();

                #?id=<?php echo $_SESSION['id']

                $ava = "SELECT * FROM `users` WHERE `id` = :id";

                $stmta = $PDO->prepare($ava);
                $stmta->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $stmta->execute();

                $asa = $stmta->fetch();
                ?> 
                            <div class="p-popup-acount">
                                <div class="p-navgroup-popup">
                                    <a style="cursor:pointer" class="nav-group-popup">
                                        <img style="width:22px;height:22px;border-radius:50%" src="/assets/img/avatar/<?php echo $asa['avatar']; ?>" alt="avatar">
                                    </a>
                                    <a title="Переписки" href="/" class="nav-group-popup1"><i class="far fa-envelope"></i></a>
                                    <a title="Оповещения" href="/" class="nav-group-popup2"><i class="far fa-bell"></i></a>
                                    <a style="margin: 0 0 0 12px;" title="Поиск" href="#" class="nav-group-popup3"><i class="fas fa-search"></i></a>
                                </div>
                                <div class="account--menu-popup" style="display: none;">
                                    <div class="menu-row">
                                        <div class="avatar-wrapper">
                                            <img style="width:96px;height:96px;border-radius:3px" src="/assets/img/avatar/<?php echo $asa['avatar'] ?>" alt="avatar">
                                        </div>
                                        <div class="menu-row-content">
                                            <h3><a style="color: rgb(222, 229, 242);font-size: 21px;font-weight: 600;" href="/profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>"><?php echo $_SESSION['username'] ?></a></h3>
                                            <div class="menu-row-info">
                                                <dl>
                                                    <dt>Сообщения:</dt>
                                                    <dd>0</dd>
                                                </dl>
                                                <dl>
                                                    <dt>Симпатии:</dt>
                                                    <dd>0</dd>
                                                </dl>
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
                                        <li><a href="/account/ref">Реферальная система</a></li>
                                    </ul>
                                    <hr style="margin: 0 6px;
                                    padding: 0;
                                    border: none;
                                    border-top: 1px solid rgb(65, 77, 88)">
                                    <a class="menu-logout" href="/logout">Выход</a>
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
