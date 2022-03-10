<?php 
function compress($buffer) {
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
    return $buffer;
}

header('Content-type: text/css');

ob_start("compress");

include('font/font.css');

include('utils/var.css');

include('core/normalize.css');
include('core/form.css');
include('core/add.css');
include('core/bbcode.css');

include('layout/wrapper.css');
include('layout/header.css');
include('layout/footer.css');
include('layout/aside.css');

include('utils/media.css');

ob_end_flush();
?>