<?php
define("DONOTCACHEPAGE", true);
viser_layout('user/layouts/app')
?>

<!-- Account Section -->
<div class="account-section pt-60 pb-60">
    <div class="account-wrapper sign-up">
		<?php if (isset($_GET['action']) && $_GET['action'] == 'resend') {
			viser_include('user/auth/resend_activation');
		} else {
			viser_include('user/auth/register_form', compact('countries', 'mobileCode'));
		} ?>
    </div>
</div>
<!-- Account Section -->