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
<form action="?event=setStyles" method="post">
    <table>
	<tr>
	    <th>&nbsp;</th>
	    <th><?php $this->set('SHOWSTYLES__ID'); ?></th>
	    <th><?php $this->set('SHOWSTYLES__MODNAME'); ?></th>
	    <th><?php $this->set('SHOWSTYLES__VERSION'); ?></th>
	    <th><?php $this->set('SHOWSTYLES__MODDESCRIPTION'); ?></th>
	    <th><?php $this->set('SHOWSTYLES__AUTHOR'); ?></th>
	    <th><?php $this->set('SHOWSTYLES__STATUS'); ?></th>
	    <th><?php $this->set('SHOWSTYLES__ACTION'); ?></th>
	</tr>
	<?php foreach ($StyleHandler->getStyles() as $index => $Style) { ?>
	<tr class="packets__statusclass_<?php echo $Style->getStatus(); ?>">
	    <td>
		<input type="checkbox" class="ts_checkbox" name="style__<?php echo $Style->getInfo('id__style'); ?>" id="style__<?php echo $Style->getInfo('id__style'); ?>" <?php if ($Style->getInfo('is_activated')) echo 'checked="checked"'; ?> />
	    </td>
	    <td><?php echo $Style->getInfo('id__style'); ?></td>
	    <td>
		<label for="style__<?php echo $Style->getInfo('id__style'); ?>" class="label_classic">
		    <?php echo $Style->getInfo('name'); ?>
		</label>
	    </td>
	    <td><?php echo $Style->getInfo('version'); ?></td>
	    <td><?php echo $Style->getInfo('description'); ?></td>
	    <td><?php echo $Style->getInfo('author'); ?></td>
	    <td><?php $this->set($Style->getStatus(true)); ?></td>
	    <td>
		<a href="?event=deleteStyle&amp;id=<?php echo $Style->getInfo('id__style'); ?>">
		    <?php $this->set('SHOWSTYLES__ACTION_DELETE'); ?>
		</a><br />
		<?php if ($Style->getStatus() == 6 OR $Style->getStatus() == 9) { ?>
		<a href="?event=setDefaultStyle&amp;id=<?php echo $Style->getInfo('id__style'); ?>">
		    <?php $this->set('SHOWSTYLES__ACTION_SETDEFAULT'); ?>
		</a>
		<?php } ?>
	    </td>
	</tr>
	<?php } ?>
    </table>
    <input type="submit" value="<?php $this->set('SHOWSTYLES__SUBMIT'); ?>" />
    <input type="reset" value="<?php $this->set('SHOWSTYLES__RESET'); ?>" />
</form>
