<?php
// deny direct access
defined('JS_INIT') OR die('Access denied!');

// get global vars
global $StyleHandler;
?>
<h1><?php $this->set('SHOWSTYLES__H1'); ?></h1>
<p>
    <?php $this->set('SHOWSTYLES__INFOTEXT'); ?>
</p>
<table>
    <tr>
	<th>&nbsp;</th>
	<th><?php $this->set('SHOWSTYLES__NAME'); ?></th>
	<th><?php $this->set('SHOWSTYLES__VERSION'); ?></th>
	<th><?php $this->set('SHOWSTYLES__DESCRIPTION'); ?></th>
	<th><?php $this->set('SHOWSTYLES__AUTHOR'); ?></th>
	<th><?php $this->set('SHOWSTYLES__STATUS'); ?></th>
	<th>&nbsp;</th>
    </tr>
    <?php foreach ($StyleHandler->getList() as $index => $Style) { ?>
    <tr class="packets__statusclass_<?php echo $Style->getStatus(); ?>">
	<td>
	    <a href="?event=toggleActivated&amp;name=<?php echo $Style->get('name'); ?>">
	    <?php if ($Style->get('activated')) { ?>
		<img src="templates/images/green.gif" class="toggleImage" /></a>
	    <?php } else { ?>
		<img src="templates/images/red.gif" class="toggleImage" /></a>
	    <?php } ?>
	</td>
	<td>
	    <label for="style__<?php echo $Style->get('name'); ?>" class="label_classic">
		<?php echo $Style->get('name'); ?>
	    </label>
	</td>
	<td><?php echo $Style->get('version'); ?></td>
	<td><?php echo $Style->get('description'); ?></td>
	<td><?php echo $Style->get('author'); ?></td>
	<td><?php $this->set($Style->getStatus(true)); ?></td>
	<td>
	    <a href="?event=deleteStyle&amp;name=<?php echo $Style->get('name'); ?>">
		<?php $this->set('SHOWSTYLES__ACTION_DELETE'); ?></a><br />
	    <?php if ($Style->getStatus() == 6 OR $Style->getStatus() == 9) { ?>
	    <a href="?event=setDefaultStyle&amp;name=<?php echo $Style->get('name'); ?>">
		<?php $this->set('SHOWSTYLES__ACTION_SETDEFAULT'); ?></a>
	    <?php } ?>
	</td>
    </tr>
    <?php } ?>
</table>
