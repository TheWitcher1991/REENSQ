<?php session_start();?>
<?php 
Head('BB-Коды | REENSQ');
?>
<body>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NDXXWH3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<?php require('template/more/base/headerNotAside.php'); ?>

<!-- Maps site -->
<section class="navig">
    <a style="color: #7082a7;font-weight: bold" href="/bbcode">BB-Коды</a>
</section>
<!-- / Maps site -->

<!-- Main (site content) -->
<main id="main">
    <article class="wrapper">
        <section class="row-glab">
            <div id="bbcode">
                <div class="row-div firsr-row-div">
                    <h1 class="regulations-log logos">BB-Коды</h1>
                    <div class="text-bbcode">
                        <h3>Что такое BB коды форума?</h3>
                        <p>Они предназначены для быстрого добавления различного форматирования текстов сообщений.
Ниже представлено описание этих кодов.</p>
                        <div class="bb-content">
                            <ul>
                                <li class="bb-li">
                                    <div>
                                        <h3 class="bbname">[B], [I], [U], [S] - полужирный, курсив, подчёркивание и зачёркивание</h3>
                                        <p>Делает выделенный текст полужирным, наклонным, подчёркнутым или зачёркнутым.</p>
                                        <div class="bbcodeexp">
                                            <dl class="bbcodeexp-item">
                                                <dt>Пример:</dt>
                                                <dd>
                                                    <div>
                                                        [B]Это полужирный текст.[/B]
                                                        <br />
                                                        [I]Это курсивный текст.[/I] 
                                                        <br />
                                                        [U]Это подчёркнутый текст.[/U]
                                                        <br />
                                                        [S]Это зачёркнутый текст.[/S]
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="bbcodeexp-item">
                                                <dt>Результат:</dt>
                                                <dd>
                                                    <div>
                                                        <b>Это полужирный текст</b>
                                                        <br />
                                                        <i>Это курсивный текст.</i>
                                                        <br />
                                                        <u>Это подчёркнутый текст.</u>
                                                        <br />
                                                        <s>Это зачёркнутый текст.</s>
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </li>
                                <li class="bb-li">
                                    <div>
                                        <h3 class="bbname">[COLOR=цвет], [FONT=название], [SIZE=размер] - цвет текста, шрифт и размер</h3>
                                        <p>Изменяет цвет, шрифт или размер выделенного текста.</p>
                                        <div class="bbcodeexp">
                                            <dl class="bbcodeexp-item">
                                                <dt>Пример:</dt>
                                                <dd>
                                                    <div>
                                                        Это [COLOR=red]красный[/COLOR].
                                                        <br />
                                                        Это [COLOR=#0000cc]синий[/COLOR]. 
                                                        <br />
                                                        [FONT=Courier New]Это шрифт Courier New[/FONT].
                                                        <br />
                                                        Это [SIZE=9]маленький[/SIZE] текст.
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="bbcodeexp-item">
                                                <dt>Результат:</dt>
                                                <dd>
                                                    <div>
                                                        Это <span style="color: red">красный</span>.
                                                        <br />
                                                        Это <span style="color: #0000cc">синий</span>.
                                                        <br />
                                                        <span style="font-family: 'Courier New'">Это шрифт Courier New</span>
                                                        <br />
                                                        Это <span style="font-size: 9px">маленький</span> текст.
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </li>
                                <li class="bb-li">
                                    <div>
                                        <h3 class="bbname">[URL=ссылка]</h3>
                                        <p>Делает выделенный текст ссылкой на интернет-страницу</p>
                                        <div class="bbcodeexp">
                                            <dl class="bbcodeexp-item">
                                                <dt>Пример:</dt>
                                                <dd>
                                                    <div>
                                                        [URL=https://www.example.com]Перейти на example.com[/URL]
                                                        <br />
                                                        [URL]https://www.example.com[/URL]
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="bbcodeexp-item">
                                                <dt>Результат:</dt>
                                                <dd>
                                                    <div>
                                                        <a target="_blank" href="https://www.example.com">Перейти на example.com</a>
                                                        <br />
                                                        <a target="_blank" href="https://www.example.com">https://www.example.com</a>
                                        
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </li>
                                <li class="bb-li">
                                    <div>
                                        <h3 class="bbname">[CODE] - вставка программного кода</h3>
                                        <p>Отображает текст на одном из языков программирования, выделяя синтаксис где это возможно.</p>
                                        <div class="bbcodeexp">
                                            <dl class="bbcodeexp-item">
                                                <dt>Пример:</dt>
                                                <dd>
                                                    <div>
                                                        C#-код:
                                                        <br/>
                                                        [CODE=cs]
                                                        <br />
                                                        using System;
                                                        <br />
                                                        <br />
                                                        class Program {
                                                        <br />
                                                        <span style="margin-left: 20px"></span>static void Main(string[] args) {
                                                        <br />
                                                        <span style="margin-left: 40px">Console.WriteLine("Hello World");
                                                        <br />
                                                        <span style="margin-left: 20px">}
                                                        <br />
                                                        }
                                                        <br/>
                                                        [/CODE]
                                                        <br />
                                                        <br />
                                                        JavaScript-код:
                                                        <br />
                                                        [CODE=js]
                                                        <br />
                                                        const hello = 'Hello World!';
                                                        <br />
                                                        document.write(document.cookie);
                                                        <br/>
                                                        [/CODE]
                                                        <br />
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="bbcodeexp-item">
                                                <dt>Результат:</dt>
                                                <dd>
                                                    <div>
                                                        C#-код:
                                                        <br />
                                                        <div class="code-outWrapper">
                                                            <div>C#:</div>
                                                            <pre>
                                                                <code>
using System;

class Program {
    static void Main(string[] args) {
        Console.WriteLine("Hello World");
    }
}
                                                                </code>
                                                            </pre>
                                                        </div>
                                                        <br />
                                                        JavaScript-код:
                                                        <br />
                                                        <div class="code-outWrapper">
                                                            <div>JavaScript:</div>
                                                            <pre>
                                                                <code>
const hello = 'Hello World!';
document.write(hello);
                                                                </code>
                                                            </pre>
                                                        </div>
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </article>
</main>
<!-- / Main (site content) -->

<?php require('template/base/footer.php'); ?>
</body>
</html>