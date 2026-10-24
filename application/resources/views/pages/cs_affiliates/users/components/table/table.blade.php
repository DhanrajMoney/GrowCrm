<div class="card count-{{ @count($users) }}" id="users-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($users) > 0)
            <table id="user-user-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                <thead>
                    <tr>
                        <!--id-->
                        <th class="col_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_id"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=id&sortorder=asc') }}">@lang('lang.id')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--first_name-->
                        <th class="col_first_name"><a class="js-ajax-ux-request js-list-sorting" id="sort_first_name"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=first_name&sortorder=asc') }}">@lang('lang.first_name')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--last_name-->
                        <th class="col_last_name"><a class="js-ajax-ux-request js-list-sorting" id="sort_last_name"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=last_name&sortorder=asc') }}">@lang('lang.last_name')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--email-->
                        <th class="col_email"><a class="js-ajax-ux-request js-list-sorting" id="sort_email"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=email&sortorder=asc') }}">@lang('lang.email')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>


                        <!--sum_completed_earnings-->
                        <th class="col_sum_completed_earnings"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_sum_completed_earnings" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=sum_completed_earnings&sortorder=asc') }}">@lang('lang.earned')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <!--sum_pending_earnings-->
                        <th class="col_sum_pending_earnings"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_sum_pending_earnings" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=sum_pending_earnings&sortorder=asc') }}">@lang('lang.pending_clearance')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>



                        <!--created	-->
                        <th class="col_created"><a class="js-ajax-ux-request js-list-sorting" id="sort_created"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/users?action=sort&orderby=created&sortorder=asc') }}">@lang('lang.created')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>

                        <th class="users_col_action"><a href="javascript:void(0)">@lang('lang.action')</a>

                        </th>
                    </tr>
                </thead>
                <tbody id="users-td-container">
                    <!--ajax content here-->
                    @include('pages.cs_affiliates.users.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tusert>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tusert>
            </table>
            @endif @if (@count($users) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>