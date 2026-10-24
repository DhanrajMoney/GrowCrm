<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for template
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\CS_Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Responses\CS_Affiliates\Projects\IndexResponse;
use App\Http\Responses\CS_Affiliates\Projects\StoreResponse;
use App\Repositories\CS_Affiliates\AffiliateRepository;
use Validator;

class Projects extends Controller {

    protected $affiliaterepo;

    public function __construct(AffiliateRepository $affiliaterepo) {

        //parent
        parent::__construct();

        $this->affiliaterepo = $affiliaterepo;

        //authenticated
        $this->middleware('auth');

    }
    /**
     * Display the dashboard home page
     * @return blade view | ajax view
     */
    public function index() {

        //is the module enabled
        if (!config('settings.custom_modules.cs_affiliate')) {
            abort(404);
        }

        //security
        if (auth()->user()->type != 'team') {
            abort(403);
        }

        //get affiliates
        $projects = $this->affiliaterepo->searchProjects();

        //payload
        $payload = [
            'projects' => $projects,
            'page' => $this->pageSettings('projects'),
        ];

        //render
        return new IndexResponse($payload);

    }

    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        //get all affilate users
        $affiliates = \App\Models\user::Where('type', 'cs_affiliate')->orderBy('first_name', 'ASC')->get();
        $projects_list = \App\Models\Project::orderBy('project_title', 'ASC')->get();

        //form options
        config(['visibility.creating_mode' => true]);

        //page
        $html = view('pages/cs_affiliates/projects/components/modals/add-edit-inc', compact('affiliates', 'projects_list'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {

        //custom error messages
        $messages = [
            'cs_affiliate_project_projectid.required' => __('lang.first_name') . ' - ' . __('lang.is_required'),
            'cs_affiliate_project_affiliateid.required' => __('lang.last_name') . ' - ' . __('lang.is_required'),
            'cs_affiliate_project_commission_rate.required' => __('lang.email') . ' - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'cs_affiliate_project_projectid' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (request()->filled('cs_affiliate_project_affiliateid') && request()->filled('cs_affiliate_project_projectid')) {
                        if (\App\Models\Custom\CSAffiliateProject::Where('cs_affiliate_project_projectid', request('cs_affiliate_project_projectid'))
                            ->Where('cs_affiliate_project_affiliateid', request('cs_affiliate_project_affiliateid'))
                            ->exists()) {
                            return $fail('Affiliate is already linked to this project');
                        }
                    }
                },
            ],
            'cs_affiliate_project_affiliateid' => [
                'required',
            ],
            'cs_affiliate_project_commission_rate' => [
                'required',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //store record
        $project = new \App\Models\Custom\CSAffiliateProject();
        $project->cs_affiliate_project_creatorid = auth()->id();
        $project->cs_affiliate_project_affiliateid = request('cs_affiliate_project_affiliateid');
        $project->cs_affiliate_project_commission_rate = request('cs_affiliate_project_commission_rate');
        $project->cs_affiliate_project_projectid = request('cs_affiliate_project_projectid');
        $project->save();

        //count rows
        $projects = $this->affiliaterepo->searchProjects();
        $count = count($projects);

        //get this row
        $projects = $this->affiliaterepo->searchProjects($project->cs_affiliate_project_id);

        //payload
        $payload = [
            'projects' => $projects,
            'project' => $projects->first(),
            'count' => $count,
            'page' => $this->pageSettings(),
        ];

        //render
        return new StoreResponse($payload);

    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        //get the project
        if (!$project = \App\Models\Custom\CSAffiliateProject::Where('cs_affiliate_project_id', $id)->first()) {
            abort(404);
        }

        //get all affilate users
        $affiliates = \App\Models\user::Where('type', 'cs_affiliate')->orderBy('first_name', 'ASC')->get();
        $projects_list = \App\Models\Project::orderBy('project_title', 'ASC')->get();

        //form options
        config(['visibility.editing_mode' => true]);

        //page
        $html = view('pages/cs_affiliates/projects/components/modals/add-edit-inc', compact('project', 'affiliates', 'projects_list'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id) {

        //get the project
        if (!$project = \App\Models\Custom\CSAffiliateProject::Where('cs_affiliate_project_id', $id)->first()) {
            abort(404);
        }

        //custom error messages
        $messages = [
            'cs_affiliate_project_status.required' => __('lang.status') . ' - ' . __('lang.is_required'),
            'cs_affiliate_project_commission_rate.required' => 'Commission - ' . __('lang.is_required'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'cs_affiliate_project_status' => [
                'required',
            ],
            'cs_affiliate_project_commission_rate' => [
                'required',
            ],
        ], $messages);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }
            abort(409, $messages);
        }

        //update record
        $project->cs_affiliate_project_status = request('cs_affiliate_project_status');
        $project->cs_affiliate_project_commission_rate = request('cs_affiliate_project_commission_rate');
        $project->save();

        //get friendly row
        $projects = $this->affiliaterepo->searchProjects($id);

        $page = $this->pageSettings('projects');

        $html = view('pages/cs_affiliates/projects/components/table/ajax', compact('page', 'projects'))->render();
        $jsondata['dom_html'][] = [
            'selector' => "#project_$id",
            'action' => 'replace-with',
            'value' => $html,
        ];

        //close modal
        $jsondata['dom_visibility'][] = [
            'selector' => '#commonModal', 'action' => 'close-modal',
        ];

        //notice error
        $jsondata['notification'] = [
            'type' => 'success',
            'value' => __('lang.request_has_been_completed'),
        ];

        //ajax response
        return response()->json($jsondata);

    }

    /**
     * delete a record
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        //get the project
        if (!$project = \App\Models\Custom\CSAffiliateProject::Where('cs_affiliate_project_id', $id)->first()) {
            abort(404);
        }

        //delete record
        $project->delete();

        //delete earning
        \App\Models\Custom\CSAffiliateEarning::Where('cs_affiliate_earning_projectid', $id)->delete();

        //remove table row
        $jsondata['dom_visibility'][] = array(
            'selector' => '#project_' . $id,
            'action' => 'slideup-slow-remove',
        );

        //success
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

    /**
     * basic page setting for this section of the app
     * @param string $section page section (optional)
     * @param array $data any other data (optional)
     * @return array
     */
    private function pageSettings($section = '', $data = []) {

        //common settings
        $page = [
            'crumbs' => [
                'Affiliates',
                'Projects',
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'projects',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_cs_affiliates' => 'active',
            'submenu_cs_affiliate_projects' => 'active',
            'sidepanel_id' => 'sidepanel-filter-cs_affiliates',
            'dynamic_search_url' => url('cs/affiliates/search?action=search'),
            'add_button_classes' => 'add-edit-item-button',
            'source' => 'list',
            'meta_title' => '',
            'heading' => 'Affiliates',
        ];

        //return
        return $page;
    }
}