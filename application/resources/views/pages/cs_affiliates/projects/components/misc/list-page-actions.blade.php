<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right {{ $page['list_page_actions_size'] ?? '' }} {{ $page['list_page_container_class'] ?? '' }}"
    id="list-page-actions-container">
    <div id="list-page-actions">

        <!--SEARCH BOX-->
        @if(auth()->user()->is_admin)
        <div class="header-search" id="header-search">
            <i class="sl-icon-magnifier"></i>
            <input type="text" class="form-control search-records list-actions-search"
                data-url="{{ $page['dynamic_search_url'] ?? '' }}" data-type="form" data-ajax-type="post"
                data-form-id="header-search" id="search_query" name="search_query"
                placeholder="{{ cleanLang(__('lang.search')) }}">
        </div>
        @endif

        <!--ADD NEW ITEM-->
        @if(auth()->user()->is_admin)
        <button type="button"
            class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" 
            data-target="#commonModal" 
            data-url="{{ url('cs/affiliates/projects/create') }}"
            data-loading-target="commonModalBody" 
            data-modal-title="@lang('lang.add_affiliate_project')"
            data-action-url="{{ url('cs/affiliates/projects') }}"
            data-action-method="POST"
            data-action-ajax-loading-target="commonModalBody">
            <i class="ti-plus"></i>
        </button>
        @endif
    </div>
</div>