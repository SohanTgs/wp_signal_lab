<?php
viser_layout('admin/layouts/master');
?>
<div class="row mb-none-30">
  <div class="col-md-12">
    <div class="card b-radius--10 ">
      <div class="card-body p-0">
        <div class="table-responsive--md  table-responsive">
          <table class="table table--light style--two">
            <thead>
              <tr>
                <th><?php esc_html_e('Type', VISERLAB_PLUGIN_NAME); ?></th>
                <th><?php esc_html_e('Message', VISERLAB_PLUGIN_NAME); ?></th>
                <th><?php esc_html_e('Status', VISERLAB_PLUGIN_NAME); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reports as $report) { ?>
                <tr>
                  <td><?php echo @$report->req_type ?></td>
                  <td class="text-center white-space-wrap"><?php echo @$report->message ?></td>
                  <td><span class="badge badge--<?php echo @$report->status_class ?>"><?php echo @$report->status_text ?></span></td>
                </tr>
              <?php } ?>
              <?php if (viser_check_empty($reports)) { ?>
                <tr>
                  <td colspan="100%" class="text-center"><?php esc_html_e('Data Not Found', VISERLAB_PLUGIN_NAME); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table><!-- table end -->
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="bugModal" tabindex="-1" role="dialog" aria-labelledby="bugModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bugModalLabel"><?php esc_html_e('Report & Request', VISERLAB_PLUGIN_NAME); ?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <i class="las la-times"></i>
        </button>
      </div>
      <form action="<?php echo viser_route_link('admin.request.report.submit') ?>" method="post">
        <?php viser_nonce_field('admin.request.report.submit') ?>
        <div class="modal-body">
          <div class="form-group">
            <label><?php esc_html_e('Type', VISERLAB_PLUGIN_NAME); ?></label>
            <select class="form-control" name="type" required>
              <option value="bug" <?php selected(viser_old("type"), "bug") ?>><?php esc_html_e('Report Bug', VISERLAB_PLUGIN_NAME); ?></option>
              <option value="feature" <?php selected(viser_old("type"), "feature") ?>><?php esc_html_e('Feature Request', VISERLAB_PLUGIN_NAME); ?></option>
            </select>
          </div>
          <div class="form-group">
            <label><?php esc_html_e('Message', VISERLAB_PLUGIN_NAME); ?></label>
            <textarea class="form-control" name="message" rows="5" required><?php echo viser_old('message') ?></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn--primary w-100 h-45"><?php esc_html_e('Submit', VISERLAB_PLUGIN_NAME); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
$html = '<button class="btn btn-sm btn-outline--primary" data-bs-toggle="modal" data-bs-target="#bugModal"><i class="las la-bug"></i> Report a bug</button>
    <a href="https://viserlab.com/support" target="_blank" class="btn btn-sm btn-outline--primary"><i class="las la-headset"></i> Request for Support</a>';
viser_push_breadcrumb($html);
?>