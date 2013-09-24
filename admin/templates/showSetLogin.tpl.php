<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');
?>
<h1><?php $this->set('SHOWSETLOGIN__H1'); ?></h1>
<p>
    <?php $this->set('SHOWSETLOGIN__INFOTEXT'); ?>
</p>
<form action="?event=setLogin" method="post" class="ts_form">
    <fieldset>
	<legend><?php echo $this->set('SHOWSETLOGIN__LEGEND'); ?></legend>
	<label for="system_users__formLogin__password"><?php echo $this->set('SHOWSETLOGIN__PASSWORD'); ?></label>
	<input type="password" name="pass" />
	<div style="clear:both;"></div>
    </fieldset>
    <input type="submit" value="<?php echo $this->set('SHOWSETLOGIN__SUBMIT'); ?>" />
</form>
