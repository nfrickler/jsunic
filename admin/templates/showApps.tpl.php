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
<form action="?event=setApps" method="post" name="admin__showApps__form">
    <table>
	<tr>
	    <th>&nbsp;</th>
	    <th><?php $this->set('SHOWAPPS__ID'); ?></th>
	    <th><?php $this->set('SHOWAPPS__MODNAME'); ?></th>
	    <th><?php $this->set('SHOWAPPS__VERSION'); ?></th>
	    <th><?php $this->set('SHOWAPPS__MODDESCRIPTION'); ?></th>
	    <th><?php $this->set('SHOWAPPS__AUTHOR'); ?></th>
	    <th><?php $this->set('SHOWAPPS__STATUS'); ?></th>
	    <th><?php $this->set('SHOWAPPS__ACTION'); ?></th>
	</tr>
	<?php foreach ($AppHandler->getApps() as $index => $App) { ?>
	<tr class="packets__statusclass_<?php echo $App->getStatus(); ?>">
	    <td>
		<input type="checkbox" class="ts_checkbox" name="module__<?php echo $App->getInfo('id__module'); ?>" id="module__<?php echo $App->getInfo('id__module'); ?>" <?php if ($App->getInfo('is_activated')) echo 'checked="checked"'; ?> />
	    </td>
	    <td><?php echo $App->getInfo('id__module'); ?></td>
	    <td>
		<label for="module__<?php echo $App->getInfo('id__module'); ?>" class="label_classic">
		    <?php echo $App->getInfo('name'); ?>
		</label>
	    </td>
	    <td>
		<?php if ($App->getStatus() == 3) {
		    echo $App->getInfo('version_installed').' -> '.$App->getInfo('version');
		} else {
		    echo $App->getInfo('version');
		} ?>
	    </td>
	    <td><?php echo $App->getInfo('description'); ?></td>
	    <td><?php echo $App->getInfo('author'); ?></td>
	    <td><?php $this->set($App->getStatus(true)); ?></td>
	    <td>
		<?php switch ($App->getStatus()) { 
		    case 4:
			?>
			<a href="?event=installApp&amp;id=<?php echo $App->getInfo('id__module'); ?>">
			    <?php $this->set('SHOWAPPS__ACTION_INSTALL'); ?>
			</a>
			<?php
			// no break
		    case 5:
			?>
			<a href="?event=deleteApp&amp;id=<?php echo $App->getInfo('id__module'); ?>">
			    <?php $this->set('SHOWAPPS__ACTION_DELETE'); ?>
			</a>
			<?php
			break;
		    case 2:
			?>
			<a href="?event=uninstallApp&amp;id=<?php echo $App->getInfo('id__module'); ?>">
			    <?php $this->set('SHOWAPPS__ACTION_UNINSTALL'); ?>
			</a>
			<?php
			break;
		    case 1:
			?>
			<a href="?event=installApp&amp;id=<?php echo $App->getInfo('id__module'); ?>">
			    <?php $this->set('SHOWAPPS__ACTION_INSTALL'); ?>
			</a>
			<a href="?event=deleteApp&amp;id=<?php echo $App->getInfo('id__module'); ?>">
			    <?php $this->set('SHOWAPPS__ACTION_DELETE'); ?>
			</a>
			<?php
			break;
		    case 3:
			?>
			<a href="?event=updateApp&amp;id=<?php echo $App->getInfo('id__module'); ?>">
			    <?php $this->set('SHOWAPPS__ACTION_UPDATE'); ?>
			</a>
			<?php
			break;
		} ?>
	    </td>
	</tr>
	<?php } ?>
    </table>
    <input type="submit" name="submit_build" class="ts_submit" value="<?php $this->set('SHOWAPPS__RENDER'); ?>" />
    <input type="submit" name="submit_setApps" class="ts_submit" value="<?php $this->set('SHOWAPPS__SUBMIT'); ?>" />
    <input type="reset" class="ts_reset" value="<?php $this->set('SHOWAPPS__RESET'); ?>" />
</form>
