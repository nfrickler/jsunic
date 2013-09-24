<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');
?>
<h1><?php $this->set('SHOWINDEX__H1'); ?></h1>
<p>
    <?php $this->set('SHOWINDEX__INFOTEXT'); ?>
</p>
<h2><?php $this->set('SHOWINDEX__H2_INDEX'); ?></h2>
<dl>
    <dt><a href="?event=showApps"><?php $this->set('SHOWINDEX__DT_APPS'); ?></a></dt>
    <dd><?php $this->set('SHOWINDEX__DD_APPS'); ?></dd>
    <dt><a href="?event=showSystemcheck"><?php $this->set('SHOWINDEX__DT_SYSTEMCHECK'); ?></a></dt>
    <dd><?php $this->set('SHOWINDEX__DD_SYSTEMCHECK'); ?></dd>
    <dt><a href="?event=showConfig"><?php $this->set('SHOWINDEX__DT_CONFIG'); ?></a></dt>
    <dd><?php $this->set('SHOWINDEX__DD_CONFIG'); ?></dd>
    <dt><a href="?event=showTools"><?php $this->set('SHOWINDEX__DT_TOOLS'); ?></a></dt>
    <dd><?php $this->set('SHOWINDEX__DD_TOOLS'); ?></dd>
    <dt><a href="?event=showSetLogin"><?php $this->set('SHOWINDEX__DT_SETLOGIN'); ?></a></dt>
    <dd><?php $this->set('SHOWINDEX__DD_SETLOGIN'); ?></dd>
</dl>
