<!--main table view-->
@include('designspecification::specifications.table.table')

<!--filter-->
@if(auth()->user()->is_team)
@include('designspecification::specifications.misc.filter')
@endif
<!--filter-->
<!--JAVASCRIPT-->
<script src="application/Modules/DesignSpecification/Resources/assets/js/module.js"></script>

