<!--mod_specifications_settings_notes-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required">@lang('designspecification::lang.general_notes')</label>
    <div class="col-sm-12">
        <textarea class="form-control form-control-sm tinymce-textarea-lite" rows="5" name="mod_specifications_settings_notes"
            id="mod_specifications_settings_notes">{{ $settings->mod_specifications_settings_notes ?? '' }}</textarea>
    </div>
</div>