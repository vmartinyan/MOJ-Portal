<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package		voipApp_Admin
 * @author		Excitel Support <support@excitel.net>
 * @license		GPL-2.0+
 * @link		https://excitel.net
 * @copyright	2016 excitel
 */

?>

<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php

    $this->config_page();

	if( !$this->voipApp_auth AND isset( $this->message ) ){?>
			<h3><?= __( 'Login and configure \'Click to call\' buttons', $this->plugin_slug ); ?></h3>
			<div class="error">
                <p><strong><?php echo $this->message ?></strong></p>
                <p><?= __( 'If you need assistance, please use this page', $this->plugin_slug ); ?>: <a href="<?=VoipApp_Admin::MAIN_URL;?>" target="_blank" ><?=VoipApp_Admin::MAIN_URL;?></a>.</p>
            </div>
			<div><?= __( 'Please enter the same credentials that you use on ', $this->plugin_slug ); ?><a href="https://excitel.net/en/auth/login" target="_blank" >excitel.net</a>:</div>
			<form name="voipApp_auth_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<input type="hidden" name="voipApp_auth" value="true" />
				<ul>
					<li>
                        <label for="voipApp_username"><?= __( 'Email', $this->plugin_slug ); ?>: </label>
						<input class="voip_email_input" type="text" name="voipapp_username"  maxlength="45" size="10" value="" />
					</li>
					<li>
                        <label for="voipApp_password"><?= __( 'Password', $this->plugin_slug ); ?>: </label>
						<input class="voip_password_input" type="password" name="voipapp_password"  maxlength="45" size="10" value="" />
					</li>
				</ul>
				<input type="submit" value="<?= __( 'Login', $this->plugin_slug ); ?>" class="button-primary" />
			</form>
			<div><br><? printf( esc_html__( 'Or create account on %1$s and enter new credentials in the form above.', $this->plugin_slug ), '<a href="https://excitel.net/en/auth/registration" target="_blank" >excitel.net</a>'); ?></div>
			</div>
	<?php
	} elseif(isset($_SESSION['api_key']) && !empty($_SESSION['api_key'])) {

		add_settings_section( 'section-one', 'Button Configuration','', 'voipApp' );

                if(!empty($_SESSION['widgets'])){?>
                    <p class="top_middle"><?= __( 'Add \'Click to call\' button to your site.', $this->plugin_slug ); ?></p>
                    <p class="top_middle"><?= __( 'Also you can change the settings (working hours, time zone, autoresponder, etc) and design of buttons on ', $this->plugin_slug ); ?><a href="https://excitel.net/en/widgets" target="_blank" >Excitel -> Sites</a>.</p>
                    <h1 class="nav-tab nav-tab-active"><?= __( 'Buttons', $this->plugin_slug ); ?></h1>
                    <form name="voipApp_get_widgets_form" class="get_widgets_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="get_widgets" value="true" />
                        <input type="submit" value="<?= __( 'Sync all data', $this->plugin_slug ); ?>" class="button-primary" />
                    </form>
                    <form name="voipApp_logout_form" id="logout_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="logout" value="true">
                        <input type="submit" value="<?= __( 'Logout', $this->plugin_slug ); ?>" id="voipApp_logout_button" class=" button-primary ">
                    </form>
                    <form id="main_form" name="voipApp_widget_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <table class="wp-list-table widefat fixed toplevel_page_zingayazingaya-admin">
                      <tr>
                          <th><?= __( 'Name', $this->plugin_slug ); ?></th>
                          <th><?= __( 'Status', $this->plugin_slug ); ?></th>
                          <th><?= __( 'Action', $this->plugin_slug ); ?></th>
                      </tr>

                    <?foreach($_SESSION['widgets'] as $widget){?>
                        <tr>
                            <td><?=$widget['name']?></td>
                            <td><?php if($_SESSION['active_widget'] == $widget['hash']){ ?>
                                    <p><?= __( 'Button is added to the website', $this->plugin_slug ); ?></p>
                                <?php }?>
                            </td>
                            <td><?php if($_SESSION['active_widget'] == $widget['hash']){ ?>
                                    <input type="hidden" name="add_button" value="<?=$widget['hash']?>">
                                    <input type="button" class="button button-primary custom_button" onclick="remove_ajax('<?=$widget['hash']?>')" value="<?= __( 'Delete button', $this->plugin_slug ); ?>" />
                                <?php }else{?>
                                    <input type="hidden" name="delete_button" value="<?=$widget['hash']?>">
                                    <input type="button" class="button button-primary custom_button" onclick="send_ajax('<?=$widget['hash']?>')" value="<?= __( 'Add button', $this->plugin_slug ); ?>" />
                                <?}?>
                            </td>
                        </tr>
                   <? } ?>
                    </table>
                    <input type="submit" value="<?= __( 'Save', $this->plugin_slug ); ?>" id="voipApp_button" class=" button-primary " />
                    </form>

             <?php
                }else{?>
                    <h1><?= __( 'There is no buttons. Please create a new button - ', $this->plugin_slug ); ?></h1>
                    <form name="voipApp_logout_form" id="logout_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="logout" value="true">
                        <input type="submit" value="<?= __( 'Logout', $this->plugin_slug ); ?>" id="voipApp_logout_button" class=" button-primary ">
                    </form>
                    <form name="voipApp_get_widgets_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="get_widgets" value="true" />
                        <input type="submit" value="<?= __( 'Sync all data', $this->plugin_slug ); ?>" class="button-primary" />
                    </form>
                <?}

	}else{
	?>
			<h3><?= __( 'Login and configure \'Click to call\' buttons', $this->plugin_slug ); ?></h3>
			<?php print $this->buttons_empty ?
				 '<div class="error"><p><strong>No Button Configurations Found.</strong></p><p> Please ensure you have buttons configured at <a href="https://excitel.net/" target="_blank">excitel.net</a> before proceeding.</p></div>' : null; ?>
			<div><?= __( 'Please enter the same credentials that you use on ', $this->plugin_slug ); ?><a href="https://excitel.net/en/auth/login" target="_blank" >excitel.net</a>:</div>
			<form name="voipApp_auth_form" method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<input type="hidden" name="voipApp_auth" value="true" />
				<ul>
					<li>
                        <label for="voipApp_username"><?= __( 'Email', $this->plugin_slug ); ?>: </label>
						<input class="voip_email_input" type="text" name="voipapp_username"  maxlength="45" size="10" value="" />
					</li>
					<li>
                        <label for="voipApp_password"><?= __( 'Password', $this->plugin_slug ); ?>: </label>
						<input class="voip_password_input" type="password" name="voipapp_password"  maxlength="45" size="10" value="" />
					</li>
				</ul>
				<input type="submit" value="<?= __( 'Login', $this->plugin_slug ); ?>" class="button-primary" />
			</form>
			<div><br><? printf( esc_html__( 'Or create account on %1$s and enter new credentials in the form above.', $this->plugin_slug ), '<a href="https://excitel.net/en/auth/registration" target="_blank" >excitel.net</a>'); ?></div>
			</div>
	<?php
	}
	?>

</div>
<script type="text/javascript">
    function click_button(hash){ }
</script>