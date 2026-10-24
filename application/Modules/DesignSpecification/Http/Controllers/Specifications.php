<?php

namespace Modules\DesignSpecification\Http\Controllers;

use App\Repositories\FileRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\DesignSpecification\Http\Requests\StoreUpdate;
use Modules\DesignSpecification\Http\Responses\Specifications\IndexResponse;
use Modules\DesignSpecification\Http\Responses\Specifications\PDFResponse;
use Modules\DesignSpecification\Http\Responses\Specifications\StoreResponse;
use Modules\DesignSpecification\Http\Responses\Specifications\UpdateResponse;
use Modules\DesignSpecification\Repositories\SpecificationsRepository;

class Specifications extends Controller {

    /**
     * The specificationrepo repository instance.
     */
    protected $specificationrepo;

    public function __construct(SpecificationsRepository $specificationrepo) {

        //authenticated
        $this->middleware('auth');

        $this->specificationrepo = $specificationrepo;

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index() {

        //get items
        $specifications = $this->specificationrepo->search();

        //count
        $count = count($specifications);

        //reponse payload
        $payload = [
            'page' => $this->pageSettings(),
            'specifications' => $specifications,
            'count' => $count,
        ];

        //show the view
        return new IndexResponse($payload);

    }

    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //page
        $html = view('designspecification::specifications/modals/add-edit')->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'ModuleSpecificationAddEdit',
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdate $request, SpecificationsRepository $specificationrepo, FileRepository $filerepo) {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //additional validation
        /*$count = 0;
        (request('mod_specification_type_finish_sample') == 'on') ? $count++ : null;
        (request('mod_specification_type_strike_off') == 'on') ? $count++ : null;
        (request('mod_specification_type_cutting') == 'on') ? $count++ : null;
        (request('mod_specification_type_shop_drawing') == 'on') ? $count++ : null;
        (request('mod_specification_type_prototype') == 'on') ? $count++ : null;
        (request('mod_specification_type_seaming_diagram') == 'on') ? $count++ : null;
        (request('mod_specification_type_cut_sheet') == 'on') ? $count++ : null;

        if ($count == 0) {
        abort(409, __('designspecification::lang.stage_not_selected'));
        }
         */

        //store record
        $specification = new \Modules\DesignSpecification\Models\Specification();
        $specification->mod_specification_creatorid = auth()->id();
        $specification->mod_specification_client = request('mod_specification_client');
        $specification->mod_specification_project = request('mod_specification_project');
        $specification->mod_specification_date_issue = request('mod_specification_date_issue');
        $specification->mod_specification_date_revision = request('mod_specification_date_revision');
        $specification->mod_specification_item_name = request('mod_specification_item_name');
        $specification->mod_specification_id_building_venue = request('mod_specification_id_building_venue');
        $specification->mod_specification_item_description = request('mod_specification_item_description');
        $specification->mod_specification_item_dimensions = request('mod_specification_item_dimensions');
        $specification->mod_specification_item_note = request('mod_specification_item_note');
        $specification->mod_specification_item_requirements = request('mod_specification_item_requirements');
        $specification->mod_specification_id_building_type = request('mod_specification_id_building_type');
        $specification->mod_specification_id_building_number = request('mod_specification_id_building_number');
        $specification->mod_specification_id_spec_type = request('mod_specification_id_spec_type');
        $specification->mod_specification_manufacturer = request('mod_specification_manufacturer');
        $specification->mod_specification_rep_name = request('mod_specification_rep_name');
        $specification->mod_specification_rep_company = request('mod_specification_rep_company');
        $specification->mod_specification_contact_name = request('mod_specification_contact_name');
        $specification->mod_specification_contact_email = request('mod_specification_contact_email');
        $specification->mod_specification_contact_address_1 = request('mod_specification_contact_address_1');
        $specification->mod_specification_type_finish_sample = (request('mod_specification_type_finish_sample') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_strike_off = (request('mod_specification_type_strike_off') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_cutting = (request('mod_specification_type_cutting') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_shop_drawing = (request('mod_specification_type_shop_drawing') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_prototype = (request('mod_specification_type_prototype') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_seaming_diagram = (request('mod_specification_type_seaming_diagram') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_cut_sheet = (request('mod_specification_type_cut_sheet') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_general_notes = (request('mod_specification_type_general_notes') == 'on') ? 'yes' : 'no';

        //images
        $specification->mod_specification_images_title = request('mod_specification_images_title');
        $specification->mod_specification_image_1_details = request('mod_specification_image_1_details');
        $specification->mod_specification_image_2_details = request('mod_specification_image_2_details');

        //save
        $specification->save();

        //save spec id
        $specification->mod_specification_spec_id = $specification->spec_id;
        $specification->save();

        //Image (1)
        if (request()->filled('image_directory_1') && request()->filled('image_filename_1')) {
            if ($filerepo->processUpload([
                'directory' => request('image_directory_1'),
                'filename' => request('image_filename_1'),
            ])) {
                $specification->mod_specification_image_1_directory = request('image_directory_1');
                $specification->mod_specification_image_1_filename = request('image_filename_1');
                $specification->mod_specification_has_image_1 = 'yes';
                $specification->save();
            }
        }

        //Image (2)
        if (request()->filled('image_directory_2') && request()->filled('image_filename_2')) {
            if ($filerepo->processUpload([
                'directory' => request('image_directory_2'),
                'filename' => request('image_filename_2'),
            ])) {
                $specification->mod_specification_image_2_directory = request('image_directory_2');
                $specification->mod_specification_image_2_filename = request('image_filename_2');
                $specification->mod_specification_has_image_2 = 'yes';
                $specification->save();
            }
        }

        //count rows
        $specifications = $specificationrepo->search();
        $count = count($specifications);

        //get friendly row
        $specifications = $specificationrepo->search($specification->mod_specification_id);

        //payload
        $payload = [
            'specifications' => $specifications,
            'specification' => $specifications->first(),
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

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //get the foo
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        //page
        $html = view('designspecification::specifications/modals/add-edit', compact('specification'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'ModuleSpecificationAddEdit',
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function editClientProject($id) {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //page
        $html = view('designspecification::specifications/modals/client-project')->render();
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
    public function update(StoreUpdate $request, SpecificationsRepository $specificationrepo, FileRepository $filerepo, $id) {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //get the foo
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        //update record
        $specification->mod_specification_date_issue = request('mod_specification_date_issue');
        $specification->mod_specification_date_revision = request('mod_specification_date_revision');
        $specification->mod_specification_id_building_venue = request('mod_specification_id_building_venue');
        $specification->mod_specification_item_name = request('mod_specification_item_name');
        $specification->mod_specification_item_description = request('mod_specification_item_description');
        $specification->mod_specification_item_dimensions = request('mod_specification_item_dimensions');
        $specification->mod_specification_item_note = request('mod_specification_item_note');
        $specification->mod_specification_item_requirements = request('mod_specification_item_requirements');
        $specification->mod_specification_id_building_type = request('mod_specification_id_building_type');
        $specification->mod_specification_id_building_number = request('mod_specification_id_building_number');
        $specification->mod_specification_id_spec_type = request('mod_specification_id_spec_type');
        $specification->mod_specification_manufacturer = request('mod_specification_manufacturer');
        $specification->mod_specification_rep_name = request('mod_specification_rep_name');
        $specification->mod_specification_rep_company = request('mod_specification_rep_company');
        $specification->mod_specification_contact_name = request('mod_specification_contact_name');
        $specification->mod_specification_contact_email = request('mod_specification_contact_email');
        $specification->mod_specification_contact_address_1 = request('mod_specification_contact_address_1');
        $specification->mod_specification_type_finish_sample = (request('mod_specification_type_finish_sample') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_strike_off = (request('mod_specification_type_strike_off') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_cutting = (request('mod_specification_type_cutting') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_shop_drawing = (request('mod_specification_type_shop_drawing') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_prototype = (request('mod_specification_type_prototype') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_seaming_diagram = (request('mod_specification_type_seaming_diagram') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_cut_sheet = (request('mod_specification_type_cut_sheet') == 'on') ? 'yes' : 'no';
        $specification->mod_specification_type_general_notes = (request('mod_specification_type_general_notes') == 'on') ? 'yes' : 'no';

        //images
        $specification->mod_specification_images_title = request('mod_specification_images_title');
        $specification->mod_specification_image_1_details = request('mod_specification_image_1_details');
        $specification->mod_specification_image_2_details = request('mod_specification_image_2_details');

        //save
        $specification->save();

        //save spec id
        $specification->mod_specification_spec_id = $specification->spec_id;
        $specification->save();

        //Image (1)
        if (request()->filled('image_directory_1') && request()->filled('image_filename_1')) {
            if ($filerepo->processUpload([
                'directory' => request('image_directory_1'),
                'filename' => request('image_filename_1'),
            ])) {
                $specification->mod_specification_image_1_directory = request('image_directory_1');
                $specification->mod_specification_image_1_filename = request('image_filename_1');
                $specification->mod_specification_has_image_1 = 'yes';
                $specification->save();
            }
        }

        //Image (2)
        if (request()->filled('image_directory_2') && request()->filled('image_filename_2')) {
            if ($filerepo->processUpload([
                'directory' => request('image_directory_2'),
                'filename' => request('image_filename_2'),
            ])) {
                $specification->mod_specification_image_2_directory = request('image_directory_2');
                $specification->mod_specification_image_2_filename = request('image_filename_2');
                $specification->mod_specification_has_image_2 = 'yes';
                $specification->save();
            }
        }

        //delete spec images
        if (request('delete_spec_images') == 'on') {
            $specification->mod_specification_images_title = '';
            $specification->mod_specification_image_1_details = '';
            $specification->mod_specification_image_2_details = '';
            $specification->mod_specification_image_1_directory = '';
            $specification->mod_specification_image_1_filename = '';
            $specification->mod_specification_image_2_directory = '';
            $specification->mod_specification_image_2_filename = '';
            $specification->mod_specification_has_image_1 = 'no';
            $specification->mod_specification_has_image_2 = 'no';
            $specification->save();
        }

        //get friendly row
        $specifications = $specificationrepo->search($specification->mod_specification_id);

        //payload
        $payload = [
            'specifications' => $specifications,
            'id' => $id,
        ];

        //return view
        return new UpdateResponse($payload);

    }

    /**
     * show the form to create a new resource
     *
     * @return \Illuminate\Http\Response
     */
    public function updateClientProject(SpecificationsRepository $specificationrepo, $id) {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //get the foo
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        //update record
        $specification->mod_specification_client = request('mod_specification_client');
        $specification->mod_specification_project = request('mod_specification_project');
        $specification->save();

        //get friendly row
        $specifications = $specificationrepo->search($specification->mod_specification_id);

        //payload
        $payload = [
            'specifications' => $specifications,
            'id' => $id,
        ];

        //return view
        return new UpdateResponse($payload);

    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function emailSpecification($id) {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //defaults
        $name = '';
        $email = '';

        //get the specification
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        //get client
        if (is_numeric($specification->mod_specification_client)) {
            if ($user = \App\Models\User::Where('clientid', $specification->mod_specification_client)->first()) {
                $name = $user->first_name . ' ' . $user->firlast_namest_name;
                $email = $user->email;
            }
        }

        $payload = [
            'name' => $name,
            'email' => $email,
        ];

        //page
        $html = view('designspecification::specifications/modals/email-specification', compact('payload'))->render();
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
    public function emailSpecificationAction($id) {

        //custom error messages
        $messages = [
            'user_name.required' => __('lang.name') . ' - ' . __('lang.is_required'),
            'user_email.required' => __('lang.email') . ' - ' . __('lang.is_required'),
            'user_email.email' => __('lang.email') . ' - ' . __('lang.invalid_email_address'),
        ];

        //validate
        $validator = Validator::make(request()->all(), [
            'user_name' => [
                'required',
            ],
            'user_email' => [
                'required',
                'email',
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

        //get the specification
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        /** ----------------------------------------------
         * send email to user
         * ----------------------------------------------*/
        $data = [
            'user_name' => request('user_name'),
            'user_email' => request('user_email'),
        ];
        $mail = new \Modules\DesignSpecification\Emails\EmailSpecification($data, $specification);
        $mail->build();

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
     * download specification of view PDF
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        //get the foo
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        //get the settings
        if (!$settings = \Modules\DesignSpecification\Models\SpecificationSetting::Where('mod_specifications_settings_id', 'default')->first()) {
            abort(404);
        }

        //reponse payload
        $payload = [
            'page' => $this->pageSettings(),
            'specification' => $specification,
            'settings' => $settings,
        ];

        //show the form
        return new PDFResponse($payload);

    }

    /**
     * show the form to edit a resource
     *
     * @return \Illuminate\Http\Response
     */
    public function generalNotes() {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //get the foo
        if (!$settings = \Modules\DesignSpecification\Models\SpecificationSetting::Where('mod_specifications_settings_id', 'default')->first()) {
            abort(404);
        }

        //page
        $html = view('designspecification::settings/notes', compact('settings'))->render();
        $jsondata['dom_html'][] = [
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html,
        ];

        //postrun
        $jsondata['postrun_functions'][] = [
            'value' => 'ModuleSpecificationSettingsNotes',
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * update general notes
     *
     * @return \Illuminate\Http\Response
     */
    public function updateGeneralNotes() {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //update
        \Modules\DesignSpecification\Models\SpecificationSetting::Where('mod_specifications_settings_id', 'default')
            ->update(['mod_specifications_settings_notes' => request('mod_specifications_settings_notes')]);

        //close modal
        $jsondata['dom_visibility'][] = [
            'selector' => '#commonModal', 'action' => 'close-modal',
        ];

        //notice error
        $jsondata['notification'] = [
            'type' => 'success',
            'value' => __('lang.request_has_been_completed'),
        ];

        //render
        return response()->json($jsondata);

    }

    /**
     * delete a record
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        //team only
        if (!auth()->user()->is_team) {
            abort(403);
        }

        //get the foo
        if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $id)->first()) {
            abort(404);
        }

        //delete record
        $specification->delete();

        //remove table row
        $jsondata['dom_visibility'][] = array(
            'selector' => '#specifications_' . $id,
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
                __('designspecification::lang.specifications'),
            ],
            'meta_title' => __('designspecification::lang.specifications'),
            'heading' => __('designspecification::lang.specifications'),
            'crumbs_special_class' => 'list-pages-crumbs',
            'page' => 'items',
            'no_results_message' => __('lang.no_results_found'),
            'module_li_designspecification' => 'active',
            'dynamic_search_url' => url('modules/designspecification/search?action=search&resource_id=' . request('resource_id') . '&resource_type=' . request('resource_type')),
            'add_button_classes' => 'add-edit-item-button',
            'source' => 'list',
        ];

        //return
        return $page;
    }

}
