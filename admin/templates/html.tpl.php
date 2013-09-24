<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');

// global values
global $Config;
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="cache-control" content="no-cache" />
    <title><?php $this->setVar('title'); ?> | JSunic_Admin <?php echo $Config->getVersion(); ?></title>
    <link rel="stylesheet" type="text/css" href="format.css" />
</head>
<body>
    <?php if (!empty($_SESSION['admin_info'])) { ?>
    <div id="div_info">
	<?php $this->set($_SESSION['admin_info']); ?>
    </div>
    <?php unset($_SESSION['admin_info']); } ?>
    <?php if (!empty($_SESSION['admin_error'])) { ?>
    <div id="div_error">
	<?php $this->set($_SESSION['admin_error']); ?>
    </div>
    <?php unset($_SESSION['admin_error']); } ?>

    <?php if (isset($_SESSION['admin_auth']) AND !empty($_SESSION['admin_auth']) AND $Config->get('installation') <= 100 AND $Config->get('installation_progress')) { ?>
    <?php
	$event_next = '';
	foreach ($Config->get('installation_progress') as $index => $value) {
	    if (!$value) {
		$event_next = $index;
		switch ($event_next) {
		    case 'setLogin':
			$event_next = 'showSetLogin';
			break;
		    case 'setConfig':
			$event_next = 'showConfig';
			break;
		    case 'setStyles':
			$event_next = 'showStyles';
			break;
		    case 'parseAll':
			$event_next = 'showApps';
			break;
		}
		break;
	    }
	}
    ?>
    <div id="div_progress">
	<div id="div_progress_in" style="width:<?php echo $Config->get('installation'); ?>%;"></div>
	<div id="div_progress_tag">
	    <?php $this->set('HTML__INSTALLATIONPROGRESS'); ?> | <?php echo ((int) $Config->get('installation')); ?>%
	</div>
	<div id="div_progress_link">
	    <a href="?event=<?php echo $event_next ?>"><?php $this->set('HTML__INSTALLATION_NEXT'); ?></a>
	</div>
    </div>
    <?php } ?>
    <div id="div_jsunic">
	<div id="div_navig">
	    <ul>
		<?php if (isset($_SESSION['admin_auth']) AND !empty($_SESSION['admin_auth'])) { ?>
		<li><a href="?"><?php $this->set('HTML__INDEX'); ?></a></li>
		<li><a href="?event=showApps"><?php $this->set('HTML__APPS'); ?></a></li>
		<li><a href="?event=showStyles"><?php $this->set('HTML__STYLES'); ?></a></li>
		<li><a href="?event=showConfig"><?php $this->set('HTML__CONFIG'); ?></a></li>
		<li><a href="?event=showTools"><?php $this->set('HTML__TOOL'); ?></a></li>
		<li><a href="?event=doLogout"><?php $this->set('HTML__LOGOUT'); ?></a></li>
		<?php } else { ?>
		<li><a href="?"><?php $this->set('HTML__LOGIN'); ?></a></li>
		<?php } ?>
	    </ul>
	    <div style="clear:both;"></div>
	</div>
	<?php $this->display(false); ?>
	<div id="div_footer">
	    <p style="border-bottom:1px dashed #FFF; margin-bottom:10px;">
		<a href="?event=<?php echo $_GET['event']; ?>&amp;lang=en">English</a>
		| <a href="?event=<?php echo $_GET['event']; ?>&amp;lang=de">Deutsch</a>
	    </p>
	    Powered by <a href="http://jsunic.de" target="_blank"><?php echo $Config->getVersion(); ?></a> <br />
	    Copyright &copy;2012-2013 Nicolas Frinker
	</div>
    </div>
    <div class="div_jsunic_topright">
	<a href="../index.php" target="_blank">
	    <img src="templates/images/jsunic_logo.png" alt="JSunic Logo" style="width:80px; height:80px;" /></a>
    </div>
</body>
</html>
