
<?php use Reensq\plugin\core\R; ?>

<article class="wrapper">
    <section class="row-glab">
        <div class="container-row">    
            <div class="row-div feed" id="communication">
                    <div style="" class="logos-row su dtheme">
                        <div>
                            <img src="static/img/section/security.png" alt="Свободное общение">
                            <h1>Информационная безопасность</h1>
                        </div>
                        <i class="fas fa-chevron-down su-i"></i>
                    </div>
                    <div class="row-list-section su-div dtheme">
                    <ul>
                            <!--<li>
                                <div class="name-for">
                                    <i class="mdi mdi-cogs"></i>
                                    <a href="#">Правила раздела</a>
                                </div>
                            </li>-->
                            <?php 
                                $fwSQL = $PDO->query("SELECT * FROM `forum_section` WHERE `forum_id` = 1");

                        
                                while ($fw = $fwSQL->fetch()) {
                                    $sNumO = $PDO->query("SELECT count(*) FROM `threads` WHERE `forums_id` = $fw[id]");
                                    $rowSo = $sNumO->fetch();
                                
                                    $ssw  = $PDO->query("SELECT count(*) FROM `answer` WHERE `threads_forums_id` = " . $fw['id']);
                                    $rw = $ssw->fetch();
                            ?>
                            <li>
                                <span class="f-icon">
                                    <i class="mdi mdi-shield-half-full"></i>
                                </span>
                                <div class="f-main"> 
                                    <a href="<?php echo 'forums?f='.$fw['link'].'&act='.$fw['id'].'&fd='.$fw['forum_id'] ?>"> <?php echo $fw['title'] ?></a>
                                    <div class="f-description"></div>
                                </div>
                                <div class="f-stats">
                                    <dl>
                                        <dd title="Публикации"><i class="far fa-clone"></i></dd>
                                        <dt title="Публикации"><?php echo $rowSo['count(*)'] ?></dt>
                                    </dl>
                                    <dl>
                                        <dd title="Комментарии"><i class="far fa-comments"></i></dd>
                                        <dt title="Комментарии"><?php echo $rw['count(*)'] ?></dt>
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
                                                } else if ($ru['role'] == 'moder') {
                                                    echo '<a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'" style="color:#6f0">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
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
            <div class="row-div feed" id="programming">
                        <div class="logos-row p dtheme">
                            <div>
                                <img src="static/img/section/programming.png" alt="Программирование">
                                <h1>Программирование</h1>
                            </div>
                            <i class="fas fa-chevron-down p-i"></i>
                        </div>
                        <div class="row-list-section p-div dtheme">
                            <ul>
                                <li>
                                    <div class="name-for">
                                        <i class="mdi mdi-visual-studio-code"></i> 
                                        <a href="#">C++ / C (Cи)</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li> 
                                    <div class="name-for">
                                        <i class="mdi mdi-visual-studio-code"></i> 
                                        <a href="#">C# / .NET</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div class="name-for">
                                        <i class="mdi mdi-language-java"></i>
                                        <a href="#">Java / Scala</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div class="name-for">
                                        <i class="mdi mdi-language-python"></i>
                                        <a href="#">Python</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div class="name-for">
                                    <i class="mdi mdi-ruby"></i>
                                        <a href="#">Ruby</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div class="name-for">
                                        <i class="mdi mdi-visual-studio-code"></i> 
                                        <a href="#">Delphi / Pascal / Perl / Basic</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div style="" class="name-for addhom">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-cogs"></i>
                                        </span>
                                        <div class="name-for-div">
                                            <a href="javascript:void(0);">Прочее</a>
                                            <ul>
                                                <li>
                                                    <i class="mdi mdi-cogs"></i>
                                                    <a href="#">Lua</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-cogs"></i>
                                                    <a href="#">Go</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-cogs"></i>
                                                    <a href="#">Rust</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-cogs"></i>
                                                    <a href="#">F#</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-cogs"></i>
                                                    <a href="#">Swift</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-cogs"></i>
                                                    <a href="#">Прочее</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                            </ul>
                        </div>
            </div>
            <div class="row-div feed" id="web_programming">
                        <div class="logos-row web-p dtheme">
                            <div>
                                <img src="static/img/section/programming.png" alt="Программирование">
                                <h1>Web-программирование</h1>
                            </div>
                            <i class="fas fa-chevron-down web-p-i"></i>
                        </div>
                        <div class="row-list-section web-p-div dtheme">
                            <ul>
                                <li>
                                    <div class="name-for">
                                        <i class="mdi mdi-language-php"></i>
                                        <a href="#">PHP</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li> 
                                    <div class="name-for">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-database"></i>
                                        </span>
                                        <div class="name-for-div">
                                            <a href="#">СУБД</a>
                                            <ul>
                                                <li>
                                                    <i class="mdi mdi-database"></i>
                                                    <a href="#">SQL</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-database"></i>
                                                    <a href="#">MySQL</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-database"></i>
                                                    <a href="#">DB2</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-database"></i>
                                                    <a href="#">Oracle</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-database"></i>
                                                    <a href="#">PostgreSQL</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-database"></i>
                                                    <a href="#">MongoDB</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div style="" class="name-for addhom">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-xml"></i>
                                        </span>
                                        <div class="name-for-div">
                                            <a href="javascript:void(0)"> HTML / CSS</a>
                                            <ul>
                                                <li style="width: 40%">
                                                    <i class="mdi mdi-xml"></i>
                                                    <a href="#">Bootstrap</a>
                                                </li>
                                                <li style="width: 40%">
                                                    <i class="mdi mdi-xml"></i>
                                                    <a href="#">Sass / Less / Stylus / Pug</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div class="name-for">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-language-javascript"></i> 
                                        </span>
                                        <div class="name-for-div">
                                            <a href="#">JavaScript</a>
                                            <ul>
                                                <li>
                                                    <i class="mdi mdi-language-typescript"></i> 
                                                    <a href="#">TypeScript</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-angularjs"></i> 
                                                    <a href="#">Angular JS</a>
                                                <li>
                                                    <i class="mdi mdi-vuejs"></i> 
                                                    <a href="#">Vue JS</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-language-javascript"></i> 
                                                    <a href="#">Node JS</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-language-javascript"></i> 
                                                    <a href="#">jQuery</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-react"></i> 
                                                    <a href="#">React JS</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                                <li>
                                    <div class="name-for">
                                        <i class="mdi mdi-xml"></i>
                                        <a href="#"> CMS / Движки сайтов</a>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                                </li>
                            </ul>
                        </div>
            </div>
            <div class="row-div feed" id="soft">
                    <div class="logos-row po dtheme">
                        <div>
                            <img src="static/img/section/soft.png" alt="Программное обеспечение">
                            <h1>Программное обеспечение</h1>
                        </div>
                        <i class="fas fa-chevron-down po-i"></i>
                    </div>
                    <div class="row-list-section po-div dtheme">
                        <ul>
                            <li>
                                    <div style="" class="name-for addhom">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-microsoft"></i>
                                        </span>
                                        <div class="name-for-div">
                                            <a href="javascript:void(0);">Операционные системы</a>
                                            <ul>
                                                <li>
                                                    <i class="mdi mdi-windows"></i>
                                                    <a href="#">Windows</a>
                                                </li>
                                                <li>
                                                    <i class="fab fa-linux"></i>
                                                    <a href="#">Linux</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-apple"></i>
                                                    <a href="#">Mac OS</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-android"></i>
                                                    <a href="#">Android</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-apple"></i>
                                                    <a href="#">IOS</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                            </li>
                            <li>
                                <div class="name-for">
                                    <i class="mdi mdi-briefcase-outline"></i>
                                    <a href="#">Утилиты</a>
                                </div>
                                <div class="info-for">
                                    <dl>
                                        <dd>Темы</dd>
                                        <dt>0</dt>
                                    </dl>
                                    <dl>
                                        <dd>Комментарии</dd>
                                        <dt>0</dt>
                                    </dl>
                                </div>
                            </li>
                            <li>
                                    <div style="" class="name-for addhom">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-adobe"></i>
                                        </span>
                                        <div class="name-for-div">
                                            <a href="javascript:void(0);">Adobe</a>
                                            <ul>
                                                <li>
                                                    <i class="mdi mdi-adobe"></i>
                                                    <a href="#">Photoshop</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-adobe"></i>
                                                    <a href="#">Lightroom</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-adobe"></i>
                                                    <a href="#">Illustrator</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-adobe"></i>
                                                    <a href="#">Premiere Pro</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-adobe"></i>
                                                    <a href="#">After Effects</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-adobe"></i>
                                                    <a href="#">Прочее</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                            </li>
                            <li>
                                <div class="name-for">
                                    <i class="mdi mdi-palette"></i>
                                    <a href="#">Дизайн</a>
                                </div>
                                <div class="info-for">
                                    <dl>
                                        <dd>Темы</dd>
                                        <dt>0</dt>
                                    </dl>
                                    <dl>
                                        <dd>Комментарии</dd>
                                        <dt>0</dt>
                                    </dl>
                                </div>
                            </li>
                            <li>
                                    <div style="" class="name-for addhom">
                                        <span class="name-for-i">
                                            <i class="mdi mdi-keyboard-variant"></i>
                                        </span>
                                        <div class="name-for-div">
                                        
                                            <a href="javascript:void(0);">Редакторы кода</a>
                                            <ul>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">PHPStorm</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">PyCharm</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">Visual studio code</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">WebStorm</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">Atom</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">Android studio</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">Sublime text</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">Microsoft VS</a>
                                                </li>
                                                <li>
                                                    <i class="mdi mdi-keyboard-variant"></i>
                                                    <a href="#">Прочее</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="info-for">
                                        <dl>
                                            <dd>Темы</dd>
                                            <dt>0</dt>
                                        </dl>
                                        <dl>
                                            <dd>Комментарии</dd>
                                            <dt>0</dt>
                                        </dl>
                                    </div>
                            </li>
                            <li>
                                <div class="name-for">
                                    <i class="mdi mdi-cogs"></i>
                                    <a href="#">Прочее</a>
                                </div>
                                <div class="info-for">
                                    <dl>
                                        <dd>Темы</dd>
                                        <dt>0</dt>
                                    </dl>
                                    <dl>
                                        <dd>Комментарии</dd>
                                        <dt>0</dt>
                                    </dl>
                                </div>
                            </li>
                        </ul>
                    </div>
            </div>
            <div class="row-div feed" id="work_forum">
                    <div class="logos-row rf dtheme">
                        <div>
                            <img src="static/img/section/settings.png" alt="Работа форума">
                            <h1>Работа форума</h1>
                        </div>
                        <i class="fas fa-chevron-down rf-i"></i>
                    </div>
                    <div class="row-list-section rf-div dtheme">
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
                                        <dd title="Публикации"><i class="far fa-clone"></i></dd>
                                        <dt title="Публикации"><?php echo $rowSo['count(*)'] ?></dt>
                                    </dl>
                                    <dl>
                                        <dd title="Комментарии"><i class="far fa-comments"></i></dd>
                                        <dt title="Комментарии"><?php echo $rw['count(*)'] ?></dt>
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
                                                } else if ($ru['role'] == 'moder') {
                                                    echo '<a href="/profile?name='.$ru['username'].'&act='.$ru['id'].'" style="color:#6f0">'.mb_strimwidth($ru['username'], 0, 30, "...").'</a>';
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
    </section>
</article>
<?php require("template/base/aside.php");?>
