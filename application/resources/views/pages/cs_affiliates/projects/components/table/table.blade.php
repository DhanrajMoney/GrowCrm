<div class="card count-{{ @count($projects) }}" id="projects-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($projects) > 0)
            <table id="project-project-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list"
                data-page-size="10">
                <thead>
                    <tr>
                        <!--cs_affiliate_project_id-->
                        <th class="col_project_id"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_cs_affiliate_project_id" href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/projects?action=sort&orderby=cs_affiliate_project_id&sortorder=asc') }}">@lang('lang.id')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--first_name-->
                        <th class="col_first_name"><a class="js-ajax-ux-request js-list-sorting" id="sort_first_name"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/projects?action=sort&orderby=first_name&sortorder=asc') }}">@lang('lang.affiliate')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--project_title-->
                        <th class="col_project_title"><a class="js-ajax-ux-request js-list-sorting" id="sort_project_title"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/projects?action=sort&orderby=project_title&sortorder=asc') }}">@lang('lang.project')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--commission-->
                        <th class="col_commission"><a class="js-ajax-ux-request js-list-sorting" id="sort_cs_affiliate_project_commission_rate"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/projects?action=sort&orderby=cs_affiliate_project_commission_rate&sortorder=asc') }}">@lang('lang.commission')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--cs_affiliate_project_status	-->
                        <th class="col_cs_affiliate_project_status"><a class="js-ajax-ux-request js-list-sorting" id="sort_cs_affiliate_project_status"
                                href="javascript:void(0)"
                                data-url="{{ urlResource('/cs/affiliates/projects?action=sort&orderby=cs_affiliate_project_status&sortorder=asc') }}">@lang('lang.status')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <!--action-->
                        <th class="projects_col_action"><a
                                href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a>
                        </th>
                    </tr>
                </thead>
                <tbody id="projects-td-container">
                    <!--ajax content here-->
                    @include('pages.cs_affiliates.projects.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tfooter>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfooter>
            </table>
            @endif @if (@count($projects) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>