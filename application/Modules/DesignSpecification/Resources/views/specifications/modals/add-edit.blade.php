<div class="modal-selector p-t-10 p-b-15">
    <div class="row">
        <div class="col-12">
            <h5 class="m-0 p-0 p-b-10">@lang('designspecification::lang.specification_id')</h5>
        </div>
        <!--mod_specification_id_building_type-->
        <div class="col-sm-12 col-lg-3">
            <div class="form-group m-b-0">
                <input type="text" class="form-control form-control-sm" id="mod_specification_id_building_type"
                    name="mod_specification_id_building_type"
                    placeholder="@lang('designspecification::lang.building_type')"
                    value="{{ $specification->mod_specification_id_building_type ?? '' }}">
            </div>
        </div>

        <!--mod_specification_id_building_number-->
        <div class="col-sm-12 col-lg-3">
            <div class="form-group m-b-0">
                <input type="text" class="form-control form-control-sm" id="mod_specification_id_building_number"
                    name="mod_specification_id_building_number"
                    placeholder="@lang('designspecification::lang.building_number')"
                    value="{{ $specification->mod_specification_id_building_number ?? '' }}">
            </div>
        </div>

        <!--mod_specification_id_spec_type-->
        <div class="col-sm-12 col-lg-3">
            <div class="form-group m-b-0">
                <select class="select2-basic form-control form-control-sm select2-preselected"
                    id="mod_specification_id_spec_type" name="mod_specification_id_spec_type"
                    data-preselected="{{ $specification->mod_specification_id_spec_type ?? ''}}">
                    <option value="s1">S1</option>
                    <option value="s2">S2</option>
                </select>
            </div>
        </div>

        <!--mod_specification_id_building_type-->
        <div class="col-sm-12 col-lg-3">
            <div class="form-group m-b-0">
                <input type="text" class="form-control form-control-sm" id="mod_specification_id"
                    name="mod_specification_id" disabled
                    value="{{ $specification->mod_specification_id ?? '' }}">
            </div>
        </div>
    </div>
</div>


<!--client and project-->
@if(request('action') == 'create')
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

<div class="line"></div>
@endif


<!--mod_specification_id_building_venue-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.venue_name')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_id_building_venue"
            name="mod_specification_id_building_venue"
            value="{{ $specification->mod_specification_id_building_venue ?? '' }}">
    </div>
</div>


<!--mod_specification_item_name-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.item_name')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_item_name"
            name="mod_specification_item_name" value="{{ $specification->mod_specification_item_name ?? '' }}">
    </div>
</div>

<!--mod_specification_date_issue-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.issue_date')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm pickadate" autocomplete="off"
            name="mod_specification_date_issue"
            value="{{ runtimeDatepickerDate($specification->mod_specification_date_issue ?? '') }}">
        <input class="mysql-date" type="hidden" name="mod_specification_date_issue" id="mod_specification_date_issue"
            value="{{ $specification->mod_specification_date_issue ?? '' }}">
    </div>
</div>


<!--mod_specification_date_revision-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.revision_date')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm pickadate" autocomplete="off"
            name="mod_specification_date_revision"
            value="{{ runtimeDatepickerDate($specification->mod_specification_date_revision ?? '') }}">
        <input class="mysql-date" type="hidden" name="mod_specification_date_revision"
            id="mod_specification_date_revision" value="{{ $specification->mod_specification_date_revision ?? '' }}">
    </div>
</div>

<div class="line"></div>

<!--mod_specification_manufacturer-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.manufacturer_name')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_manufacturer"
            name="mod_specification_manufacturer" value="{{ $specification->mod_specification_manufacturer ?? '' }}">
    </div>
</div>

<!--mod_specification_rep_name-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.rep_name')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_rep_name"
            name="mod_specification_rep_name" value="{{ $specification->mod_specification_rep_name ?? '' }}">
    </div>
</div>

<!--mod_specification_rep_company-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.rep_company')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_rep_company"
            name="mod_specification_rep_company" value="{{ $specification->mod_specification_rep_company ?? '' }}">
    </div>
</div>

<div class="line"></div>

<!--mod_specification_contact_name-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.contact_name')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_contact_name"
            name="mod_specification_contact_name" value="{{ $specification->mod_specification_contact_name ?? '' }}">
    </div>
</div>

<!--mod_specification_contact_email-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.contact_email')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_contact_email"
            name="mod_specification_contact_email" value="{{ $specification->mod_specification_contact_email ?? '' }}">
    </div>
</div>

<!--mod_specification_contact_address_1-->
<div class="form-group row">
    <label
        class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.contact_address')</label>
    <div class="col-sm-12 col-lg-9">
        <input type="text" class="form-control form-control-sm" id="mod_specification_contact_address_1"
            name="mod_specification_contact_address_1"
            value="{{ $specification->mod_specification_contact_address_1 ?? '' }}">
    </div>
</div>

<div class="modal-selector m-t-30 p-t-10 p-b-15">

    <!--mod_specification_item_description-->
    <div class="form-group row">
        <label
            class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.description')</label>
        <div class="col-sm-12 col-lg-9">
            <input type="text" class="form-control form-control-sm" id="mod_specification_item_description"
                name="mod_specification_item_description"
                value="{{ $specification->mod_specification_item_description ?? '' }}">
        </div>
    </div>

    <!--mod_specification_item_dimensions-->
    <div class="form-group row">
        <label
            class="col-sm-12 col-lg-3 text-left control-label col-form-label required">@lang('designspecification::lang.dimenensions')</label>
        <div class="col-sm-12 col-lg-9">
            <input type="text" class="form-control form-control-sm" id="mod_specification_item_dimensions"
                name="mod_specification_item_dimensions"
                value="{{ $specification->mod_specification_item_dimensions ?? '' }}">
        </div>
    </div>

    <!--mod_specification_item_requirements-->
    <div class="form-group row">
        <label
            class="col-sm-12 text-left control-label col-form-label required">@lang('designspecification::lang.requirements')</label>
        <div class="col-sm-12">
            <textarea class="form-control form-control-sm tinymce-textarea-lite" rows="5"
                name="mod_specification_item_requirements"
                id="mod_specification_item_requirements">{{ $specification->mod_specification_item_requirements ?? '' }}</textarea>
        </div>
    </div>

    <!--mod_specification_item_note-->
    <div class="form-group row">
        <label
            class="col-sm-12 text-left control-label col-form-label required">@lang('designspecification::lang.note')</label>
        <div class="col-sm-12">
            <textarea class="form-control form-control-sm tinymce-textarea-lite" rows="5"
                name="mod_specification_item_note"
                id="mod_specification_item_note">{{ $specification->mod_specification_item_note ?? '' }}</textarea>
        </div>
    </div>
</div>

<h4>@lang('designspecification::lang.stage')</h4>

<!--final selection-->
<div class="row">
    <!--mod_specification_type_finish_sample-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_finish_sample"
                name="mod_specification_type_finish_sample"
                {{ runtimePrechecked($specification->mod_specification_type_finish_sample ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.finish_sample')</span>
        </label>
    </div>

    <!--mod_specification_type_strike_off-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_strike_off"
                name="mod_specification_type_strike_off"
                {{ runtimePrechecked($specification->mod_specification_type_strike_off ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.strike_off')</span>
        </label>
    </div>

    <!--mod_specification_type_cutting-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_cutting"
                name="mod_specification_type_cutting"
                {{ runtimePrechecked($specification->mod_specification_type_cutting ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.cuttting')</span>
        </label>
    </div>

    <!--mod_specification_type_shop_drawing-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_shop_drawing"
                name="mod_specification_type_shop_drawing"
                {{ runtimePrechecked($specification->mod_specification_type_shop_drawing ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.shop_drawings')</span>
        </label>
    </div>

    <!--mod_specification_type_prototype-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_prototype"
                name="mod_specification_type_prototype"
                {{ runtimePrechecked($specification->mod_specification_type_prototype ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.prototype')</span>
        </label>
    </div>

    <!--mod_specification_type_seaming_diagram-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_seaming_diagram"
                name="mod_specification_type_seaming_diagram"
                {{ runtimePrechecked($specification->mod_specification_type_seaming_diagram ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.seaming_diagram')</span>
        </label>
    </div>

    <!--mod_specification_type_cut_sheet-->
    <div class="col-sm-12 col-lg-4 m-b-20">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="mod_specification_type_cut_sheet"
                name="mod_specification_type_cut_sheet"
                {{ runtimePrechecked($specification->mod_specification_type_cut_sheet ?? 'no') }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">@lang('designspecification::lang.cut_sheet')</span>
        </label>
    </div>
</div>

<div class="line"></div>

<!--more information - toggle-->
<div class="spacer row">
    <div class="col-sm-12 col-lg-8">
        <span class="title">@lang('designspecification::lang.images')</span>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="switch  text-right">
            <label>
                <input type="checkbox" name="more_information" id="more_information"
                    class="js-switch-toggle-hidden-content" data-target="toogle_images">
                <span class="lever switch-col-light-blue"></span>
            </label>
        </div>
    </div>
</div>
<!--more information-->
<div class="hidden p-t-10" id="toogle_images">
    <!--mod_specification_images_title-->
    <div class="form-group row">
        <label
            class="col-sm-12 text-left control-label col-form-label required">@lang('designspecification::lang.images_title')</label>
        <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="mod_specification_images_title"
                name="mod_specification_images_title"
                value="{{ $specification->mod_specification_images_title ?? '' }}">
        </div>
    </div>

    <!--fileupload-->
    <div class="form-group row">
        <div class="col-12">
            <div class="dropzone dz-clickable" id="mod_specification_image_1">
                <div class="dz-default dz-message">
                    <i class="icon-Upload-toCloud"></i>
                    <span>@lang('designspecification::lang.upload_notes_1')</span>
                </div>
            </div>
        </div>
    </div>
    <!--#fileupload-->

    <!--mod_specification_image_1_details-->
    <div class="form-group row">
        <label
            class="col-sm-12 text-left control-label col-form-label required">@lang('designspecification::lang.image_details')</label>
        <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="mod_specification_image_1_details"
                name="mod_specification_image_1_details"
                value="{{ $specification->mod_specification_image_1_details ?? '' }}">
        </div>
    </div>

    <div class="line"></div>


    <!--fileupload-->
    <div class="form-group row">
        <div class="col-12">
            <div class="dropzone dz-clickable" id="mod_specification_image_2">
                <div class="dz-default dz-message">
                    <i class="icon-Upload-toCloud"></i>
                    <span>@lang('designspecification::lang.upload_notes_1')</span>
                </div>
            </div>
        </div>
    </div>
    <!--#fileupload-->

    <!--mod_specification_image_2_details-->
    <div class="form-group row">
        <label
            class="col-sm-12 text-left control-label col-form-label required">@lang('designspecification::lang.image_details')</label>
        <div class="col-sm-12">
            <input type="text" class="form-control form-control-sm" id="mod_specification_image_2_details"
                name="mod_specification_image_2_details"
                value="{{ $specification->mod_specification_image_2_details ?? '' }}">
        </div>
    </div>

    <div class="line"></div>
    <!--delete speck images-->
    <div class="form-group form-group-checkbox row">
        <label class="col-10 col-form-label text-left">@lang('designspecification::lang.delete_spec_images')</label>
        <div class="col-2 text-right" style="padding-top:5px;">
            <input type="checkbox" id="delete_spec_images" name="delete_spec_images" class="filled-in chk-col-light-blue">
            <label class="p-l-30" for="delete_spec_images"></label>
        </div>
    </div>


</div>