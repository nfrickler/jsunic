<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');
?>
<h1><?php $this->set('SHOWRESETALL__H1'); ?></h1>
<p>
    <?php $this->set('SHOWRESETALL__INFOTEXT'); ?>
</p>
<p class="error">
    <?php $this->set('SHOWRESETALL__WARNING'); ?>
</p>
<p>
    <a href="?event=resetAll"><?php $this->set('SHOWRESETALL__RESETALL'); ?></a>
</p>
