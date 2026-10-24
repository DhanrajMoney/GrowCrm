<!--to name-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required">@lang('lang.name')</label>
    <div class="col-sm-12">
        <input type="text" class="form-control form-control-sm" id="user_name" name="user_name"
            value="{{ $payload['name'] }}">
    </div>
</div>

<!--email-->
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required">@lang('lang.email')</label>
    <div class="col-sm-12">
        <input type="text" class="form-control form-control-sm" id="user_email" name="user_email"
            value="{{ $payload['email'] }}">
    </div>
</div>