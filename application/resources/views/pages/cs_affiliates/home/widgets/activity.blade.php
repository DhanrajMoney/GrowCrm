<div class="col-lg-7  col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">@lang('lang.latest_activity')</h5>
            <div class="dashboard-events profiletimeline ps ps--active-y" id="dashboard-client-events">
                @foreach($payload['events'] as $event)
                <!--each events item-->
                <div class="sl-item timeline m-b-20">
                    <div class="sl-left">
                        <img src="{{ url('/storage/avatars/system/default_avatar.jpg') }}"
                            style="width: 35px;height: 35px;" alt="user" class="img-circle">
                    </div>
                    <div class="sl-right">
                        <div>
                            <div><small>{{ runtimeDateAgo($event->cs_event_created) }}</small></div>
                            <div>
                                @lang('lang.you_earned') <strong>{{ runtimeMoneyFormat($event->cs_event_amount) }}</strong> @lang('lang.from_project') <strong>{{ str_limit($event->cs_event_project_title ?? '---', 30) }}</strong> @lang('lang.with_invoice_id'):
                                <strong>{{ runtimeInvoiceIdFormat($event->cs_event_invoiceid) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <!--load more-->
        </div>
    </div>
</div>