<div class="card count-{{ @count($specifications) }}" id="mod-specifications-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($specifications) > 0)
            <table id="mod-specifications-table" class="table m-t-0 m-b-0 table-hover no-wrap" data-page-size="10">
                <thead>
                    <tr>
                        <th class="col_mod_specification_specid"><a class="js-ajax-ux-request js-list-sorting"
                            id="sort_mod_specification_spec_id" href="javascript:void(0)"
                            data-url="{{ urlResource('/items?action=sort&orderby=mod_specification_spec_id&sortorder=asc') }}">@lang('designspecification::lang.spec_id')<span class="sorting-icons"><i
                                class="ti-arrows-vertical"></i></span></a></th>
                        <th class="col_mod_specification_created"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_mod_specification_date_issue" href="javascript:void(0)"
                                data-url="{{ urlResource('/modules/designspecification?action=sort&orderby=mod_specification_date_issue&sortorder=asc') }}">@lang('designspecification::lang.issue_date')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <th class="sort_mod_specification_item_name"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_mod_specification_item_name" href="javascript:void(0)"
                                data-url="{{ urlResource('/modules/designspecification?action=sort&orderby=mod_specification_item_name&sortorder=asc') }}">
                                @lang('designspecification::lang.item_name')<span class="sorting-icons"><i
                                        class="ti-arrows-vertical"></i></span></a></th>
                        @if(auth()->user()->is_team)
                        <th class="col_mod_specification_client"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_client_name" href="javascript:void(0)"
                                data-url="{{ urlResource('/modules/designspecification?action=sort&orderby=client_name&sortorder=asc') }}">{{ cleanLang(__('lang.client')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        @endif
                        <th class="col_mod_specification_project"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_project_title" href="javascript:void(0)"
                                data-url="{{ urlResource('/modules/designspecification?action=sort&orderby=project_title&sortorder=asc') }}">{{ cleanLang(__('lang.project')) }}<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <th class="col_mod_specification_date_revision"><a class="js-ajax-ux-request js-list-sorting"
                                id="sort_mod_specification_date_revision" href="javascript:void(0)"
                                data-url="{{ urlResource('/modules/designspecification?action=sort&orderby=mod_specification_date_revision&sortorder=asc') }}">@lang('designspecification::lang.revision_date')<span
                                    class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                        <th class="col_mod_specification_actions"><a
                                href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    </tr>
                </thead>
                <tbody id="mod-specifications-td-container">
                    <!--ajax content here-->
                    @include('designspecification::specifications.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($specifications) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>