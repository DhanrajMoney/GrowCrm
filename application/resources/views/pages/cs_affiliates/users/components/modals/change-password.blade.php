<div class="form-group row">
    <div class="col-sm-12">
        <input type="password" class="form-control" id="password" name="password"
            placeholder="{{ cleanLang(__('lang.password')) }}">
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-12">
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
            placeholder="{{ cleanLang(__('lang.confirm_password')) }}">
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#commonModalForm").validate().destroy();
        $("#commonModalForm").validate({
            rules: {
                password: {
                    required: true,
                },
                confirm_password: {
                    equalTo: "#password"
                }
            },
            submitHandler: function (form) {
                nxAjaxUxRequest($("#commonModalSubmitButton"));
            }
        });
    });
</script>