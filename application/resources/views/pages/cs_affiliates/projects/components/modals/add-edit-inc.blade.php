<!--cs_affiliate_project_projectid-->
@if(config('visibility.creating_mode'))
<div class="form-group row">
    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('lang.project')</label>
    <div class="col-sm-12 col-lg-9">
        <!--select2 basic search-->
        <select name="cs_affiliate_project_projectid" id="cs_affiliate_project_projectid"
            class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
            data-ajax--url="{{ url('feed/projects?ref=general') }}">
        </select>
        <!--#/select2 basic search-->
    </div>
</div>

<!--cs_affiliate_project_affiliateid-->
<div class="form-group row">
    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('lang.affiliate')</label>
    <div class="col-sm-12 col-lg-9">
        <select class="select2-basic form-control form-control-sm select2-preselected"
            id="cs_affiliate_project_affiliateid" name="cs_affiliate_project_affiliateid"
            data-preselected="{{ $project->cs_affiliate_project_affiliateid ?? ''}}">
            <option></option>
            @foreach($affiliates as $affiliate)
            <option value="{{ $affiliate->id }}">{{ $affiliate->first_name }} {{ $affiliate->last_name }}</option>
            @endforeach
        </select>
    </div>
</div>
@endif

<!--commission-->
<div class="form-group row">
    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('lang.commission') (%)</label>
    <div class="col-sm-12 col-lg-9">
        <input type="numeric" class="form-control form-control-sm" id="cs_affiliate_project_commission_rate"
            name="cs_affiliate_project_commission_rate"
            value="{{ (float) ($project->cs_affiliate_project_commission_rate ?? 0) }}">
    </div>
</div>

<!--item-->
@if(config('visibility.editing_mode'))
<div class="form-group row">
    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('lang.status')</label>
    <div class="col-sm-12 col-lg-9">
        <select class="select2-basic form-control form-control-sm select2-preselected" id="cs_affiliate_project_status"
            name="cs_affiliate_project_status" data-preselected="{{ $project->cs_affiliate_project_status ?? ''}}">
            <option value="active">@lang('lang.active')</option>
            <option value="suspended">@lang('lang.suspended')</option>
        </select>
    </div>
</div>
@endif

<script>
    $(document).ready(function () {
        $("#commonModalForm").validate().destroy();
        $("#commonModalForm").validate({
            rules: {
                cs_affiliate_project_affiliateid: "required",
                cs_affiliate_project_projectid: "required",
                cs_affiliate_project_commission_rate: "required",
            },
            submitHandler: function (form) {
                nxAjaxUxRequest($("#commonModalSubmitButton"));
            }
        });
    });
</script>