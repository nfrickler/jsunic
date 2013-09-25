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
<table>
    <tr>
	<th>&nbsp;</th>
	<th><?php $this->set('SHOWAPPS__MODNAME'); ?></th>
	<th><?php $this->set('SHOWAPPS__VERSION'); ?></th>
	<th><?php $this->set('SHOWAPPS__MODDESCRIPTION'); ?></th>
	<th><?php $this->set('SHOWAPPS__AUTHOR'); ?></th>
	<th><?php $this->set('SHOWAPPS__STATUS'); ?></th>
	<th><?php $this->set('SHOWAPPS__ACTION'); ?></th>
    </tr>
    <?php foreach ($AppHandler->getList() as $index => $App) { ?>
    <tr class="packets__statusclass_<?php echo $App->getStatus(); ?>">
	<td>
	    <a href="?event=toggleActivate&amp;type=app&amp;name=<?php echo $App->get('name'); ?>">
	    <?php if ($App->get('activated')) { ?>
		<img src="templates/images/good.gif" class="toggleImage" /></a>
	    <?php } else { ?>
		<img src="templates/images/bad.gif" class="toggleImage" /></a>
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
	    <?php switch ($App->getStatus()) {
	    case 5:
		?>
		<a href="?event=deleteApp&amp;name=<?php echo $App->get('name'); ?>">
		<?php $this->set('SHOWAPPS__ACTION_DELETE'); ?></a>
		<?php
		break;
		?>
	    <?php } ?>
	</td>
    </tr>
    <?php } ?>
</table>
<a href="?event=build"><?php $this->set('SHOWAPPS__BUILD'); ?></a>
