<div class="page-wrapper default-version">
    <?php
    viser_include('admin/partials/sidenav');
    viser_include('admin/partials/topnav');
    ?>
    <div class="body-wrapper">
        <div class="bodywrapper__inner">
            <?php
            viser_include('admin/partials/breadcrumb', compact('pageTitle'));
            ?>
            {{yield}}
        </div>
    </div>
</div>
<?php
viser_include('partials/notify');
?>

<?php viser_include('debug'); ?>