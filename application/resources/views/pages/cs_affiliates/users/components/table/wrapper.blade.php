<!--main table view-->
@include('pages.cs_affiliates.users.components.table.table')

<!--filter-->
@if(auth()->user()->is_team)
@include('pages.cs_affiliates.users.components.misc.filter')
@endif
<!--filter-->