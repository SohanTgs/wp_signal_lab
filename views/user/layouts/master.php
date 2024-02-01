<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <link rel="shortcut icon" href="<?php echo viser_get_image(viser_file_path('logoIcon').'/favicon.png'); ?>" type="image/x-icon">

    <?php wp_head(); ?>
</head>

<body <?php body_class('vl-public'); ?>>

    <!-- Preloader  -->
    <div class="preloader">
        <div class="loader-p"></div>
    </div>
    <!-- Preloader  -->

    <!-- Overlay -->
    <div class="overlay"></div>
    <a href="javascript::void(0)" class="scrollToTop"><i class="las la-chevron-up"></i></a>

    <?php viser_include('user/partials/header'); ?>

    <div class="main-wrapper">

        {{yield}}

    </div><!-- main-wrapper end -->

    <?php viser_include('user/partials/footer'); ?>

    <?php viser_include('partials/notify'); ?>

    <?php wp_footer(); ?>
</body>

</html>

<?php viser_include('debug'); ?>