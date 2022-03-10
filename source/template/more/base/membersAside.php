<aside class="aside">
    <div class="aside-users-last">
        <h3><i class="far fa-list-alt"></i> Новые пользователи</h3>
        <div class="aside-users-last-block">
            <ul class="aside-users-last-ul" style="margin:0;padding:0">
                <?php 
                    $list = $PDO->query("SELECT * FROM `users` ORDER BY `id` DESC LIMIT 6");
                    while ($ar = $list->fetch()) {
                        ?>
                        <li>
                            <a title="<?php echo $ar['username'] ?>" href="/profile?name=<?php echo $ar['username'] ?>&act=<?php echo $ar['id'] ?>"><img style="width:65px;height:65px;border-radius:50%" src="/static/img/avatar/<?php echo $ar['avatar']; ?>" alt="avatar"></a>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>
</aside>