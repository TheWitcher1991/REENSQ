<?php 
session_start();

if (!empty($_POST['search'])) {

    $search = $_POST['search-text'];

    $sql = "SELECT * FROM `users` WHERE `username` = :id";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(':id', $search, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch();

    if ($row['username'] == true) {
        exit(header("Location: /profile?name=$row[username]&act=$row[id]"));
    } else {
        $err = "<div class='search-danger'><i class='fas fa-exclamation-triangle'></i> Указанный пользователь не найден. Пожалуйста, введите другое имя.</div>";
    }

}
?>
<?php 
Head('Пользователи | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a style="color: #7082a7;font-weight: bold" href="/members">Пользователи</a>
</section>
<!-- / Maps site -->

<!-- Main (site content)  -->
<main id="main">
    <article style="width:100%" class="wrapper-members">   
        <?php if ($err) echo $err; ?>
        <div class="search-members">
            <form action="" method="post">
                <div class="inputss">
                    <input type="text" name="search-text" class="search" placeholder="Поиск пользователя...">
                </div>
                <div class="button-search">      
                    <input type="submit" name="search" value="Найти">
                </div>
            </form>
        </div>
        <section class="section-members">
            <div class="members-row">
				<ul>
                    <?php

                        $data = $PDO->query('SELECT * FROM `users` ORDER BY `id` DESC LIMIT 28');

                        while ($use = $data->fetch()) { 
                    ?>
                            <li class="members-wrapper-list feed">
                                <div class="members-content-left">
                                    <div class="img">
                                        <span><img src="/static/img/avatar/<?php echo $use['avatar']; ?>" alt="avatar"></span>
                                    </div>
                                </div>
                                <div class="members-content-right">
                                    <div class="top-info">
                                        <?php
                                            if ($use['role'] == 'user') {
                                                echo "<a href=\"profile?name=$use[username]&act=$use[id]\" style=\"color:#d6d6d6\">$use[username]</a>";
                                            } else if ($use['role'] == 'admin') {
                                                echo "<a href=\"profile?name=$use[username]&act=$use[id]\" style=\"color:#f00\">$use[username]</a>";
                                            } else if ($use['role'] == 'moder') {
                                                echo "<a href=\"profile?name=$use[username]&act=$use[id]\" style=\"color:#d6d6d6\">$use[username]</a>";
                                            } else {
                                                echo "<a href=\"profile?name=$use[username]&act=$use[id]\" style=\"color:#d6d6d6\">$use[username]</a>";
                                            }

											$sqlnums = "SELECT count(*) FROM `threads` WHERE `author_id` = :id";
    										$sqlnumT = $PDO->prepare($sqlnums);
    										$sqlnumT->bindParam(':id', $use['id'], PDO::PARAM_INT);
    										$sqlnumT->execute();

	
                                            $rowssT = $sqlnumT->fetch();
                                            ?>
                                    </div>
                                    <div class="bottom-info">
                                        <div style="margin: 0;" class="prof-param">
                                            <ul>
                                                <li>
                                                    <span class="topss" title="Регистрация">Регистрация</span>
                                                    <span class="botss"><?php echo $use['date']; ?></span>
                                                </li>
                                                <li>
                                                    <span class="topss" title="Публикации">Публикации</span>
                                                    <span class="botss"> <?php
                                                    
                                                    $sqlnums = "SELECT count(*) FROM `threads` WHERE `author_id` = :id";
    										        $sqlnumT = $PDO->prepare($sqlnums);
    										        $sqlnumT->bindParam(':id', $use['id'], PDO::PARAM_INT);
    										        $sqlnumT->execute();

                                                    $rowssT = $sqlnumT->fetch();  
                                                    echo $rowssT['count(*)']; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>





                    <?php
                        }
                    ?>
				</ul>
            </div>
            <?php require('template/more/base/membersAside.php'); ?>
        </section>
    </article>
</main>
<!-- Main (site content) -->

<?php require('template/base/footer.php'); ?>
</body>
</html>
