<div class="card count-{{ @count($earnings) }}" id="earnings-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($earnings) > 0)
            <table id="earning-earning-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--cs_affiliate_earning_invoiceid-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_cs_affiliate_earning_invoiceid" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=cs_affiliate_earning_invoiceid&sortorder=asc') }}">@lang('lang.invoice')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--cs_affiliate_earning_created-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_cs_affiliate_earning_created" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=cs_affiliate_earning_created&sortorder=asc') }}">@lang('lang.date')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--project-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_project"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=project&sortorder=asc') }}">@lang('lang.project')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--invoice_amount-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_final_amount"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=bill_final_amount&sortorder=asc') }}">@lang('lang.amount')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--cs_affiliate_project_commission_rate-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_cs_affiliate_earning_commission_rate" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=cs_affiliate_earning_commission_rate&sortorder=asc') }}">@lang('lang.commission')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--cs_affiliate_earning_amount-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_cs_affiliate_earning_amount" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=cs_affiliate_earning_amount&sortorder=asc') }}">@lang('lang.earned')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--cs_affiliate_earning_status-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_cs_affiliate_earning_status" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/earnings?action=sort&orderby=cs_affiliate_earning_status&sortorder=asc') }}">@lang('lang.status')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        @if(auth()->user()->is_admin)
                        <th class="col_action"><a href="javascript:void(0)">@lang('lang.action')</a></th>
                        @endif

                    </tr>
                </thead>
                <tbody id="earnings-td-container">
                    <!--ajax content here-->
                    @include('pages.cs_affiliates.earnings.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tearningt>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tearningt>
            </table>
            @endif @if (@count($earnings) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>