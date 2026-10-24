<div class="row">
    <!--TOTAL EARNINGS-->
    <div class="col-lg-3 col-md-6 cursor-pointer">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ runtimeMoneyFormat($payload['profits']['today']) }}</h2>
                        <h6 class="text-muted m-b-0">@lang('lang.earnings') - @lang('lang.today')</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-success icon-Credit-Card2"></i>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-success w-100 h-px-3" role="progressbar" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!--TOTAL EARNINGS-->
    <div class="col-lg-3 col-md-6 cursor-pointer">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ runtimeMoneyFormat($payload['profits']['this_month']) }}</h2>
                        <h6 class="text-muted m-b-0">@lang('lang.earnings') - @lang('lang.this_month')</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-info icon-Credit-Card2"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-info w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!--TOTAL EARNINGS-->
    <div class="col-lg-3 col-md-6 cursor-pointer">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ runtimeMoneyFormat($payload['profits']['all_time']) }}</h2>
                        <h6 class="text-muted m-b-0">@lang('lang.earnings') - @lang('lang.total')</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-warning icon-Coin"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-warning w-100 h-px-3" role="progressbar" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <!--TOTAL EARNINGS-->
    <div class="col-lg-3 col-md-6 cursor-pointer">
        <div class="card">
            <div class="card-body p-l-15 p-r-15">
                <div class="d-flex p-10 no-block">
                    <span class="align-slef-center">
                        <h2 class="m-b-0">{{ runtimeMoneyFormat($payload['profits']['pending']) }}</h2>
                        <h6 class="text-muted m-b-0">@lang('lang.earnings') - @lang('lang.pending')</h6>
                    </span>
                    <div class="align-self-center display-6 ml-auto"><i class="text-danger icon-Coins-2"></i></div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar bg-danger w-100 h-px-3" role="progressbar" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>