@extends('layout.wrapper') @section('content')
<!-- main content -->
<div class="container-fluid">

    <!--TOP STATS-->
    <div id="js-trigger-home-team-wrapper">
        @include('pages.cs_affiliates.home.widgets.toprow')
        
        <div class="row">
            @include('pages.cs_affiliates.home.widgets.activity')
            @include('pages.cs_affiliates.home.widgets.projects')
        </div>
    </div>

</div>
<!--main content -->
@endsection