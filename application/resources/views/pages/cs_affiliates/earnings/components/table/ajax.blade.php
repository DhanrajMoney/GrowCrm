@foreach($earnings as $earning)
<!--each row-->
<tr id="earning_{{ $earning->cs_affiliate_earning_id }}">
    <!--cs_affiliate_earning_invoiceid-->
    <td class="col_cs_affiliate_earning_invoiceid">
        @if(auth()->user()->is_team)
        <a
            href="{{ url('/invoices/'.$earning->cs_affiliate_earning_invoiceid	) }}">{{ runtimeInvoiceIdFormat($earning->cs_affiliate_earning_invoiceid) }}</a>
        @else
        {{ runtimeInvoiceIdFormat($earning->cs_affiliate_earning_invoiceid) }}
        @endif
    </td>

    <!--cs_affiliate_earning_created-->
    <td class="col_cs_affiliate_earning_created">
        {{ runtimeDate($earning->cs_affiliate_earning_created) }}
    </td>

    <!--project-->
    <td class="col_project">
        @if(auth()->user()->is_team)
        <a href="{{ url('/projects/'.$earning->project_id) }}">{{ str_limit($earning->project_title ?? '---', 20) }}</a>
        @else
        {{ str_limit($earning->project_title ?? '---', 20) }}
        @endif
    </td>


    <!--invoice_amount-->
    <td class="col_invoice_amount">
        {{ runtimeMoneyFormat($earning->bill_final_amount) }}
    </td>

    <!--cs_affiliate_project_commission_rate-->
    <td class="col_cs_affiliate_project_commission_rate">
        {{ (float) ($earning->cs_affiliate_earning_commission_rate ?? '0') }}
    </td>

    <!--cs_affiliate_earning_amount-->
    <td class="col_cs_affiliate_earning_amount">
        {{ runtimeMoneyFormat($earning->cs_affiliate_earning_amount) }}
    </td>

    <!--cs_affiliate_earning_status-->
    <td class="col_cs_affiliate_earning_status">
        @if($earning->cs_affiliate_earning_status == 'paid')
        <span class="label label-outline-success">Paid</span>
        @else
        <span class="label label-outline-default">Pending Clearance</span>
        @endif
    </td>
    @if(auth()->user()->is_admin)
    <td class="earnings_col_action actions_column">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_item')) }}"
                data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
                data-url="{{ url('/cs/affiliates') }}/earnings/{{ $earning->cs_affiliate_earning_id }}">
                <i class="sl-icon-trash"></i>
            </button>
            <!--edit-->
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/cs/affiliates/earnings/'.$earning->cs_affiliate_earning_id.'/edit') }}"
                data-loading-target="commonModalBody" data-modal-title="@lang('lang.change_status')"
                data-action-url="{{ urlResource('/cs/affiliates/earnings/'.$earning->cs_affiliate_earning_id) }}" data-action-method="PUT"
                data-action-ajax-class="js-ajax-ux-request" data-action-ajax-loading-target="earnings-td-container">
                <i class="sl-icon-note"></i>
            </button>
        </span>
    </td>
    @endif
</tr>
@endforeach
<!--each row-->