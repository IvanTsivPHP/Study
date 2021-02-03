<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

include $_SERVER['DOCUMENT_ROOT'] . '/templates/admNavMenu.php';
?>
    <main class="page-authorization">
        <h1 class="h h--1">У вас не достаточно прав для этого раздела.</h1>
    </main>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
