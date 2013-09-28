<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');

// get global vars
global $AppHandler;
?>
<h1><?php $this->set('SHOWAPPS__H1'); ?></h1>
<p>
    <?php $this->set('SHOWAPPS__INFOTEXT'); ?>
</p>
<?php if ($AppHandler->getList()) { ?>
<table>
    <tr>
	<th>&nbsp;</th>
	<th><?php $this->set('SHOWAPPS__NAME'); ?></th>
	<th><?php $this->set('SHOWAPPS__VERSION'); ?></th>
	<th><?php $this->set('SHOWAPPS__DESCRIPTION'); ?></th>
	<th><?php $this->set('SHOWAPPS__AUTHOR'); ?></th>
	<th><?php $this->set('SHOWAPPS__STATUS'); ?></th>
	<th>&nbsp;</th>
    </tr>
    <?php foreach ($AppHandler->getList() as $index => $App) { ?>
    <tr class="packets__statusclass_<?php echo $App->getStatus(); ?>">
	<td>
	    <a href="?event=toggleActivated&amp;type=app&amp;name=<?php echo $App->get('name'); ?>">
	    <?php if ($App->get('activated')) { ?>
		<img src="templates/images/green.gif" class="toggleImage" /></a>
	    <?php } else { ?>
		<img src="templates/images/red.gif" class="toggleImage" /></a>
	    <?php } ?>
	</td>
	<td>
	    <?php echo $App->get('name'); ?>
	</td>
	<td>
	    <?php echo $App->get('version'); ?>
	</td>
	<td><?php echo $App->get('description'); ?></td>
	<td><?php echo $App->get('author'); ?></td>
	<td><?php $this->set($App->getStatus(true)); ?></td>
	<td>
	    <?php if (!$App->get('activated')) { ?>
	    <a href="?event=deleteApp&amp;name=<?php echo $App->get('name'); ?>">
		<?php $this->set('SHOWAPPS__ACTION_DELETE'); ?></a>
	    <?php } ?>
	</td>
    </tr>
    <?php } ?>
</table>
<p style="margin-top:10px;">
    <img src="templates/images/arrow_top2downright.gif" />
    <a href="?event=build" class="button_build"><?php $this->set('SHOWAPPS__BUILD'); ?></a>
</p>
<p>
    <?php $this->set('SHOWAPPS__BUILD_INFOTEXT'); ?></a>
</p>
<?php } else { ?>
<p style="font-weight:bold;">
    <?php $this->set('SHOWAPPS__NOAPPS'); ?>
</p>
<?php } ?>
