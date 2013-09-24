<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');

// get global
global $Config;
?>
<h1><?php $this->set('SHOWSYSTEMCHECK__H1'); ?></h1>
<p>
    <?php $this->set('SHOWSYSTEMCHECK__INFOTEXT'); ?>
</p>
<table cellpadding="0" cellspacing="1" border="0">
    <?php if (is_dir($Config->get('dir_runtime'))) { ?>
    <tr>
	<th style="width:40%;"><?php $this->set('SHOWSYSTEMCHECK__FOLDER_RUNTIME'); ?></th>
	<td  style="width:30px; text-align:center;">
	    <?php if (is_writable($Config->get('dir_runtime'))) { ?>
		<img src="templates/images/good.gif" alt="Ok" class="checkSystem_good" />
	    <?php } else { ?>
		<img src="templates/images/bad.gif" alt="Bad" class="checkSystem_bad" />
	    <?php } ?>
	</td>
	<td class="table_info" onclick="javascript:toggleInfo('folder_runtime_info');">
	    <img src="templates/images/info.gif" class="table_info_img" id="folder_runtime_info_img" />
	    <div id="folder_runtime_info">
		<?php $this->set('SHOWSYSTEMCHECK__FOLDER_RUNTIME_INFO'); ?>
	    </div>
	</td>
    </tr>
    <?php } ?>
    <?php if (is_dir($Config->get('dir_data'))) { ?>
    <tr>
	<th style="width:40%;"><?php $this->set('SHOWSYSTEMCHECK__FOLDER_DATA'); ?></th>
	<td  style="width:30px; text-align:center;">
	    <?php if (is_writable($Config->get('dir_data'))) { ?>
		<img src="templates/images/good.gif" alt="Ok" class="checkSystem_good" />
	    <?php } else { ?>
		<img src="templates/images/bad.gif" alt="Bad" class="checkSystem_bad" />
	    <?php } ?>
	</td>
	<td class="table_info" onclick="javascript:toggleInfo('folder_data_info');">
	    <img src="templates/images/info.gif" class="table_info_img" id="folder_data_info_img" />
	    <div id="folder_data_info">
		<?php $this->set('SHOWSYSTEMCHECK__FOLDER_DATA_INFO'); ?>
	    </div>
	</td>
    </tr>
    <?php } ?>
    <tr>
	<th><?php $this->set('SHOWSYSTEMCHECK__PHPVERSION'); ?></th>
	<td style="text-align:center;">
	    <?php if ((strnatcmp(phpversion(), '5.3') >= 0)) { ?>
		<img src="templates/images/good.gif" alt="Ok" class="checkSystem_good" />
	    <?php } else { ?>
		<img src="templates/images/bad.gif" alt="Bad" class="checkSystem_bad" />
	    <?php } ?>
	</td>
	<td class="table_info" onclick="javascript:toggleInfo('phpversion_info');">
	    <div id="phpversion_info">
		<strong><?php echo phpversion(); ?></strong><br />
		<?php $this->set('SHOWSYSTEMCHECK__PHPVERSION_INFO'); ?>
	    </div>
	    <img src="templates/images/info.gif" class="table_info_img" id="phpversion_info_img" />
	</td>
    </tr>

    <tr>
	<th><?php $this->set('SHOWSYSTEMCHECK__IMAPFUNCTIONS'); ?></th>
	<td style="text-align:center;">
	    <?php if (function_exists('imap_timeout')) { ?>
		<img src="templates/images/good.gif" alt="Ok" class="checkSystem_good" />
	    <?php } else { ?>
		<img src="templates/images/neithernor.gif" alt="..." class="checkSystem_neithernor" />
	    <?php } ?>
	</td>
	<td class="table_info" onclick="javascript:toggleInfo('imapfunctions_info');">
	    <div id="imapfunctions_info">
		<?php $this->set('SHOWSYSTEMCHECK__IMAPFUNCTIONS_INFO'); ?>
	    </div>
	    <img src="templates/images/info.gif" class="table_info_img" id="imapfunctions_info_img" />
	</td>
    </tr>
</table>
<script type="text/javascript">

    // all info-fields
    var inputs = new Array();
    inputs[0] = 'folder_runtime_info';
    inputs[1] = 'phpversion_info';
    inputs[2] = 'imapfunctions_info';
    inputs[3] = 'folder_data_info';

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
