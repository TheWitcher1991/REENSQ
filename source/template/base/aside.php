    <aside class="aside">
    <?php 
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {  
    ?>
        <div class="aside-users-profile feed">
            <div class="aside-profile-div">
                <div class="aside-profile-top">
                    <div class="img"><img src="/static/img/avatar/<?php echo $asa['avatar'] ?>" alt=""></div>
                    <div class="name">
                        <a class="userseee" href="/profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>"><?php echo $_SESSION['username'] ?></a>
                        <a class="prefs" href="/account/preferences">Настройки профиля</a>
                    </div>
                </div>
                <div class="aside-profile-bottom">
                    <?php
                        $sql = $PDO->query("SELECT * FROM `users` WHERE `id` = $_SESSION[id]");

                        $rowss = $sql->fetch();

                        $sqlnumT = $PDO->query("SELECT count(*) FROM `threads` WHERE `author_id` = $_SESSION[id]");
                    
                        $rowssT = $sqlnumT->fetch();

                        $sqlnumG = $PDO->query("SELECT count(*) FROM `answer` WHERE `author_id` = $_SESSION[id]");
                    
                        $rowssG = $sqlnumG->fetch();
                    ?>
                    <ul>
                        <li>
                            <span class="topss" title="Сообщения"><i class="far fa-comments"></i></span>
                            <span class="botss" ><?php echo $rowssG['count(*)']; ?></span>
                        </li>
                        <li>
                            <span class="topss" title="Публикации"><i class="far fa-clone"></i></span>
                            <span class="botss" ><?php echo $rowssT['count(*)']; ?></span>
                        </li>
                        <li>
                            <span class="topss"  title="Симпатии"><i class="far fa-thumbs-up"></i></span>
                            <span class="botss"><?php echo $rowss['like']; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
		<div class="aside-users-online dtheme feed">
            <h3><i class="fas fa-users"></i> Пользователей онлайн</h3>
            <div class="aside-online-block" style="padding: 10px">

                <?php //while ($arti = mysqli_fetch_assoc($us)) {
                    //echo strip_tags($arti['username']) . ', ';
                //} 
                $id = session_id();


                    $the = mysqli_query($link, "SELECT * FROM `threads`");
                    $theme_num = mysqli_fetch_array(mysqli_query($link,"SELECT count(*) FROM `threads`"));


                    $for_num = mysqli_fetch_array(mysqli_query($link,"select count(*) from forum_section"));

                    $user_num = mysqli_fetch_array(mysqli_query($link,"select count(*) from users"));

                    $comm_num = mysqli_fetch_array(mysqli_query($link,"select count(*) from answer"));
                
            
                    $us = mysqli_query($link, "SELECT * FROM users");
                    //$user_num = mysqli_fetch_array(mysqli_query($link,"select count(*) from users"));

                    //$us = mysqli_query($link, "SELECT * FROM users ORDER BY id LIMIT 40");

                    //while($ar = mysqli_fetch_assoc($us)) {
                      ///  echo strip_tags($ar['username']) . ', ';
                    //}
                    if ($id != "") {
                        $CurrentTime = time();
                        $LastTime = time() - 600;
                        $base = "session.txt";

                        $file = file($base);
                        $k = 0;

                        for ($i = 0; $i < sizeof($file); $i++) {
                            $line = explode("|", $file[$i]);
                            if ($line[1] > $LastTime) {
                                $ResFile[$k] = $file[$i];
                                $k++;
                            }
                        }

                        for ($i = 0; $i<@sizeof($ResFile); $i++) {
                            $line = explode("|", $ResFile[$i]);
                            if ($line[0]==$id) {
                                $line[1] = trim($CurrentTime)."\n";
                                $is_sid_in_file = 1;
                            }
                            $line = implode("|", $line); $ResFile[$i] = $line;
                        }
                          
                           $fp = fopen($base, "w");
                           for ($i = 0; $i<@sizeof($ResFile); $i++) { fputs($fp, $ResFile[$i]); }
                           fclose($fp);
                          
                           if (!$is_sid_in_file) {
                                $fp = fopen($base, "a-");
                                $line = $id."|".$CurrentTime."\n";
                                fputs($fp, $line);
                                fclose($fp);
                           }
                    }

                    

                    $onlineU = mysqli_query($link, "SELECT * FROM `online`");


                    while ($datas = mysqli_fetch_assoc($onlineU)) {

                        if ($datas['id'] != 'guest') {
                            $onlineSQL = mysqli_query($link, "SELECT * FROM `users` WHERE `username` = '$datas[id]'");
                            $ru = mysqli_fetch_assoc($onlineSQL);
    
                            if ($ru['role'] == 'admin') {
                                echo ' <a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'" style="color:#ff6969">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
                            } else if ($ru['role'] == 'moder') {
                                echo ' <a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'" style="color:#6f0">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
                            } else {
                                echo ' <a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'" style="color:rgb(140, 156, 189)">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
                            }

                        } else {
                            'нет';
                        }
                       
                    }

                    echo '<span style="display: block;
                    padding: 8px;
                    width: 100%;
                    margin: 6px 0 0 0;
                    font-size: 13px;
                    border-radius: 6px;
                    background: #22242b;">Всего: ' . sizeof(file($base)) . '</span>'; 

                    $list = mysqli_query($link, "SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1");
                    $lt = mysqli_fetch_assoc($list);
                ?>
                
            </div>
        </div>
        <?php
            if ($theme_num[0] > 0) {     
        ?> 
        <div class="aside-last-theme dtheme feed">
            <h3><i class="far fa-clock"></i> Последние публикации</h3>
            <div class="aside-last-theme-block">
                <ul>
                <?php
                    $sqlNewth = $PDO->query('SELECT * FROM `threads` ORDER BY `id` DESC LIMIT 5');
                    while ($news = $sqlNewth->fetch()) {
                        $sqlUserth = $PDO->query('SELECT * FROM `users` WHERE `id` = ' . $news['author_id']);
                        $userth = $sqlUserth->fetch();
                ?> 
                    <li>
                        <div class="aside-ln-left">
                            <span>
                                <img src="/static/img/avatar/<?php echo $userth['avatar'] ?>" alt="avatar">
                            </span>
                        </div>
                        <div class="aside-ln-right">
                            <div class="titles">
                                <a href="<?php echo '/threads?f='.$news['forums_id'].'&act='.$news['id']; ?>"><?php echo mb_strimwidth($news['title'], 0, 20, "..."); ?></a>
                            </div>
                            <div class="infosk">
                            <?php
                                        if ($userth['role'] == 'admin') {
                                            echo '<a href="/profile?name='.$userth['username'].'&act='.$userth['id'].'" style="color:#ff6969">'.mb_strimwidth($userth['username'], 0, 10, "...").'</a>';
                                        } else if ($userth['role'] == 'moder') {
                                            echo '<a href="/profile?name='.$userth['username'].'&act='.$userth['id'].'" style="color:#6f0">'.mb_strimwidth($userth['username'], 0, 10, "...").'</a>';
                                        } else {
                                            echo '<a href="/profile?name='.$userth['username'].'&act='.$userth['id'].'">'.mb_strimwidth($userth['username'], 0, 10, "...").'</a>';
                                            }
                                    ?><span><?php echo $news['date'] ?></span>
                            </div>
                        </div>
                    </li>
                <?php
                    }
                ?>
                </ul>
            </div>
        </div>
        <?php
            }

            if ($comm_num[0] > 0) {
                ?>
            <div class="aside-last-theme dtheme feed">
                <h3><i class="far fa-clock"></i> Последние ответы</h3>
                <div class="aside-last-theme-block">
               
                    
                    <ul>
                        <?php
                        $sqlNewth = $PDO->query('SELECT * FROM `answer` ORDER BY `id` DESC LIMIT 5');
                        while ($news = $sqlNewth->fetch()) {
                            $sqlUserth = $PDO->query('SELECT * FROM `users` WHERE `id` = ' . $news['author_id']);
                            $userth = $sqlUserth->fetch();

                            $sqlNewst = $PDO->query('SELECT * FROM `threads` WHERE `id` = ' . $news['threads_id']);
                            $newst = $sqlNewst->fetch();
                            ?>
                            <li>
                                <div class="aside-ln-left">
                            <span>
                                <img src="/static/img/avatar/<?php echo $userth['avatar'] ?>" alt="avatar">
                            </span>
                                </div>
                                <div class="aside-ln-right">
                                    <div class="titles">
                                        <a href="<?php echo '/threads?f='.$newst['forums_id'].'&act='.$newst['id'].'#answer-'.$news['id']; ?>"><?php echo mb_strimwidth($newst['title'], 0, 20, "..."); ?></a>
                                    </div>
                                    <div class="infosk">
                                    <?php
                                        if ($userth['role'] == 'admin') {
                                            echo '<a href="/profile?name='.$userth['username'].'&act='.$userth['id'].'" style="color:#ff6969">'.mb_strimwidth($userth['username'], 0, 10, "...").'</a>';
                                        } else if ($userth['role'] == 'moder') {
                                            echo '<a href="/profile?name='.$userth['username'].'&act='.$userth['id'].'" style="color:#6f0">'.mb_strimwidth($userth['username'], 0, 10, "...").'</a>';
                                        } else {
                                            echo '<a href="/profile?name='.$userth['username'].'&act='.$userth['id'].'">'.mb_strimwidth($userth['username'], 0, 10, "...").'</a>';
                                            }
                                    ?>
                                        <span><?php echo $news['date'] ?></span>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
    
                </div>
            </div>
            <?php
        }
        ?>
        <div class="aside-site-statistics dtheme feed">
            <h3><i class="fas fa-chart-bar"></i> Статистика форума</h3>
            <div class="aside-statistics-block">
                <dl>
                    <dt>Темы:</dt>
                    <dd><?php echo $theme_num[0]; ?></dd>
                </dl>
                <dl>
                    <dt>Комментарии:</dt>
                    <dd><?php echo $comm_num[0]; ?></dd>
                </dl>
                <dl>
                    <dt>Форумы:</dt>
                    <dd><?php echo $for_num[0]; ?></dd>
                </dl>
                <dl>
                    <dt>Пользователи:</dt>
                    <dd><?php echo $user_num[0]; ?></dd>
                </dl>
                <dl>
                    <dt>Новый пользователь:</dt>
                    <dd><a style="color:rgb(130, 107, 201)" href="/profile?name=<?php echo $lt['username'] ?>&act=<?php echo $lt['id'] ?>"><?php echo $lt['username']; ?></a></dd>
                </dl>
            </div>
        </div>
	</aside>