<?php

/** --------------------------------------------------------------------------------
 * This controller manages all the business logic for template
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Controllers\CS_Affiliates;

use App\Http\Controllers\Controller;
use App\Http\Responses\CS_Affiliates\Users\IndexResponse;
use App\Http\Responses\CS_Affiliates\Users\StoreResponse;
use App\Repositories\CS_Affiliates\AffiliateRepository;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Hash;

class Users extends Controller {

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
        
        //get affiliates
        $users = $this->affiliaterepo->searchUsers();

        //payload
        $payload = [
            'users' => $users,
            'page' => $this->pageSettings('users'),
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
        $html = view('pages/cs_affiliates/users/components/modals/add-edit-inc')->render();
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
                Rule::unique('users', 'email'),
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
        $user = new \App\Models\user();
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->password = bcrypt($password);
        $user->email = request('email');
        $user->type = 'cs_affiliate';
        $user->save();

        /** ----------------------------------------------
         * send email to user
         * ----------------------------------------------*/
        $data = [
            'password' => $password,
        ];
        $mail = new \App\Mail\UserWelcome($user, $data);
        $mail->build();

        //count rows
        $users = $this->affiliaterepo->searchUsers();
        $count = count($users);

        //get this row
        $users = $this->affiliaterepo->searchUsers($user->id);

        //payload
        $payload = [
            'users' => $users,
            'user' => $users->first(),
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

        //get the user
        if (!$user = \App\Models\user::Where('id', $id)->first()) {
            abort(404);
        }

        //page
        $html = view('pages/cs_affiliates/users/components/modals/add-edit-inc', compact('user'))->render();
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

        //get the user
        if (!$user = \App\Models\user::Where('id', $id)->first()) {
            abort(404);
        }

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
                Rule::unique('users', 'email')->ignore($user->email, 'email'),
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
        $user->first_name = request('first_name');
        $user->last_name = request('last_name');
        $user->email = request('email');
        $user->save();

        //get friendly row
        $users = $this->affiliaterepo->searchUsers($id);

        $page = $this->pageSettings();

        $html = view('pages/cs_affiliates/users/components/table/ajax', compact('page', 'users'))->render();
        $jsondata['dom_html'][] = [
            'selector' => "#user_$id",
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
        $user = \App\Models\User::Where('id', $id)->where('type', 'cs_affiliate')->first();

        //delete record
        $user->delete();

        //remove table row
        $jsondata['dom_visibility'][] = array(
            'selector' => '#user_' . $id,
            'action' => 'slideup-slow-remove',
        );

        //success
        $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

        //response
        return response()->json($jsondata);

    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function editPassword($id) {

        //get the user
        if (!\App\Models\user::Where('id', $id)->first()) {
            abort(404);
        }

        //page
        $html = view('pages/cs_affiliates/users/components/modals/change-password')->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword($id) {

        //get the user
        if (!$user = \App\Models\user::Where('id', $id)->first()) {
            abort(404);
        }

        $messages = [
            'password.required' => __('lang.password') . ' - ' . __('lang.is_required'),
            'password.confirmed' => __('lang.foo') . ' - do not match',
        ];

        //validate (add specific error messages, per field name, in validation.lang)
        $validator = Validator::make(request()->all(), [
            'password' => 'required|confirmed',
        ]);

        //errors
        if ($validator->fails()) {
            $errors = $validator->errors();
            $messages = '';
            foreach ($errors->all() as $message) {
                $messages .= "<li>$message</li>";
            }

            abort(409, $messages);
        }

        //update database
        $user->password = Hash::make(request('password'));
        $user->save();

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
                'Users',
            ],
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'users',
            'no_results_message' => __('lang.no_results_found'),
            'mainmenu_cs_affiliates' => 'active',
            'submenu_cs_affiliate_users' => 'active',
            'sidepanel_id' => 'sidepanel-filter-cs_affiliates',
            'dynamic_search_url' => url('cs/affiliates/search?action=search'),
            'add_button_classes' => 'add-edit-item-button',
            'source' => 'list',
            'meta_title' => 'Affiliates',
            'heading' => 'Affiliates',
        ];

        //return
        return $page;
    }
}