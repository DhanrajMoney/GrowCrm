<div class="form-group row">
    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('lang.status')</label>
    <div class="col-sm-12 col-lg-9">
        <select class="select2-basic form-control form-control-sm select2-preselected" id="cs_affiliate_earning_status"
            name="cs_affiliate_earning_status" data-preselected="{{ $earning->cs_affiliate_earning_status ?? ''}}">
            <option value="paid">@lang('lang.paid')</option>
            <option value="unpaid">@lang('lang.pending_clearance')</option>
        </select>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#commonModalForm").validate().destroy();
        $("#commonModalForm").validate({
            rules: {
            },
            submitHandler: function (form) {
                nxAjaxUxRequest($("#commonModalSubmitButton"));
            }
        });
    });
</script>