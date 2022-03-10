<?php
session_start();

# Основные файлы
require_once 'vendor/config/config.php';
require_once 'vendor/database/db.php';

# Библиотеки
require_once 'vendor/lib/phpQuery/phpQuery/phpQuery.php';
# require_once 'vendor/lib/SEOstats/SEOstats.php';
# require_once 'vendor/lib/RegExp/RegExpBuilder.php';

# MVC-REENSQ
require_once 'vendor/HTMLREditor/Parser.php';
require_once 'vendor/MVC/core/Router.php';
require_once 'vendor/MVC/lib/jQuery.php';
require_once 'vendor/MVC/core/DB.php';

use Reensq\plugin\core\Parser;
use Reensq\plugin\core\Router;
use Reensq\plugin\lib\jQuery;
use Reensq\plugin\core\R;

# Защита запросов от атак
$_GET  = jQuery::sanitize($_GET);

# Обрататываем подключение php классов
jQuery::autoLoadClass();

# Подключение к базе mysqli - old
$link = mysqli_connect(
    $config['db']['host'],
    $config['db']['user'],
    $config['db']['password'],
    $config['db']['database']
) or die(mysqli_error($link));

if (!$link) die('No DB connection!');

# ! Подключение PDO
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    global $PDO;
    $PDO = new PDO('mysql:host=localhost;dbname=host1380908_reensq', 'host1380908_reen', 'jon35015', $opt);
} catch (PDOException $e) {
    die($e->getMessage());
}

// online
if ($_SESSION['username']) {
    $user = $_SESSION['username'];
} else {
    $user = 'guest';
}


if ($user !== 'guest') {
    $online = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM `online` WHERE `id` = '$user'"));
}


if ($online['ip']) {
    mysqli_query($link, "UPDATE `online` SET `times` = NOW() WHERE `ip` = '$_SERVER[REMOTE_ADDR]'");
} else if ($online['id'] and $online['id'] != 'guest') {
    mysqli_query($link, "UPDATE `online` SET `times` = NOW() WHERE `id` = '$user'");
} else {
    mysqli_query($link,"INSERT INTO `online` (`ip`, `id`, `times`) VALUES('$_SERVER[REMOTE_ADDR]', '$user', NOW())");
}


mysqli_query($link, "DELETE FROM `online` WHERE `times` < SUBTIME(NOW(), '0 0:5:0')");


/*========================
    Маршрутизация
========================
*/
$query = rtrim($_SERVER['QUERY_STRING'], '/');

/*define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/MVC/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/MVC/vendor');
define('LAYOUT', 'home');*/

if ($_SERVER['REQUEST_URI'] === '/') {
    $Page = 'home';
    $Module = 'home';
} else {
    $URL_Path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $URL_Parts = explode('/', trim($URL_Path, ' /'));

    $Page = array_shift($URL_Parts);
    $Module = array_shift($URL_Parts);
    
    if (!empty($Module)) {
        $Param = array();

        foreach ($URL_Parts as $i => $iValue) {
            $Param[$iValue] = $URL_Parts[++$i];
        }
    } else { 
        $Module = '';  
    }
}

if (isset($_SESSION['username'], $_SESSION['password']) && in_array($Page, ['login', 'register', 'lost-password'])) {
    jQuery::notFound();
}


if (in_array($Page, ['home', 'rules', 'feed', 'members', 'bbcode', 'chat', 'profile', 'feedback', 'badbrowser'])) {
    
    include 'layout/' . $Page . '.php';

} else if (in_array($Page, ['forums',  'ajax', 'information_security', 'programming', 'web_programming', 'software', 'forum_work', 'threads', 'create-threads'])) {

    include 'forum/' . $Page . '.php';

} else if (in_array($Page, ['login', 'register', 'logout', 'lost-password'])) {

    include 'guests/' . $Page . '.php';
    
} else if ($Page == 'registers' && in_array($Module, ['requested', 'confirm'])) {

    include 'guests/register/' . $Module . '.php';

} else if ($Page == 'lost-passwords' && in_array($Module, ['requested', 'confirm'])) { 

    include 'guests/lost-password/' . $Module . '.php';

} else if ($Page == 'account' && in_array($Module, ['preferences', 'ref', 'security', 'notice', 'message', 'message_add', 'messages'])) {
   
    include 'authorized/' . $Module . '.php';

} else {
    jQuery::notFound();
}

/*
=================================
    Дополнительные функции
=================================
*/
function go($url) {
    return '{"go":'.$url.'"}';
}

function sendNotice($id, $text) {

    $monthes = array(
        1 => '01',
        2 => '02',
        3 => '03',
        4 => '04',
        5 => '05',
        6 => '06',
        7 => '07',
        8 => '08',
        9 => '09',
        10 => '10',
        11 => '11',
        12 => '12'
    );

    $Date = date('d') . '.' . $monthes[(date('n'))] . '.' . date('Y, H:i');


    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $PDOS = new PDO('mysql:host=localhost;dbname=host1380908_reensq', 'host1380908_reen', 'jon35015', $opt);

    $stmt = $PDOS->prepare("INSERT INTO `notice` (`who_id`, `date`, `text`) VALUES(:ids, :dats, :cnt)");
    $stmt->execute([
        ':ids' => $id,
        ':dats' => $Date,
        ':cnt' => $text
    ]);

}


function not_found() {
	exit(include("layout/404.php"));
}

function random_str ($num) {
    return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxzyABCDEFGHIJKLMNOPQRSTUVWXZY'), 0, $num);
}

function getUrl () {
    $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
    $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
    $url .= $_SERVER["REQUEST_URI"];
    return $url;
}    

function captcha_show () {

    $questions = array(
        1 => '7 * 8'
    );

    $num = mt_rand(1, count($questions) );
    $_SESSION['captcha'] = $num;

    echo $questions[$num];
}

# защита данных
function FormChars($pl) {

    return trim($pl);

}

function FormCharsPass($pl) {

    return $pl; 

}

function defenderXss($arr) {
    $filter = array("<", ">", "=", "(",")", ";", "/");

    foreach($arr as $num => $xss) {
        $arr[$num] = str_replace($filter, "|", $xss);

    }

    return $arr;
}

$_REQUEST = defenderXss($_REQUEST);

# шаблон для письма на почту 
function send_mail($email, $title, $h1, $p, $text, $sub, $rel) {

    $charset = 'utf-8';
    $from = 'REENSQ | FORUM';
    $headers = "MIME-Version: 1.0\n";
    $headers .= "From: =?$charset?B?".base64_encode('Администратор REENSQ | FORUM')."?= <$from>\n";
    $headers .= "Content-type: text/html; charset=$charset\n";
    $headers .= "Content-Transfer-Encoding: base64\n";

    mail("=?$charset?B?".base64_encode($email)."?= <$email>", "=?$charset?B?".base64_encode($title)."?=", "<!DOCTYPE html>
    <html lang='ru'>
    <head>
        <title>$title</title>
        <meta charset='UTF-8'>
        <link href='https://fonts.googleapis.com/css?family=Nunito:400,600,600i,700,700i,800,800i,900,900i&display=swap&subset=latin-ext,vietnamese' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900,900i&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese' rel='stylesheet'>
        <style>
            * {
                box-sizing: border-box;
            }
            body {
                background: #17191f;
                font-size: 15px;
                font-weight: normal;
                color: #333;
                margin: 0;
                padding: 0;
                font-family: 'Nunito', sans-serif;
            }
            #wrapper {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                background: rgb(37, 47, 57)
            }
            .title {
                margin: 0;
                background: rgb(37, 47, 57);
                color: rgb(120,187,230);
                width: 100%;
            }
            .title > h1 {
                margin: 0;
                font-weight: 800;
                padding: 15px 10px;
                font-family: 'Roboto', sans-serif;
                font-size: 30px;
            }
            .container {
                max-width: 560px;
                background: rgb(37, 47, 57);
                margin: 30px auto;
                padding: 10px 15px;
                box-shadow: 0 4px 15px 0 rgba(0,0,0,0.2);
                border-radius: 3px;
            }
            .info {
                background: rgb(37, 47, 57);
                padding: 15px;
                text-align: center;
                color: rgb(120,187,230);
                width: 100%;
            }
            .info > a {
                color: rgb(120, 187, 230);
                font-size: 18px;
                text-align: center;
            }
            .md-t {
                text-align: left;
            }
            .con-title {
                font-size: 22px;
                color: rgb(184, 196, 224);
            }
            .md-t > p {
                font-size: 18px;
                color: rgb(184, 196, 224);
            }
        </style>
    </head>
    <body style='background: rgb(28, 38, 47)'>

        <main id='wrapper'>
            <header class='title'>
                <h1>REENSQ | FORUM</h1>
            </header>
            <div class='container'>
                <div class='md-t'>
                    <h1 class='con-title'>Приветствую, $h1</h1>
                    <p>
                        $p
                        <br />
                        $text
                    </p>
                    <a style='color:#fff;max-width: 160px;margin: 0 auto;box-sizing: content-box;font-size: 15px;background: linear-gradient(rgb(117,172,208),rgb(58,129,175));padding: 10px;
                    display: block;
                    text-decoration: none;
                    border-radius: 3px;box-shadow: 0 4px 15px 0 rgba(0,0,0,0.2);text-align: center;' class='reld' href='".$rel."'>$sub</a>
                    </br />
                    <p style='font-size: 16px;margin-top: 10px;'>
                        Если Вы не запрашивали это письмо, то можете спокойно его проигнорировать.
                    </p>
                </div>
            </div>
            <footer class='info'>
                <a href='https://reensq.breusav.ru/'>Наш форум</a>
            </footer>
        </main>

    </body>
    </html>", $headers, "-f$from");
}

function Head ($title) {
    echo '<!DOCTYPE html>
<!--[if lt IE 7 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie6" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 7 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie7" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 8 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie8" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if IE 9 ]><html itemscope itemtype="https://schema.org/WebPage" class="ie ie9" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html itemscope itemtype="https://schema.org/WebPage" lang="ru" prefix="og: http://ogp.me/ns#" dir="ltr">
<head>

    <!--
     _    _   _   _
    | |  | | (_) | |
    | |__| | | | | |
    |  __  | | | |_|
    | |  | | | |  _
    |_|  |_| |_| |_|

    Welcome to code;)

    -->

    <meta charset="utf-8" />

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start":
    new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src=
    "https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,"script","dataLayer","GTM-NDXXWH3");</script>
    <!-- End Google Tag Manager -->

    <!-- SEO -->
    <title itemprop="name">'.$title.'</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="description" content="REENSQ - форум тему на программирование, где каждый может найти что-то для себя" />
    <meta name="robots" content="noodp"/>
    <meta name="keywords" content="" />
    <link rel="canonical" href="http://reensq.breusav.ru/">  
    <link rel="publisher" href="https://plus.google.com/+SitehereRu"/>
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="REENSQ - форум тему на программирование, где каждый может найти что-то для себя" />
    <meta property="og:url" content="http://reensq.breusav.ru/" />
    <meta property="og:site_name" content="REENSQ | FORUM FOR CODERS" />
    
    <meta name="theme-color" content="#1c262f" /> 

    <link rel="manifest" href="manifest.json">

    <script type="application/ld+json">{"@context": "http:\/\/www.schema.org","@type": "WebSite","@id":"#website","mainEntityOfPage": "http:\/\/reensq.breusav.ru\/","name":"forum","url":"http:\/\/reensq.breusav.ru\/","potentialAction":{"@type":"SearchAction","query-input":"required name=search_term_string","target":"http:\/\/reensq.breusav.ru\/search?q={search_term_string}"},"inLanguage":[{"@type": "Language","name": "English (USA)","alternateName":"en-US"},{"@type":"Language","name":"\u0420\u0443\u0441\u0441\u043a\u0438\u0439 (Russian)","alternateName":"ru-RU"}]}</script>
    
    <meta name="google-site-verification" content="FeCTWdLPVImH4u1_reWrlAT2YmYDj4plD8cj4LSmltc" />
    <!-- / SEO  -->


    <!-- Include style web-site -->
    <link rel="stylesheet" href="/static/css/css.php" />
    <!-- / Include style web-site -->

    <!-- Include libs and framework ... -->

    <!-- Vue.js -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10"></script>
    
    <!-- Socket.io -->
    <!-- <script src="/static/js/vendor/socket.io/socket.io.js"></script> -->

    <!-- Modernizr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>

    <!-- HTMLREditor style -->
    <link rel="stylesheet" href="/static/js/vendor/HTMLREditor/style/htmlreditor.bundle.css" />

    <!-- Highlight -->
    <script src="/static/js/vendor/highlight/highlight.pack.js"></script>
    <link rel="stylesheet" href="/static/js/vendor/highlight/styles/atom-one-dark.css">

    <!-- Icons and fonts -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.7.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" />
	<script src="https://use.fontawesome.com/7d8367315e.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Monofett|Space+Mono:400i,700,700i|Teko:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <!-- / Include libs and framework ... -->

    <!-- Script for old browsers -->
    <script type="text/javascript">
        (function () {

            "use strict";

            // создание XmlHttpRequest объекта
            function createXmlHttpRequestObject () {
                var xmlHttp;

                // следующий код работает во всех браузерах кроме IE6 и более ранних версиях
                try {
                    xmlHttp = new XMLHttpRequest();
                } catch (e) {
                    // событие происходит если используется IE6 или более раняя версия
                    var XmlHttpVersions = new Array("MSXML2.XMLHHTP.6.0",
                                                    "MSXML2.XMLHHTP.5.0",
                                                    "MSXML2.XMLHHTP.4.0",
                                                    "MSXML2.XMLHHTP.3.0",
                                                    "MSXML2.XMLHHTP",
                                                    "Microsoft.XMLHHTP");
                    // попоробовать все возможные версии
                    for (var i = 0; i < XmlHttpVersions.length && !xmlHttp; i++) {
                        try {
                            xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
                        } catch (e) { }
                    }           
                }

                if ((typeof xmlHttp !== "undefined") && (xmlHttp !== null)) {
                    return xmlHttp;
                } else {
                    return;
                }
            }

            function trackOldBrowserEvent () {
                var xhr = createXmlHttpRequestObject();

                var url = new Object();

                url["open"] = "/badbrowser?status=" + (xhr.status !== 0 ? xhr.status : false);
                url["xhr"] = xhr.responseURL ? xhr.responseURL : "/badbrowser?status=" + (xhr.status !== 0 ? xhr.status : false);

                // Передаётся GET параметром status (int)
                xhr.open("GET", url["open"], true);

                xhr.setRequestHeader("Content-Type", "text/html");
                xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if ((xhr.status >= 200 && xhr.status < 300) || xhr.status === 304 || (xhr.status === 0 && protocol === "file:")) {
                            try {
                                // Редирект на страницу
                                location.replace(xhr.responseURL ? xhr.responseURL : "/badbrowser?status=" + xhr.status);
                            } catch(e) {}
                        }
                    } else {
                        return;
                    }
                }

                xhr.send(url["xhr"] ? url["xhr"] : null);

                return xhr;
            }
            
            function checkOldBrowser() {
                if (!document.body) {
                    setTimeout(checkOldBrowser, 100);
                    return;
                }

                try {
                    if (!("CSS" in window && CSS.supports("display", "flex")) || typeof Symbol === "undefined") {
                        trackOldBrowserEvent();
                    }
                } catch (e) { }
            }

            checkOldBrowser();

        })();
    </script>
    <!-- / Script for old browsers -->

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" async="" src="https://mc.yandex.ru/metrika/watch.js"></script>
    <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter54607720 = new Ya.Metrika({ id:54607720, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/54607720" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>
';
}
?>

<section id="loader-site">
    <div class="sk-circle-bounce">
        <div class="sk-child sk-circle-1"></div>
        <div class="sk-child sk-circle-2"></div>
        <div class="sk-child sk-circle-3"></div>
        <div class="sk-child sk-circle-4"></div>
        <div class="sk-child sk-circle-5"></div>
        <div class="sk-child sk-circle-6"></div>
        <div class="sk-child sk-circle-7"></div>
        <div class="sk-child sk-circle-8"></div>
        <div class="sk-child sk-circle-9"></div>
        <div class="sk-child sk-circle-10"></div>
        <div class="sk-child sk-circle-11"></div>
        <div class="sk-child sk-circle-12"></div>
    </div>
</section>

<!--<section id="loader">
    <div class="row">
        <header id="header-load">
            <div class="head-load-list loader-row">
                <div class="flex-1">
                    <span class="logo-load"></span>
                    <span class="def"></span>
                    <span class="def"></span>
                    <span class="def"></span>
                    <span class="def"></span>
                </div>
                <div class="flex-2">
                    <span></span>
                </div>
            </div>
            <div class="head-load-search">
                <div class="loader-row head-load-search-row">
                    <span class="sea"></span>
                    <span class="acc"></span>
                </div>
            </div>
        </header>
        <article id="article-load" class="loader-row">
            <div class="art-load-flex-1">
                <div class="art-load-top"></div>
                <div class="art-load-bot">
                    <span class="first"></span>
                    <span class="second"></span>
                    <span class="first"></span>
                    <span class="second"></span>
                    <span class="first tsk"></span>
                    <span class="second tsk"></span>
                    <span class="first tsk"></span>
                </div>
            </div>
            <div class="art-load-flex-2">
                <div class="block-1">
                    <span class="top"></span>
                    <span class="bot"></span>
                </div>
                <div class="block-2">
                    <span class="top"></span>
                    <span class="bot"></span>
                </div>
                <div class="block-3">
                    <span class="top"></span>
                    <span class="bot"></span>
                </div>
            </div>
        </article>
    </div>
</section>-->
