<!-- ============================================================== -->
<!-- [AFFILIATE]  -->
<!-- ============================================================== -->
<aside class="left-sidebar" id="js-trigger-nav-client">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <!--home-->
                <li class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.home')) }}">
                    <a class="waves-effect waves-dark" href="/home" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.dashboard')) }}
                        </span>
                    </a>
                </li>
                <!--home-->

                <!--home-->
                <li class="sidenav-menu-item {{ $page['mainmenu_cs_affiliate_earnings'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="Profit">
                    <a class="waves-effect waves-dark" href="/cs/affiliate/my/earnings" aria-expanded="false" target="_self">
                        <i class="ti-wallet"></i>
                        <span class="hide-menu">@lang('lang.earnings')
                        </span>
                    </a>
                </li>
                <!--home-->


            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>