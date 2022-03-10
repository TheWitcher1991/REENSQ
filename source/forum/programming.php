<?php session_start();
Head('Форумы | Программирование');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/base/header.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a href="/">Форумы</a>
    <i style="margin: 0 5px" class="fas fa-chevron-right"></i>
    <a href="/programming" style="color: #7082a7;font-weight: bold">Программирование</a>
</section>

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
        <section class="row-glab">
            <div class="categories">
                <div class="row-div" id="programming">
                    <div class="logos-row">
                        <div>
                            <img src="/static/img/section/programming.png" alt="Программирование">
                            <h1>Программирование</h1>
                        </div>
                    </div>
                    <div class="categories-list">
                    <div class="row-list-section p-div ">
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
            </div>
        </section>
    </article>
	<?php require('template/base/aside.php'); ?>
</main>

<?php require('template/base/footer.php'); ?>
</script>
</body>
</html>