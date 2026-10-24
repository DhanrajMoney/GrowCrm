<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for template
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\CS_Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Responses\CS_Affiliates\Earnings\IndexResponse;
use App\Http\Responses\CS_Affiliates\Earnings\StoreResponse;
use App\Repositories\CS_Affiliates\AffiliateRepository;
use Illuminate\Validation\Rule;
use Validator;

class Earnings extends Controller {

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

        if (!config('settings.custom_modules.cs_affiliate')) {
            abort(404);
        }

        //get affiliates
        $earnings = $this->affiliaterepo->searchEarnings();

        //payload
        $payload = [
            'earnings' => $earnings,
            'page' => $this->pageSettings('earnings'),
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

        //page
        $html = view('pages/cs_affiliates/earnings/components/modals/add-edit-inc')->render();
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
            'first_name.required' => __('lang.first_name') . ' - ' . __('lang.is_required'),
            'last_name.required' => __('lang.last_name') . ' - ' . __('lang.is_required'),
            'email.required' => __('lang.email') . ' - ' . __('lang.is_required'),
            'email.unique' => __('lang.email') . ' - ' . __('lang.already_exists'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'first_name' => [
                'required',
            ],
            'last_name' => [
                'required',
            ],
            'email' => [
                'required',
                Rule::unique('earnings', 'email'),
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
        $password = str_random(9);
        $earning = new \App\Models\earning();
        $earning->first_name = request('first_name');
        $earning->last_name = request('last_name');
        $earning->password = bcrypt($password);
        $earning->email = request('email');
        $earning->type = 'cs_affiliate';
        $earning->save();

        /** ----------------------------------------------
         * send email to earning
         * ----------------------------------------------*/
        $data = [
            'password' => $password,
        ];
        $mail = new \App\Mail\UserWelcome($earning, $data);
        $mail->build();

        //count rows
        $earnings = $this->affiliaterepo->searchEarningss();
        $count = count($earnings);

        //get this row
        $earnings = $this->affiliaterepo->searchEarningss($earning->id);

        //payload
        $payload = [
            'earnings' => $earnings,
            'earning' => $earnings->first(),
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

        //get the earning
        if (!$earning = \App\Models\Custom\CSAffiliateEarning::leftJoin('projects', 'projects.project_id', '=', 'cs_affiliate_earnings.cs_affiliate_earning_projectid')
            ->Where('cs_affiliate_earning_id', $id)->first()) {
            abort(404);
        }

        //page
        $html = view('pages/cs_affiliates/earnings/components/modals/add-edit-inc', compact('earning'))->render();
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

        //get the earning
        if (!$earning = \App\Models\Custom\CSAffiliateEarning::leftJoin('projects', 'projects.project_id', '=', 'cs_affiliate_earnings.cs_affiliate_earning_projectid')
            ->Where('cs_affiliate_earning_id', $id)->first()) {
            abort(404);
        }

        //update record
        $earning->cs_affiliate_earning_status = request('cs_affiliate_earning_status');
        if (request('cs_affiliate_earning_status') == 'paid') {
            $earning->cs_affiliate_earning_commission_approval_date = now();
        } else {
            $earning->cs_affiliate_earning_commission_approval_date = null;
        }
        $earning->save();

        //record event
        if (request('cs_affiliate_earning_status') == 'paid') {
            $event = new \App\Models\Custom\CSEvent();
            $event->cs_event_affliateid = $earning->cs_affiliate_earning_affiliateid;
            $event->cs_event_invoiceid = $earning->cs_affiliate_earning_invoiceid;
            $event->cs_event_amount = $earning->cs_affiliate_earning_amount;
            $event->cs_event_project_title = $earning->project_title;
            $event->save();
        } else {
            \App\Models\Custom\CSEvent::Where('cs_event_invoiceid', $earning->cs_affiliate_earning_invoiceid)->delete();
        }

        //get friendly row
        $earnings = $this->affiliaterepo->searchEarnings($id);

        $page = $this->pageSettings();

        $html = view('pages/cs_affiliates/earnings/components/table/ajax', compact('page', 'earnings'))->render();
        $jsondata['dom_html'][] = [
            'selector' => "#earning_$id",
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

        //get the record
        $earning = \App\Models\User::Where('id', $id)->where('type', 'cs_affiliate')->first();

        //delete record
        $earning->delete();

        //remove table row
        $jsondata['dom_visibility'][] = array(
            'selector' => '#earning_' . $id,
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
                'Earnings',
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'earnings',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_cs_affiliates' => 'active',
            'submenu_cs_affiliate_earnings' => 'active',
            'sidepanel_id' => 'sidepanel-filter-cs_affiliates',
            'dynamic_search_url' => url('cs/affiliates/search?action=search'),
            'add_button_classes' => 'add-edit-item-button',
            'source' => 'list',
            'meta_title' => 'Earnings',
            'heading' => 'Affiliates',
        ];

        //return
        return $page;
    }
}