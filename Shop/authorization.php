<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
session_start();
$invalidLogin = false;
if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    unset($_SESSION['groups']);
}
if (isset($_POST['email']) && isset($_POST['password'])) {
    $query = "SELECT * FROM users WHERE email = '" . $_POST['email'] . "'";
    $dbLoginData = query($query);
    if ($dbLoginData) {
        $fetchedData = mysqli_fetch_assoc($dbLoginData);
        $userPassword = $_POST['password'];
        if (isset($fetchedData['password'])){
            $hash = $fetchedData['password'];
            if (password_verify("$userPassword", "$hash")) {
                $_SESSION['login'] = $fetchedData['id'];
                $query = "SELECT name FROM roles inner join users_roles ON id=role_id WHERE user_id = " . $_SESSION['login'];
                $result = query($query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $groups[] = $row['name'];
                }
                if (isset($groups)) {
                    $_SESSION['groups'] = $groups;
                } else {
                    $_SESSION['groups'] = false;
                }
                header("Location:/wellcome.php");
            }
        }
    } else {
        $fetchedData = false;
    }
    $invalidLogin = true;
}
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

?>
<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
    <h2 class="warning"><?=$invalidLogin === true?'Неверный логин или пароль':''?></h2>
  <form class="custom-form" action="authorization.php" method="post">
    <input type="email" name="email"  class="custom-form__input" required="">
    <input type="password" name="password" class="custom-form__input" required="">
    <button class="button" type="submit">Войти в личный кабинет</button>
  </form>
</main>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
