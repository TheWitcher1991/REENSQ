<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
?>
<?php 
Head('Чат | REENSQ');
?>

<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>

<!-- Maps site -->
<section class="navig">
    <div class="form-title-l">
        <h1 style="margin: 0 0 10px 0;">Чат</h1>
    </div>
</section>


<main style="overflow:auto; width:750px; height:300px; border:1px solid black; padding:5px; margin:0px; display:inline-block; background:#FFF; margin:32px 0 0 32px;" id="main">
    <article class="wrapper">
        <div id="msg-box">
            <ul style="list-style:none; padding:0px; margin:0px;">
            </ul>
        </div>
        <form id="t-box" action="" style="margin-left:32px;">
            <input type="text" class="msg" name="msg" style="width:500px;" >
            <input type="submit" value="Отправить" name="chat-go" style="margin-top:5px;">
        </form>
    </article>
</main>

<?php require('template/base/footer.php'); ?>

</body>
</html>
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>