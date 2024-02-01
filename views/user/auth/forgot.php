<?php
define("DONOTCACHEPAGE", true);

$invalid_key = '';
$rp_status = '';

if (isset($_GET['action']) && $_GET['action'] == 'rp' && @$_POST['action'] != 'rp') {
	$user = check_password_reset_key($_GET['key'], $_GET['login']);
	if (is_wp_error($user)) {
		$invalid_key = 'invalid';
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'rp') {
	$user = get_user_by('login', $_POST['user_login']);
	if ($_POST['pass1'] != $_POST['pass2']) {
		$notify[] = ['error', __('The passwords do not match.', VISERLAB_PLUGIN_NAME)];
		viser_set_notify($notify);
	} else if (strlen($_POST['pass1']) < 6) {
		$notify[] = ['error', __('Passwords must be at least 6 characters long.', VISERLAB_PLUGIN_NAME)];
		viser_set_notify($notify);
	} else {
		reset_password($user, $_POST['pass1']);
		wp_redirect(home_url('/login/?pw=reset'));
		exit;
	}
} 

viser_layout('user/layouts/app')
?>

<div class="account-section pt-60 pb-60">
    <div class="account-wrapper">
		<a href="<?php echo home_url('/'); ?>" class="logo mb-4">
            <img src="<?php echo viser_get_image(viser_file_path('logoIcon').'/dark_logo.png'); ?>" alt="<?php esc_html_e('Logo', VISERLAB_PLUGIN_NAME); ?>">
        </a>
        <?php if (!isset($_GET['action']) || $invalid_key == 'invalid') {
			viser_include('user/auth/reset_password');
		} elseif ($_GET['action'] == 'rp') {
			viser_include('user/auth/change_password');
		}
		?>
    </div>
</div>