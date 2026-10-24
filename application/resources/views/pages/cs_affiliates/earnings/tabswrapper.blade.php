<!-- action buttons -->
@include('pages.cs_affiliates.earnings.components.misc.list-page-actions')
<!-- action buttons -->

<!--stats panel-->
@if(auth()->user()->is_team)
<div id="foos-stats-wrapper" class="stats-wrapper card-embed-fix">
@if (@count($foos) > 0) @include('misc.list-pages-stats') @endif
</div>
@endif
<!--stats panel-->