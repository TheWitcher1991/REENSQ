<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

    $useeds = mysqli_query($link, "SELECT * FROM `users` WHERE `id` = " . $_SESSION['id']);
    $usde = mysqli_fetch_assoc($useeds);
?>
<?php 
Head('Реферальная система | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>

<!-- Maps site -->
<section class="navig">
    <div class="form-title-l">
            <h1 style="margin: 0 0 10px 0;">Реферальная система</h1>
    </div>
    <a style="color: #7082a7;font-weight: bold" href="/profile?id=<?php echo $_SESSION['id'] ?>">Ваш акаунт</a>
</section>

<main id="main">
    <article class="wrapper">
        <div class="ref-container">
            <b style="color: rgb(222, 229, 242);font-weight: 500;">Ваша реферальная ссылка:</b>
            http://reensq.breusav.ru/?referrer=<? echo $_SESSION['id'] ?>
        </div>
        <div class="ref-num">
            <?php
            $query = mysqli_query($link, "SELECT * FROM `users` WHERE `ref` = $_SESSION[id]");
            if (!mysqli_num_rows($query)) 
                echo 'У вас нет рефералов на данный момент.';
            else {
                echo 'всё норм!';
            }
            ?>
        </div>
    </article>
    <?php require('template/more/base/accountAside.php'); ?>
</main>

<?php require('template/base/footer.php'); ?>
</body>
</html>
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>