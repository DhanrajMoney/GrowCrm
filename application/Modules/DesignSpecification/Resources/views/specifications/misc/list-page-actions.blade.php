<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right {{ $page['list_page_actions_size'] ?? '' }} {{ $page['list_page_container_class'] ?? '' }}"
    id="list-page-actions-container">
    <div id="list-page-actions">

        <!--SEARCH BOX-->
        <div class="header-search" id="header-search">
            <i class="sl-icon-magnifier"></i>
            <input type="text" class="form-control search-records list-actions-search"
                data-url="{{ $page['dynamic_search_url'] ?? '' }}" data-type="form" data-ajax-type="post"
                data-form-id="header-search" id="search_query" name="search_query"
                placeholder="{{ cleanLang(__('lang.search')) }}">
        </div>

        <!--settings-->
        @if(auth()->user()->is_admin)
        <button type="button" title="{{ cleanLang(__('lang.settings')) }}"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-modal-title="@lang('designspecification::lang.general_notes')" data-toggle="modal"
            data-target="#commonModal" data-url="{{ url('modules/designspecification/settings/general-notes') }}"
            data-loading-target="commonModalBody"
            data-action-url="{{ url('modules/designspecification/settings/general-notes') }}" data-action-method="POST"
            data-action-ajax-loading-target="commonModalBody">
            <i class="sl-icon-wrench"></i>
        </button>
        @endif

        <!--settings-->
        @if(auth()->user()->is_team)
        <button type="button" data-toggle="tooltip" title="{{ cleanLang(__('lang.filter')) }}"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-side-panel"
            data-target="sidepanel-filter-mod-designspecification">
            <i class="mdi mdi-filter-outline"></i>
        </button>
        @endif


        <!--add aspec-->
        @if(auth()->user()->is_team)
        <button type="button"
            class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal"
            data-url="{{ url('modules/designspecification/create?action=create') }}"
            data-loading-target="commonModalBody"
            data-modal-title="@lang('designspecification::lang.create_new_specification')"
            data-action-url="{{ url('modules/designspecification') }}" data-action-method="POST"
            data-action-ajax-loading-target="commonModalBody">
            <i class="ti-plus"></i>
        </button>
        @endif


    </div>
</div>