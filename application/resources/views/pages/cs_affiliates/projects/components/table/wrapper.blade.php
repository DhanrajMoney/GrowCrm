<!--main table view-->
@include('pages.cs_affiliates.projects.components.table.table')

<!--filter-->
@if(auth()->user()->is_team)
@include('pages.cs_affiliates.projects.components.misc.filter')
@endif
<!--filter-->