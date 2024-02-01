<?php viser_layout('admin/layouts/master'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>        
                            <th><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Price', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Validity', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
                            <th><?php esc_html_e('Action', VISERLAB_PLUGIN_NAME); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($packages->data as $package) { ?>
                                <tr>
                                    <td>
                                        <span class="fw-bold"><?php echo esc_html($package->name); ?></span>
                                    </td>
                                    <td>
                                        <span><?php echo viser_show_amount($package->price); ?> <?php echo viser_currency('text'); ?></span>
                                    </td>
                                    <td>
                                        <?php echo esc_html($package->validity); ?> <?php esc_html_e('Days', VISERLAB_PLUGIN_NAME); ?>
                                    </td>
                                    <td>
                                    <?php
                                        $html = '';
                                        if ($package->status == 1) {
                                            $html = '<span class="badge badge--success">' . __('Enabled', VISERLAB_PLUGIN_NAME) . '</span>';
                                        } else {
                                            $html = '<span><span class="badge badge--warning">' . __('Disabled', VISERLAB_PLUGIN_NAME) . '</span></span>';
                                        }
                                        echo wp_kses($html, viser_allowed_html());
                                        ?>
                                    </td>
                                    <td>
                                       <div class="justify-content-end d-flex flex-wrap gap-1">
                                            <button class="btn btn-sm btn-outline--primary editBtn" 
                                                data-name="<?php echo esc_html_e($package->name, VISERLAB_PLUGIN_NAME); ?>"
                                                data-id="<?php echo esc_html_e($package->id, VISERLAB_PLUGIN_NAME); ?>"
                                                data-price="<?php echo esc_html_e($package->price, VISERLAB_PLUGIN_NAME); ?>"
                                                data-validity="<?php echo esc_html_e($package->validity, VISERLAB_PLUGIN_NAME); ?>"
                                                data-features="<?php echo esc_html_e($package->features, VISERLAB_PLUGIN_NAME); ?>"
                                            >
                                                <i class="la la-pencil"></i> <?php esc_html_e('Edit', VISERLAB_PLUGIN_NAME); ?>
                                            </button>

                                            <?php if ($package->status == 0) { ?>
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" 
                                                    data-question="<?php esc_html_e('Are you sure to enable this package?', VISERLAB_PLUGIN_NAME); ?>" 
                                                    data-action="<?php echo viser_route_link('admin.package.status'); ?>&amp;id=<?php echo intval($package->id); ?>"
                                                    data-nonce="<?php echo esc_attr(viser_nonce('admin.package.status')) ?>"
                                                >
                                                    <i class="la la-eye"></i> <?php esc_html_e('Enable', VISERLAB_PLUGIN_NAME); ?>
                                                </button>
                                            <?php } else { ?>
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" 
                                                    data-question="<?php esc_html_e('Are you sure to disable this package?', VISERLAB_PLUGIN_NAME); ?>"
                                                    data-action="<?php echo viser_route_link('admin.package.status'); ?>&amp;id=<?php echo intval($package->id); ?>"
                                                    data-nonce="<?php echo esc_attr(viser_nonce('admin.package.status')) ?>"
                                                >
                                                    <i class="la la-eye-slash"></i> <?php esc_html_e('Disable', VISERLAB_PLUGIN_NAME); ?>
                                                </button>
                                            <?php } ?>

                                       </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if (viser_check_empty($packages->data)) { ?>
                                <tr> 
                                    <td class="text-muted text-center" colspan="100%"><?php esc_html_e('Data Not Found', VISERLAB_PLUGIN_NAME); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>

            <?php if ($packages->links) { ?>
                <div class="card-footer">
                    <?php echo wp_kses($packages->links, viser_allowed_html()); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- NEW MODAL -->
<div id="createModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"><?php esc_html_e('Add New Package', VISERLAB_PLUGIN_NAME);?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo viser_route_link('admin.package.add') ?>">
                <?php viser_nonce_field('admin.package.add') ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></label>
                        <input type="text" class="form-control" name="name" value="<?php echo viser_old('name'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label><?php esc_html_e('Price', VISERLAB_PLUGIN_NAME); ?></label>
                        <div class="input-group">
                            <input type="number" step="any" class="form-control" name="price" value="<?php echo viser_old('price'); ?>" required>
                            <span class="input-group-text"><?php echo get_option('viser_cur_text'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php esc_html_e('Validity', VISERLAB_PLUGIN_NAME); ?></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="validity" value="<?php echo viser_old('validity'); ?>" required>
                            <span class="input-group-text"><?php esc_html_e('Days', VISERLAB_PLUGIN_NAME); ?></span>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label for="features"><?php esc_html_e('Features', VISERLAB_PLUGIN_NAME); ?></label>
                        <select name="features[]" id="features" class="form-control select2-auto-tokenize" multiple required>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary h-45 w-100"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel"><?php esc_html_e('Update Package', VISERLAB_PLUGIN_NAME);?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo viser_route_link('admin.package.update') ?>">
                <?php viser_nonce_field('admin.package.update') ?>
                <input type="hidden" name="id" required>
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php esc_html_e('Name', VISERLAB_PLUGIN_NAME); ?></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label><?php esc_html_e('Price', VISERLAB_PLUGIN_NAME); ?></label>
                        <div class="input-group">
                            <input type="number" step="any" class="form-control" name="price" required>
                            <span class="input-group-text"><?php echo get_option('viser_cur_text'); ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?php esc_html_e('Validity', VISERLAB_PLUGIN_NAME); ?></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="validity" required>
                            <span class="input-group-text"><?php esc_html_e('Days', VISERLAB_PLUGIN_NAME); ?></span>
                        </div>
                    </div>
                    <div class="col-lg-12 form-group">
                        <label for="editFeatures"><?php esc_html_e('Features', VISERLAB_PLUGIN_NAME); ?></label>
                        <select name="features[]" id="editFeatures" class="form-control select2-auto-tokenize" multiple required>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary h-45 w-100"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php viser_include('partials/confirmation'); ?>

<?php
$html = '<a class="btn btn-sm btn-outline--primary addBtn"><i class="las la-plus"></i>' . __("Add New", VISERLAB_PLUGIN_NAME) . '</a>';
viser_push_breadcrumb($html);
?>

<script>
   jQuery(document).ready(function($) {
        "use strict";

        $('.addBtn').on('click', function () {
            var modal = $('#createModal');
            modal.modal('show');
        });

        $('.editBtn').on('click', function () {
            var modal = $('#editModal');
            var select = $('#editFeatures');
            var features = $(this).data('features');
            select.empty();

            modal.find('input[name=name]').val($(this).data('name'));
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=price]').val($(this).data('price'));
            modal.find('input[name=validity]').val($(this).data('validity'));

            for(var i = 0; i < features.length; i++) {
                select.append($(`<option selected>`).val(features[i]).text(features[i]));
            }
            modal.modal('show');
        });
    });
</script>


