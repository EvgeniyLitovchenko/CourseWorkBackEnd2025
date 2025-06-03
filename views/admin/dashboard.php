<?php

use classes\Core;
?>
<div>
    <h1>Admin Dashboard</h1>
    <p>Hello <?= Core::getInstance()->session->get('user')['username'] ?></p>
</div>