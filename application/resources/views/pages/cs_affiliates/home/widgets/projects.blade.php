<div class="col-lg-5  col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">My Projects</h5>
            <table class="table browser m-t-30 no-border" style="width:100%;">
                <tbody>
                    @foreach($payload['projects'] as $project)
                    <tr>
                        <td>{{ str_limit($project->project_title ?? '---', 55) }}</td>
                        <td class="text-right" style="width:40px">
                            {{ (float) $project->cs_affiliate_project_commission_rate }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>