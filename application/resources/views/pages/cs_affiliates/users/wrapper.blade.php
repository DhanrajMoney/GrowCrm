@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        @include('misc.heading-crumbs')
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        @include('pages.cs_affiliates.users.components.misc.list-page-actions')
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!--stats panel-->
    @if(auth()->user()->is_team)
    <div id="stats-wrapper cs_affiliates.users-stats-wrapper">
    @include('misc.list-pages-stats')
    </div>
    @endif
    <!--stats panel-->


    <!-- page content -->
    <div class="row">
        <div class="col-12">
            <!--cs_affiliates.users table-->
            @include('pages.cs_affiliates.users.components.table.wrapper')
            <!--cs_affiliates.users table-->
        </div>
    </div>
    <!--page content -->
</div>
<!--main content -->
@endsection