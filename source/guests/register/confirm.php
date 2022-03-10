<?php
session_start();

$GetName = $_GET['name'];
$GetCode= $_GET['code'];

if (isset($_SESSION["$GetName-confirm"])) {

    if ($_SESSION["$GetName-confirm"]['code'] === $_GET['code']) {
        $username = $_SESSION["$GetName-confirm"]['login'];
        $email = $_SESSION["$GetName-confirm"]['email'];
        $password = $_SESSION["$GetName-confirm"]['password'];
        $avatar = $_SESSION["$GetName-confirm"]['avatar'];

        $sql = "SELECT * FROM `users` WHERE `username` = :username";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch();

        if ($row['username'] == true) {
            header('Location: /');
        } else {
            $sqlInto = "INSERT INTO `users`(`username`, `password`, `email`, `date`, `avatar`) 
                                            VALUES(:username, :password, :email, :times ,:avatar)";
            $sIn = $PDO->prepare($sqlInto);
            $sIn->execute([
                ':username' => $username,
                ':password' => $password,
                ':email' => $email,
                ':times' => $Date,
                ':avatar' => $avatar
            ]);


            $getUserSql = "SELECT * FROM `users` WHERE `username`= :username";
            $sGu = $PDO->prepare($getUserSql);
            $sGu->bindParam(':username', $username, PDO::PARAM_STR);
            $sGu->execute();

            $getUser = $sGu->fetch();

            $_SESSION['username'] = $getUser['username'];
            $_SESSION['password'] = $getUser['password'];
            $_SESSION['id'] = $getUser['id'];
            $_SESSION['email'] = $getUser['email'];
            $mhsgl = '....';
            unset($_SESSION["$GetName-confirm"]);
            header("Location: /");
            exit;

        }

    } else {
        \Reensq\plugin\lib\jQuery::notFound();
    }

} else {
    \Reensq\plugin\lib\jQuery::notFound();
}

/**if (isset($_SESSION["$GetName-confirm"])) {

    if (isset($_POST['confcod'])) {
        if ($_SESSION['confirm']['type'] == 'register') {
    
            $err = array();
    
            $codes = $_POST['code'];
            $codes = FormChars($codes);
    
            if ($_SESSION["$GetName-confirm"]['code'] != $codes) $err[] = 'Код указан неверно!';
            
            if ($_SESSION['captcha'] != array_search(strtolower($_POST['captcha']), $answers)) $err[] = 'Ошибка капчи!';
            //if (!$_POST['g-recaptcha-response']) $err[] = 'Заполните капчу!';
            
            if (empty($err)) {
                $recaptcha = $_POST['g-recaptcha-response'];
    
                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $key = '6LdkLZAUAAAAAGV8dQfz0EF6X_UMXIOXoIGSX-6o';
                $ip = $_SERVER['REMOTE_ADDR'];
                $capt_query = $url . '?secret=' . $key . '&response=' . $recaptcha . '&remoteip=' . $ip;
    
                $data = json_decode(file_get_contents($capt_query));
    
                $username = $_SESSION["$GetName-confirm"]['login'];
                $email = $_SESSION["$GetName-confirm"]['email'];
                $password = $_SESSION["$GetName-confirm"]['password'];
                $avatar = $_SESSION["$GetName-confirm"]['avatar'];
    
                $sql = "SELECT `id` FROM `users` WHERE `username`='$username'";
                $result = $PDO->query($sql);
    
                $row = $result->fetch();
    
                if ($row['username'] == $username) {
                    $err[] = "Произошла ошибка, пожалуйста повторите!";
                } else {
                    /* if ($username == 'admin') 
                        $role = 'admin';
                    else 
                        $role = 'user';

                    $sql2 = "INSERT INTO `users`(`username`, `password`, `email`, `date`, `avatar`) VALUES('$username', '$password', '$email', '$Date','$avatar')";
                    $result2 = $PDO->query($sql);
                    if ($result2 == 'TRUE') {
                        $id_s = "SELECT * FROM `users` WHERE `username`='$username'";
                        $id_r = $PDO->query($id_s);
    
                        $idrow = $id_r->fetch();

                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $_SESSION['id'] = $idrow['id'];
                        $_SESSION['email'] = $email;
                        $mhsgl = '....';
                        unset($_SESSION["$GetName-confirm"]['code'], $_SESSION["$GetName-confirm"]);
                        header("Location: /");
                        exit;
                    }
                }
            }
        }
    }*/
?>