@foreach($users as $user)
<!--each row-->
<tr id="user_{{ $user->id }}">
    <!--id-->
    <td class="col_id">
        {{ $user->id }}
    </td>

    <!--first_name-->
    <td class="col_first_name">
        {{ $user->first_name }}
    </td>
    <!--last_name-->
    <td class="col_last_name">
        {{ $user->last_name }}
    </td>
    <!--email-->
    <td class="col_email">
        {{ $user->email }}
    </td>


    <!--sum_completed_earnings-->
    <td class="col_sum_completed_earnings">
        {{ runtimeMoneyFormat($user->sum_completed_earnings) }}
    </td>
    
    <!--sum_pending_earnings-->
    <td class="col_sum_pending_earnings">
        {{ runtimeMoneyFormat($user->sum_pending_earnings) }}
    </td>


    <!--created-->
    <td class="col_created">
        {{ runtimeDate($user->created) }}
    </td>
    <td class="users_col_action actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/cs/affiliates') }}/users/{{ $user->id }}">
                <i class="sl-icon-trash"></i>
            </button>
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/cs/affiliates/users/'.$user->id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.edit_user')) }}"
                data-action-url="{{ urlResource('/cs/affiliates/users/'.$user->id) }}" data-action-method="PUT"
                data-action-ajax-class="js-ajax-ux-request" data-action-ajax-loading-target="users-td-container">
                <i class="sl-icon-note"></i>
            </button>

            <button type="button" title="{{ cleanLang(__('lang.update_password')) }}"
                class="data-toggle-action-tooltip btn btn-outline-warning btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ url('/cs/affiliates/users/'.$user->id.'/changepassword') }}"
                data-loading-target="commonModalBody" data-modal-title="{{ cleanLang(__('lang.update_password')) }}"
                data-action-url="{{ url('/cs/affiliates/users/'.$user->id.'/changepassword') }}"
                data-action-method="PUT" data-action-ajax-class=""
                data-action-ajax-loading-target="contacts-td-container">
                <i class="sl-icon-lock"></i>
            </button>

        </span>
    </td>
</tr>
@endforeach
<!--each row-->