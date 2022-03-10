<!-- Footer -->
<footer id="footer" class="dtheme">
    <section class="foot-div">
    <?php
    if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
    ?>

        <!-- Создаем экземпляр компонента account для гостей на сайте -->
        <account-info :authorized="false"></account-info>
    <?php
    }
    else if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    ?>

        <!-- Создаем экземпляр компонента account для авторизированных -->
        <account-info :authorized="true"></account-info>
    <?php
    }
    ?> 

        <!-- Создаем экземпляр компонента global-section -->
        <global-section></global-section> 

        <!-- Создаем экземпляр компонента information -->
        <information></information>

    </section>

    <section class="copy">
		<div class="copy-div">
            <p class="copy-p"><?php echo '(c) ' . $config['title'] . ' 2020'; ?></p>
        </div>
        <!-- Yandex.Metrika informer 
            <a href="https://metrika.yandex.ru/stat/?id=54607720&amp;from=informer" 
                target="_blank" rel="nofollow">
                <img src="https://metrika-informer.com/informer/54607720/3_1_FFFFFFFF_EFEFEFFF_0_pageviews" style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="54607720" data-lang="ru" />
            </a> -->
        <!-- /Yandex.Metrika informer -->
    </section>
</footer>
<!-- / Footer -->

<!-- Include JS -->

<script>
document.addEventListener('DOMContentLoaded', (event) => {
                document.querySelectorAll('pre code').forEach((block) => {
                    hljs.highlightBlock(block);
                });
            });
</script>

<!-- Vue component -->
<script type="text/javascript" src="/static/js/vue/header.js"></script>
<script type="text/javascript" src="/static/js/vue/footer.js"></script>

<!-- jQuery -->
<script type="text/javascript" src="/static/js/vendor/jQuery/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="/static/js/vendor/jQuery/plugin.js"></script>

<script type="text/javascript" src="/static/js/core.js"></script>
<script type="text/javascript" src="/static/js/browser.js"></script>
<script type="text/javascript" src="/static/js/ajax.js"></script>

<!-- / Include JS -->
