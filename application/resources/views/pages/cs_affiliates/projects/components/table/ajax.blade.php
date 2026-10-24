@foreach($projects as $project)
<!--each row-->
<tr id="project_{{ $project->cs_affiliate_project_id }}">
    <!--cs_affiliate_project_id-->
    <td class="col_project_id">
        {{ $project->cs_affiliate_project_id }}
    </td>

    <!--first_name-->
    <td class="col_first_name">
        {{ $project->first_name }} {{ $project->last_name }}
    </td>

    <!--col_cs_affiliate_project_projectid-->
    <td class="col_cs_affiliate_project_projectid">
        <a
            href="{{ url('/projects/'.$project->cs_affiliate_project_projectid) }}">{{ str_limit($project->project_title ?? '---', 20) }}</a>
    </td>

    <!--commission-->
    <td class="col_commission">
        {{ (float) $project->cs_affiliate_project_commission_rate }}%
    </td>

    <!--cs_affiliate_project_status-->
    <td class="col_cs_affiliate_project_status">
        @if($project->cs_affiliate_project_status == 'active')
        <span class="label label-outline-info">@lang('lang.active')</span>
        @else
        <span class="label label-outline-danger">@lang('lang.suspended')</span>
        @endif
    </td>

    <!--action-->
    <td class="projects_col_action actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/cs/affiliates') }}/projects/{{ $project->cs_affiliate_project_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/cs/affiliates/projects/'.$project->cs_affiliate_project_id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="@lang('lang.edit_affiliate_project')"
                data-action-url="{{ urlResource('/cs/affiliates/projects/'.$project->cs_affiliate_project_id) }}" data-action-method="PUT"
                data-action-ajax-class="js-ajax-ux-request" data-action-ajax-loading-target="projects-td-container">
                <i class="sl-icon-note"></i>
            </button>
        </span>
    </td>
</tr>
@endforeach
<!--each row-->