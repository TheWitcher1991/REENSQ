<div class="aside">
    <div class="account-aside-info aside-users-list">
        <h3><i class="far fa-list-alt"></i> Ваш аккаунт</h3>
        <div class="account-aside-info-block aside-users-list-block">
            <a class="blockLint" href="
                /profile?name=<?php echo $_SESSION['username'] ?>&act=<?php echo $_SESSION['id'] ?>"
                >Ваш профиль</a>
            <a class="blockLint-noti" href="/account/notice">Уведомления</a>
            <a class="blockLint-mes" href="/account/messages">Личные сообщения</a>
            <a class="blockLint-sym" href="">Симпатии</a>
        </div>
    </div>
    <div class="account-aside-preferences aside-users-list">
        <h3><i class="far fa-list-alt"></i> Настройки</h3>
        <div class="account-aside-preferences-block aside-users-list-block">
            <a class="blockLint-pref" href="/account/preferences">Настройки</a>
            <a class="blockLint-sec" href="/account/security">Безопасность</a>
            <a class="blockLint-ref" href="/account/ref">Реферальная система</a>
            <a class="blockLint" style="border-top: 1px solid rgb(65, 77, 88);" href="/logout">Выход</a>
        </div>
</div>