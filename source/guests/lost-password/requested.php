<?php
session_start();

$GetCodeRx = $_GET['code'];

if (isset($_SESSION["$GetCodeRx-recovery"]))  {

?>
<?php 
Head('Восстановление пароля | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>
    
    <main id="form-main-l">
            <div class="form-title-l">
                <h1>Восстановление пароля</h1>
            </div>
            <div class="alert alert-success" role="alert"><i class="far fa-check-circle"></i> <?php echo $_SESSION["$GetCodeRx-recovery"]['msg']; ?></div>
        </main>
    
        <?php require('template/base/footer.php'); ?>
</body>
</html>
<?php
} else {
    \Reensq\plugin\lib\jQuery::notFound();
}
?>