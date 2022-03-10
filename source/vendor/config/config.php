<?php
session_start();

$config = array(
    'title' => 'REENSQ',
    'db' => array(
        'host' => '127.0.0.1',
        'user' => 'host1380908_reen',
        'password' => 'jon35015',
        'database' => 'host1380908_reensq'
    )
);

$rules = array(
    'email' => array(
        'pattern' => "/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/",
        'message' => 'E-mail указан неверно'
    ),
    'username' => array(
        'pattern' => "/^[a-zA-Z0-9_-]{3,30}$/",
        'message' => 'Имя может состоять из букв разных регистров, цифр, дефисов и подчёркиваний',
        'message_two' => "Имя должно быть не меньше 3-х символов и не больше 30-ти"
    ),
    'password' => array(
        'message' => 'Пароль должен быть не меньше 6 символов'
    ),
    'title_theme' => array(
        // TODO: Upgrade expression
        'pattern' => "/^[a-zA-Z0-9_-]{6,100}$/",
        'message' => 'Заголовок темы может состоять из букв, цифр, дефисов и подчёркиваний. И быть не меньше 6-ти и не больше 36-ти символов.',
        'message_two' => "Заголовок темы должен быть не меньше 6-ти символов и не больше 100."
    )
);

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

$answers = array(
    1 => '56'
);
