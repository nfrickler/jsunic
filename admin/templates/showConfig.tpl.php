<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');

// get config-handler object
global $Config;

?>
<h1><?php $this->set('SHOWCONFIG__H1'); ?></h1>
<p>
    <?php $this->set('SHOWCONFIG__INFOTEXT'); ?>
</p>
<form action="?event=setConfig" method="post" class="ts_form">
    <fieldset>
	<legend><?php $this->set('SHOWCONFIG__LEGEND_ENCRYPTION'); ?></legend>
	<label for="set__encryption_class"><?php $this->set('SHOWCONFIG__ENCRYPTION_CLASS'); ?></label>
	<select name="set__encryption_class" id="set__encryption_class">
	    <option value="mcrypt" <?php if ($Config->get('encryption_class') == 'mcrypt') echo 'selected="selected"'; ?>>mcrypt</option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="encryption_class_info_img" onclick="javascript:toggleInfo('encryption_class_info');" />
	<div class="form_infobox" id="encryption_class_info" onclick="javascript:toggleInfo('encryption_class_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__ENCRYPTION_CLASS_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__encryption_algorithm"><?php $this->set('SHOWCONFIG__ENCRYPTION_ALGORITHM'); ?></label>
	<select name="set__encryption_algorithm" id="set__encryption_algorithm">
	    <option value="blowfish" <?php if ($Config->get('encryption_algorithm') == 'blowfish') echo 'selected="selected"'; ?>>blowfish</option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="encryption_algorithm_info_img" onclick="javascript:toggleInfo('encryption_algorithm_info');" />
	<div class="form_infobox" id="encryption_algorithm_info" onclick="javascript:toggleInfo('encryption_algorithm_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__ENCRYPTION_ALGORITHM_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__encryption_mode"><?php $this->set('SHOWCONFIG__ENCRYPTION_MODE'); ?></label>
	<select name="set__encryption_mode" id="set__encryption_mode" <?php if ($Config->get('encryption_mode') == 'ecb') echo 'selected="selected"'; ?>>
	    <option value="ecb">ecb</option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="encryption_mode_info_img" onclick="javascript:toggleInfo('encryption_mode_info');" />
	<div class="form_infobox" id="encryption_mode_info" onclick="javascript:toggleInfo('encryption_mode_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__ENCRYPTION_MODE_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__system_secret"><?php $this->set('SHOWCONFIG__SYSTEM_SECRET'); ?></label>
	<input type="text" name="set__system_secret" id="set__system_secret" value="<?php echo $Config->get('system_secret'); ?>" />
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="system_secret_info_img" onclick="javascript:toggleInfo('system_secret_info');" />
	<div class="form_infobox" id="system_secret_info" onclick="javascript:toggleInfo('system_secret_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__SYSTEM_SECRET_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
    </fieldset>
    <fieldset>
	<legend><?php $this->set('SHOWCONFIG__LEGEND_PATHS'); ?></legend>
	<label for="set__domain"><?php $this->set('SHOWCONFIG__DOMAIN'); ?></label>
	<input type="text" name="set__domain" id="set__domain" value="<?php echo $Config->get('domain'); ?>" />
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="domain_info_img" onclick="javascript:toggleInfo('domain_info');" />
	<div class="form_infobox" id="domain_info" onclick="javascript:toggleInfo('domain_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__DOMAIN_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__dir_admin"><?php $this->set('SHOWCONFIG__DIR_ADMIN'); ?></label>
	<input type="text" name="set__dir_admin" id="set__dir_admin" value="<?php echo $Config->get('dir_admin'); ?>" />
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="dir_admin_info_img" onclick="javascript:toggleInfo('dir_admin_info');" />
	<div class="form_infobox" id="dir_admin_info" onclick="javascript:toggleInfo('dir_admin_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__DIR_ADMIN_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__dir_runtime"><?php $this->set('SHOWCONFIG__DIR_RUNTIME'); ?></label>
	<input type="text" name="set__dir_runtime" id="set__dir_runtime" value="<?php echo $Config->get('dir_runtime'); ?>" />
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="dir_runtime_info_img" onclick="javascript:toggleInfo('dir_runtime_info');" />
	<div class="form_infobox" id="dir_runtime_info" onclick="javascript:toggleInfo('dir_runtime_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__DIR_RUNTIME_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
    </fieldset>
    <fieldset>
	<legend><?php $this->set('SHOWCONFIG__LEGEND_OTHERS'); ?></legend>
	<label for="set__default_language"><?php $this->set('SHOWCONFIG__DEFAULT_LANGUAGE'); ?></label>
	<select name="set__default_language" id="set__default_language">
	    <option value="de" <?php if ($Config->get('default_language') == 'de') echo 'selected="selected"'; ?>>Deutsch</option>
	    <option value="en" <?php if ($Config->get('default_language') == 'en') echo 'selected="selected"'; ?>>English</option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="default_language_info_img" onclick="javascript:toggleInfo('default_language_info');" />
	<div class="form_infobox" id="default_language_info" onclick="javascript:toggleInfo('default_language_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__DEFAULT_LANGUAGE_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__system_email"><?php $this->set('SHOWCONFIG__SYSTEM_EMAIL'); ?></label>
	<input type="text" name="set__system_email" id="set__system_email" value="<?php echo $Config->get('system_email'); ?>" />
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="system_email_info_img" onclick="javascript:toggleInfo('system_email_info');" />
	<div class="form_infobox" id="system_email_info" onclick="javascript:toggleInfo('system_email_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__SYSTEM_EMAIL_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__email_enabled"><?php $this->set('SHOWCONFIG__EMAIL_ENABLED'); ?></label>
	<select name="set__email_enabled" id="set__email_enabled">
	    <option value="true" <?php if ($Config->get('email_enabled') == true) echo 'selected="selected"'; ?>><?php $this->set('SHOWCONFIG__YES'); ?></option>
	    <option value="false" <?php if ($Config->get('email_enabled') == false) echo 'selected="selected"'; ?>><?php $this->set('SHOWCONFIG__NO'); ?></option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="email_enabled_info_img" onclick="javascript:toggleInfo('email_enabled_info');" />
	<div class="form_infobox" id="email_enabled_info" onclick="javascript:toggleInfo('email_enabled_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__EMAIL_ENABLED_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__system_online"><?php $this->set('SHOWCONFIG__SYSTEM_ONLINE'); ?></label>
	<select name="set__system_online" id="set__system_online">
	    <option value="true" <?php if ($Config->get('system_online') == true) echo 'selected="selected"'; ?>><?php $this->set('SHOWCONFIG__YES'); ?></option>
	    <option value="false" <?php if ($Config->get('system_online') == false) echo 'selected="selected"'; ?>><?php $this->set('SHOWCONFIG__NO'); ?></option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="system_online_info_img" onclick="javascript:toggleInfo('system_online_info');" />
	<div class="form_infobox" id="system_online_info" onclick="javascript:toggleInfo('system_online_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__SYSTEM_ONLINE_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
	<label for="set__allow_registration">
	    <?php $this->set('SHOWCONFIG__ALLOW_REGISTRATION'); ?>
	</label>
	<select name="set__allow_registration" id="set__allow_registration">
	    <option value="true" <?php if ($Config->get('allow_registration') == true) echo 'selected="selected"'; ?>><?php $this->set('SHOWCONFIG__YES'); ?></option>
	    <option value="false" <?php if ($Config->get('allow_registration') == false) echo 'selected="selected"'; ?>><?php $this->set('SHOWCONFIG__NO'); ?></option>
	</select>
	<img src="templates/images/info.gif" alt="Info" class="form_infoimg" id="allow_registration_info_img" onclick="javascript:toggleInfo('allow_registration_info');" />
	<div class="form_infobox" id="allow_registration_info" onclick="javascript:toggleInfo('allow_registration_info');">
	    <img src="templates/images/arrow_top2downright.gif" class="form_infoimg_in" />
	    <?php $this->set('SHOWCONFIG__ALLOW_REGISTRATION_INFO'); ?>
	</div>
	<div style="clear:both;"></div>
    </fieldset>

    <input type="submit" value="<?php echo $this->set('SHOWCONFIG__SUBMIT'); ?>" />
    <input type="reset" value="<?php echo $this->set('SHOWCONFIG__RESET'); ?>" />
</form>
<script type="text/javascript">

    // all info-fields
    var inputs = new Array();
    inputs[0] = 'encryption_class_info';
    inputs[1] = 'encryption_algorithm_info';
    inputs[2] = 'encryption_mode_info';
    inputs[3] = 'system_secret_info';
    inputs[4] = 'default_language_info';
    inputs[5] = 'system_email_info';
    inputs[6] = 'prefix_info';
    inputs[7] = 'email_enabled_info';
    inputs[8] = 'dir_admin_info';
    inputs[9] = 'dir_runtime_info';
    inputs[10] = 'system_online_info';
    inputs[11] = 'allow_registration_info';
    inputs[12] = 'domain_info';

    function hideInfo (id) {
	document.getElementById(id).style.display = 'none';
	document.getElementById(id+'_img').style.display = 'block';
	return true;
    }

    function showInfo (id) {
	document.getElementById(id).style.display = 'block';
	document.getElementById(id+'_img').style.display = 'none';
	return true;
    }

    function hideAll () {
	for (var i = 0; i < inputs.length; i++)
	    hideInfo(inputs[i]);
	return true;
    }

    function showAll () {
	for (var i = 0; i < inputs.length; i++)
	    showInfo(inputs[i]);
	return true;
    }

    function toggleInfo (id) {
	if (document.getElementById(id).style.display == 'none')
	    showInfo(id);
	else
	    hideInfo(id);

	return true;
    }

    // hide all
    hideAll();
</script>
