<?php !defined('ABSPATH') && exit; ?>
<div class="wrap">
    <header>
        <h1><a href="http://wp-inspect.com" target="_blank"><img src="<?php echo plugins_url('/assets/images/wpi-blue.svg', WPI_PLUGIN_FILE) ?>" /></a><small><?php echo $description ?></small></h1>    
    </header>
    <form action="options.php" method="post">
        <?php $this->settings_fields() ?>
        <fieldset id="<?php $this->field_id('global', true) ?>">
            <legend>Global</legend>
            <table class="form-table">
                <tr>
                    <th scope="row">Status</th>
                    <td>
                        <?php $this->render('fields/enable', $data); ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Role(s)</th>
                    <td>
                        <?php $this->render('fields/roles', $data); ?>
                    </td>
                </tr>
            </table>                
        </fieldset>
        <?php submit_button() ?>
        <?php $this->render('settings-section', array_merge($data, array('section' => 'public'))); ?>
        <?php $this->render('settings-section', array_merge($data, array('section' => 'admin'))); ?>
    </form>
</div>