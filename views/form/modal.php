<div class="modal fade" id="formGenerateModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php esc_html_e('Generate Form', VISERLAB_PLUGIN_NAME);?></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i class="las la-times"></i>
          </button>
        </div>
        <form class="generate-form">
              <div class="modal-body">
                <input type="hidden" name="update_id" value="">
                <div class="form-group">
                    <label><?php esc_html_e('Form Type', VISERLAB_PLUGIN_NAME);?></label>
                    <select name="form_type" class="form-control" required>
                        <option value=""><?php esc_html_e('Select One', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="text"><?php esc_html_e('Text', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="textarea"><?php esc_html_e('Textarea', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="select"><?php esc_html_e('Select', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="checkbox"><?php esc_html_e('Checkbox', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="radio"><?php esc_html_e('Radio', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="file"><?php esc_html_e('File', VISERLAB_PLUGIN_NAME);?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php esc_html_e('Is Required', VISERLAB_PLUGIN_NAME);?></label>
                    <select name="is_required" class="form-control" required>
                        <option value=""><?php esc_html_e('Select One', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="required"><?php esc_html_e('Required', VISERLAB_PLUGIN_NAME);?></option>
                        <option value="optional"><?php esc_html_e('Optional', VISERLAB_PLUGIN_NAME);?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label><?php esc_html_e('Form Label', VISERLAB_PLUGIN_NAME);?></label>
                    <input type="text" name="form_label" class="form-control" required>
                </div>
                <div class="form-group extra_area">

                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn--primary text-white w-100 h-45 generatorSubmit"><?php esc_html_e('Add', VISERLAB_PLUGIN_NAME);?></button>
              </div>
          </form>
      </div>
    </div>
</div>