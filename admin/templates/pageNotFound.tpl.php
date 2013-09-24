<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');
?>
<h1><?php $this->set('PAGENOTFOUND__H1'); ?></h1>
<p class="error">
    <?php $this->set('PAGENOTFOUND__INFOTEXT'); ?>
</p>
