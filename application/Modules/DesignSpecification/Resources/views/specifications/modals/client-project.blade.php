<div class="client-selector-container" id="client-existing-container">
    <div class="form-group row">
        <label
            class="col-sm-12 col-lg-3 text-left control-label col-form-label  required">{{ cleanLang(__('lang.client')) }}*</label>
        <div class="col-sm-12 col-lg-9">
            <!--select2 basic search-->
            <select name="mod_specification_client" id="mod_specification_client"
                class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search-modal select2-hidden-accessible"
                data-projects-dropdown="mod_specification_project" data-feed-request-type="clients_projects"
                data-ajax--url="{{ url('/') }}/feed/company_names">
            </select>
            <!--select2 basic search-->
            </select>
        </div>
    </div>

    <!--projects-->
    <div class="form-group row">
        <label
            class="col-sm-12 col-lg-3 text-left control-label col-form-label">{{ cleanLang(__('lang.project')) }}</label>
        <div class="col-sm-12 col-lg-9">
            <select class="select2-basic form-control form-control-sm dynamic_bill_projectid" data-allow-clear="true"
                id="mod_specification_project" name="mod_specification_project" disabled>
            </select>
        </div>
    </div>
</div>

<div class="alert alert-info">@lang('designspecification::lang.client_project_instructions')</div>