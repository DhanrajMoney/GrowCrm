@foreach($specifications as $specification)
<!--each row-->
<tr id="specifications_{{ $specification->mod_specification_id }}">
    <td class="col_mod_specification_specid">
        <a href="{{ url('/modules/designspecification/'.$specification->mod_specification_id) }}"
            title="@lang('lang.download')" download>{{ $specification->spec_id }}
        </a>
    </td>
    <td class="col_mod_specification_created">
        {{ runtimeDate($specification->mod_specification_date_issue) }}
    </td>
    <td class="mod_specification_item_name">
        {{ str_limit($specification->mod_specification_item_name ?? '---', 30) }}
    </td>
    @if(auth()->user()->is_team)
    <td class="col_mod_specification_client">
        @if($specification->client_company_name)
        <a href="{{ url('/clients/'.$specification->mod_specification_client) }}">
            {{ str_limit($specification->client_company_name, 20) }}
        </a>
        @else
        ---
        @endif
    </td>
    @endif
    <td class="col_mod_specification_project">
        @if($specification->project_title)
        <a href="{{ url('/projeccts/'.$specification->mod_specification_project) }}">
            {{ str_limit($specification->project_title, 20) }}
        </a>
        @else
        ---
        @endif
    </td>
    <td class="col_mod_specification_date_revision">
        {{ runtimeDate($specification->mod_specification_date_revision) }}
    </td>
    <td class="col_mod_specification_actions actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            @if(auth()->user()->is_team)
            <!--delete-->
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="@lang('lang.delete_item')" data-confirm-text="@lang('lang.are_you_sure')"
                data-ajax-type="DELETE"
                data-url="{{ url('/') }}/modules/designspecification/{{ $specification->mod_specification_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/modules/designspecification/'.$specification->mod_specification_id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_item')) }}"
                data-action-url="{{ urlResource('/modules/designspecification/'.$specification->mod_specification_id) }}"
                data-action-method="PUT" data-action-ajax-class="js-ajax-ux-request"
                data-action-ajax-loading-target="specifications-td-container">
                <i class="sl-icon-note"></i>
            </button>

            <!--edit clent and project-->
            <button type="button" title="@lang('designspecification::lang.edit_client_project')"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/modules/designspecification/'.$specification->mod_specification_id.'/client-project') }}"
                data-loading-target="commonModalBody"
                data-modal-title="@lang('designspecification::lang.edit_client_project')"
                data-action-url="{{ urlResource('/modules/designspecification/'.$specification->mod_specification_id.'/client-project') }}"
                data-action-method="PUT" data-action-ajax-class="js-ajax-ux-request"
                data-action-ajax-loading-target="specifications-td-container">
                <i class="sl-icon-people"></i>
            </button>
            @endif
            <!--view-->
            <a href="{{ url('/modules/designspecification/'.$specification->mod_specification_id) }}"
                title="@lang('lang.download')" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm"
                download>
                <i class="ti-download"></i>
            </a>
            @if(auth()->user()->is_team)
            <!--email-->
            <button type="button" title="@lang('designspecification::lang.email_client')"
                class="data-toggle-action-tooltip btn btn-outline-warning btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/modules/designspecification/'.$specification->mod_specification_id.'/email-specification') }}"
                data-loading-target="commonModalBody"
                data-modal-title="@lang('designspecification::lang.email_specification')"
                data-action-url="{{ urlResource('/modules/designspecification/'.$specification->mod_specification_id.'/email-specification') }}"
                data-action-method="PUT" data-action-ajax-class="js-ajax-ux-request"
                data-action-ajax-loading-target="specifications-td-container">
                <i class="ti-email display-inline-block m-t-3"></i>
            </button>
            @endif
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->