<?php
require '_footer.tpl.php';
require 'functions.php';
session_start();
?>

<header>
    <?php require '_header.tpl.php'; ?>
</header>

<div class="container-xxl">
    <div class="range">
        <div class="row align-items-start">
            <?php articlesByRange() ?>
        </div>
    </div>
</div>