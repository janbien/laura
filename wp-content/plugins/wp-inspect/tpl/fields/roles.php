<?php !defined('ABSPATH') && exit ?>
<?php foreach ($roles as $role): ?>
<input type="checkbox" name="<?php $this->field_name('roles[]') ?>" autocomplete="off" id="<?php $this->field_id('roles-' . $role->key) ?>" value="<?php echo esc_attr($role->key) ?>" <?php checked(in_array($role->key, (array)@$settings->roles), 1) ?>/><label for="<?php $this->field_id('roles-' . $role->key) ?>"><?php echo $role->name ?></label>
<?php endforeach; ?>
<br />
<small>Enable for specific roles. <strong>If no roles are selected, <?php echo $name ?> will run for everyone <u>including unauthenticated users.</u></strong></small>