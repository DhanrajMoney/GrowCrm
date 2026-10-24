<!-- right-sidebar -->
<div class="right-sidebar" id="sidepanel-filter-mod-designspecification">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>@lang('designspecification::lang.filter_specifications')
                <span>
                    <i class="ti-close js-close-side-panels" data-target="sidepanel-filter-invoices"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">

                <!--single filter item-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.company_name')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <!--select2 basic search-->
                                <select name="filter_mod_specification_client" id="filter_mod_specification_client"
                                    class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-ajax--url="{{ url('/feed/company_names') }}"></select>
                                <!--select2 basic search-->
                            </div>
                        </div>
                    </div>
                </div>

                <!--single filter item-->
                <div class="filter-block">
                    <div class="title">
                        {{ cleanLang(__('lang.project_title')) }}
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_mod_specification_project" id="filter_mod_specification_project"
                                    class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                                    data-ajax--url="{{ url('/feed/projects?ref=general') }}"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--single filter item-->


                <!--issue_date-->
                <div class="filter-block">
                    <div class="title">
                       @lang('designspecification::lang.issue_date')
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_mod_specification_date_issue_start" 
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="Start">
                                <input class="mysql-date" type="hidden" name="filter_mod_specification_date_issue_start" id="filter_mod_specification_date_issue_start"value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_mod_specification_date_issue_end" 
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="End">
                                <input class="mysql-date" type="hidden" name="filter_mod_specification_date_issue_end"
                                    id="filter_mod_specification_date_issue_end" value="">
                            </div>
                        </div>
                    </div>
                </div>


                <!--revision_date-->
                <div class="filter-block">
                    <div class="title">
                        @lang('designspecification::lang.revision_date')
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="filter_mod_specification_date_revision_start" 
                                    class="form-control form-control-sm pickadate" autocomplete="off"
                                    placeholder="{{ cleanLang(__('lang.start')) }}">
                                <input class="mysql-date" type="hidden" name="filter_mod_specification_date_revision_start" id="filter_mod_specification_date_revision_start"value="">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="filter_mod_specification_date_revision_end" 
                                    class="form-control form-control-sm pickadate" autocomplete="off" placeholder="{{ cleanLang(__('lang.end')) }}">
                                <input class="mysql-date" type="hidden" name="filter_mod_specification_date_revision_end" id="filter_mod_specification_date_revision_end"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
                <!--filter item-->
                <!--buttons-->
                <div class="buttons-block">
                    <button type="button" name="foo1"
                        class="btn btn-rounded-x btn-secondary js-reset-filter-side-panel">{{ cleanLang(__('lang.reset')) }}</button>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" value="{{ $page['source_for_filter_panels'] ?? '' }}">
                    <button type="button" class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        data-url="{{ urlResource('/modules/designspecification/search?') }}"
                        data-type="form" data-ajax-type="GET">{{ cleanLang(__('lang.apply_filter')) }}</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->