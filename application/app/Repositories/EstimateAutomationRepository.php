<?php

/** --------------------------------------------------------------------------------
 * Process estimate automation
 *
 * @fooo    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;
use App\Repositories\EmailerRepository;
use App\Repositories\EstimateRepository;
use App\Repositories\EventRepository;
use App\Repositories\EventTrackingRepository;
use App\Repositories\InvoiceGeneratorRepository;
use App\Repositories\MilestoneCategoryRepository;
use App\Repositories\MilestoneRepository;
use App\Repositories\ProjectManagerRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\FileFolderRepository;
use Illuminate\Support\Facades\Log;

class EstimateAutomationRepository {

    private $settings;
    private $assignedrepo;
    private $eventrepo;
    private $trackingrepo;
    private $emailerrepo;
    private $userrepo;
    private $taskrepo;
    private $estimaterepo;
    private $invoicegenerator;
    private $milestonerepo;
    private $milestonecategories;
    private $filefolderrepo;

    public function __construct(
        ProjectManagerRepository $assignedrepo,
        EventRepository $eventrepo,
        EmailerRepository $emailerrepo,
        TaskRepository $taskrepo,
        UserRepository $userrepo,
        EstimateRepository $estimaterepo,
        InvoiceGeneratorRepository $invoicegenerator,
        MilestoneRepository $milestonerepo,
        MilestoneCategoryRepository $milestonecategories,
        FileFolderRepository $filefolderrepo,
        EventTrackingRepository $trackingrepo) {

        //system settings
        $this->settings = \App\Models\Settings::Where('settings_id', 1)->first();

        $this->assignedrepo = $assignedrepo;
        $this->eventrepo = $eventrepo;
        $this->trackingrepo = $trackingrepo;
        $this->emailerrepo = $emailerrepo;
        $this->userrepo = $userrepo;
        $this->taskrepo = $taskrepo;
        $this->estimaterepo = $estimaterepo;
        $this->invoicegenerator = $invoicegenerator;
        $this->milestonerepo = $milestonerepo;
        $this->milestonecategories = $milestonecategories;
        $this->filefolderrepo = $filefolderrepo;

    }

    /**
     * process the automation
     *
     * @param  int  $id estimate id
     * @return \Illuminate\Http\Response
     */
    public function process($estimate) {

        Log::info("estimate automation started", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid]);

        //default (incase we are not creating a project)
        $project = [];

        //check if the estimate has automation enabled
        if ($estimate->estimate_automation_status != 'enabled') {
            Log::info("estimate automation is disabled - will now exit", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid]);
            return;
        }

        //(1) create project
        if ($estimate->estimate_automation_create_project == 'yes') {

            //new project
            if ($project = $this->createProject($estimate)) {

                //assign project
                $assigned = $this->assignProject($project, $estimate);

                //record timeline & email clent
                $this->projectTimeline($project, $estimate);

                //create tasks
                $this->createTasks($project, $estimate);
            }

        }

        //(2) create invoice
        if ($estimate->estimate_automation_create_invoice == 'yes') {

            //new invoice
            if ($invoice = $this->createInvoice($estimate, $project)) {

                //eamail the invoice to the client
                $this->emailInvoice($invoice);
            }

        }

        Log::info("estimate automation completed", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid]);

    }

    /**
     * create a new project
     * @param obj $estimate estimate
     * @return obj project
     */
    public function createProject($estimate) {

        //info
        Log::info("starting to create a project for this estimate", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid]);

        //check if automation has not already run for this estimate
        if (is_numeric($estimate->estimate_automation_log_created_project_id)) {
            if (\App\Models\Project::Where('project_id', $estimate->estimate_automation_log_created_project_id)->exists()) {
                Log::info("a project has previously been created for this automation. will now exit", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid, 'project_id' => $estimate->estimate_automation_log_created_project_id]);
                return false;
            }
        }

        $project = new \App\Models\Project();
        $project->project_clientid = $estimate->bill_clientid;
        $project->project_status = $estimate->estimate_automation_project_status;
        $project->project_title = $estimate->estimate_automation_project_title;
        $project->project_creatorid = 0;
        $project->project_date_start = now();
        $project->project_billing_rate = $this->settings->settings_projects_default_hourly_rate;
        $project->clientperm_tasks_view = $this->settings->settings_projects_clientperm_tasks_view;
        $project->clientperm_tasks_collaborate = $this->settings->settings_projects_clientperm_tasks_collaborate;
        $project->clientperm_tasks_create = $this->settings->settings_projects_clientperm_tasks_create;
        $project->clientperm_timesheets_view = $this->settings->settings_projects_clientperm_timesheets_view;
        $project->clientperm_expenses_view = $this->settings->settings_projects_clientperm_expenses_view;
        $project->assignedperm_milestone_manage = $this->settings->settings_projects_assignedperm_milestone_manage;
        $project->assignedperm_tasks_collaborate = $this->settings->settings_projects_assignedperm_tasks_collaborate;
        $project->save();

        //create default milestones
        $position = $this->milestonecategories->addProjectMilestones($project);
        $this->milestonerepo->addUncategorised($project->project_id, $position);

        //add default folders
        $this->filefolderrepo->addDefault($project->project_id);

        //attach estimate to this project
        \App\Models\Estimate::where('bill_estimateid', $estimate->bill_estimateid)
            ->update([
                'bill_projectid' => $project->project_id,
                'estimate_automation_log_created_project_id' => $project->project_id,
            ]);

        //info
        Log::info("project has been created", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $project->project_id]);

        //return project
        return $project;
    }

    /**
     * assign the project
     * @param obj $project project
     * @param obj $estimate estimate
     * @return null
     */
    public function assignProject($project, $estimate) {

        //info
        Log::info("assigning the prroject", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $project->project_id]);

        //default
        $users = [];

        //get assigned users
        $assigned_users = \App\Models\AutomationAssigned::Where('automationassigned_resource_type', 'estimate')
            ->Where('automationassigned_resource_id', $estimate->bill_estimateid)
            ->get();

        //assign
        foreach ($assigned_users as $assigned_user) {
            $assigned = new \App\Models\ProjectAssigned();
            $assigned->projectsassigned_projectid = $project->project_id;
            $assigned->projectsassigned_userid = $assigned_user->automationassigned_userid;
            $assigned->save();
            $users[] = $assigned_user->automationassigned_userid;
        }

        //email
        foreach ($assigned_users as $assigned_user) {
            if ($user = \App\Models\User::Where('id', $assigned_user->automationassigned_userid)->first()) {
                if ($user->notifications_new_assignement == 'yes_email') {
                    $mail = new \App\Mail\ProjectAssignment($user, [], $project);
                    $mail->build();
                }
            }
        }

        //return
        return $users;

    }

    /**
     * create timeline events
     * @param obj $project project
     * @param obj $estimate estimate
     * @return null
     */
    public function projectTimeline($project, $estimate) {

        //info
        Log::info("recoring project creation event timeline", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $project->project_id]);

        /** ----------------------------------------------
         * record event [project created]
         * ----------------------------------------------*/
        $data = [
            'event_creatorid' => 0,
            'event_item' => 'new_project',
            'event_item_id' => '',
            'event_item_lang' => 'event_created_project',
            'event_item_content' => $project->project_title,
            'event_item_content2' => '',
            'event_parent_type' => 'project',
            'event_parent_id' => $project->project_id,
            'event_parent_title' => $project->project_title,
            'event_show_item' => 'yes',
            'event_show_in_timeline' => 'yes',
            'event_clientid' => $project->project_clientid,
            'eventresource_type' => 'project',
            'eventresource_id' => $project->project_id,
            'event_notification_category' => 'notifications_projects_activity',
        ];
        //record event
        if ($event_id = $this->eventrepo->create($data)) {
            //get users
            $users = $this->userrepo->getClientUsers($project->project_clientid, 'all', 'ids');
            //record notification
            $emailusers = $this->trackingrepo->recordEvent($data, $users, $event_id);
        }

        /** ----------------------------------------------
         * send email [project created]
         * ----------------------------------------------*/
        if ($estimate->estimate_automation_project_email_client == 'yes') {
            if ($owner = $this->userrepo->getClientAccountOwner($project->project_clientid)) {
                if ($owner->notifications_new_project == 'yes_email') {
                    $mail = new \App\Mail\ProjectCreated($owner, [], $project);
                    $mail->build();
                }
            }
        }

    }

    /**
     * create project tasks
     * @param obj $project project
     * @param obj $estimate estimate
     * @return null
     */
    public function createTasks($project, $estimate) {

        //validate
        if ($estimate->estimate_automation_create_tasks != 'yes') {
            return;
        }

        //info
        Log::info("creating tasks for the project", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $project->project_id]);

        //get the default milestone category
        $milestone = \App\Models\Milestone::Where('milestone_projectid', $project->project_id)->Where('milestone_type', 'uncategorised')->first();

        //get estimate line items
        if ($items = \App\Models\Lineitem::Where('lineitemresource_type', 'estimate')->where('lineitemresource_id', $estimate->bill_estimateid)->get()) {

            //create a task
            $count = 1;
            foreach ($items as $item) {
                $task = new \App\Models\Task();
                $task->task_creatorid = 0;
                $task->task_projectid = $project->project_id;
                $task->task_clientid = $estimate->bill_clientid;
                $task->task_title = $item->lineitem_description;
                $task->task_client_visibility = 'yes';
                $task->task_status = 1; //default (new)
                $task->task_milestoneid = $milestone->milestone_id;
                $task->task_position = $count;
                $task->save();
                $count++;

                //assign the task
                $this->assignTask($task, $estimate, $project);

                //info
                Log::info("new task create", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $project->project_id, 'task_title' => $task->task_title]);

            }

        }
    }

    /**
     * assign a task
     * @param obj $project project
     * @param obj $estimate estimate
     * @return null
     */
    public function assignTask($task, $estimate, $project) {

        //info
        Log::info("assiging tasks", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project_id' => $project->project_id]);

        //get assigned project users
        $assigned_users = \App\Models\AutomationAssigned::Where('automationassigned_resource_type', 'estimate')
            ->Where('automationassigned_resource_id', $estimate->bill_estimateid)
            ->get();

        //assign each project user
        $users = [];
        foreach ($assigned_users as $assigned_user) {
            $assigned = new \App\Models\TaskAssigned();
            $assigned->tasksassigned_taskid = $task->task_id;
            $assigned->tasksassigned_userid = $assigned_user->automationassigned_userid;
            $assigned->save();
            $users[] = $assigned_user->automationassigned_userid;
        }

        //get the task with more data needed in email
        $tasks = $this->taskrepo->search($task->task_id, ['apply_filters' => false]);
        $task = $tasks->first();

        /** ----------------------------------------------
         * record assignment events and send emails
         * ----------------------------------------------*/
        foreach ($users as $user_id) {
            if ($user = \App\Models\User::Where('id', $user_id)->first()) {
                $data = [
                    'event_creatorid' => 0,
                    'event_item' => 'assigned',
                    'event_item_id' => '',
                    'event_item_lang' => 'event_assigned_user_to_a_task',
                    'event_item_lang_alt' => 'event_assigned_user_to_a_task_alt',
                    'event_item_content' => __('lang.assigned'),
                    'event_item_content2' => $user_id,
                    'event_item_content3' => $user->first_name,
                    'event_parent_type' => 'task',
                    'event_parent_id' => $task->task_id,
                    'event_parent_title' => $task->task_title,
                    'event_show_item' => 'yes',
                    'event_show_in_timeline' => 'yes',
                    'event_clientid' => $task->task_clientid,
                    'eventresource_type' => 'project',
                    'eventresource_id' => $task->task_projectid,
                    'event_notification_category' => 'notifications_new_assignement',
                ];
                //record event
                if ($event_id = $this->eventrepo->create($data)) {
                    $emailusers = $this->trackingrepo->recordEvent($data, [$user_id], $event_id);
                }

                //email user
                if ($user->notifications_new_assignement == 'yes_email') {
                    $mail = new \App\Mail\TaskAssignment($user, $data, $task);
                    $mail->build();
                }
            }
        }

    }

    /**
     * create a new invoice
     * @param obj $estimate estimate
     * @return obj project
     */
    public function createInvoice($estimate, $project) {

        //info
        Log::info("starting to create an invoice", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid]);

        //make sure this estimate has not been previously converted to an invoice
        if (is_numeric($estimate->estimate_automation_log_created_invoice_id)) {
            if (\App\Models\Invoice::Where('bill_invoiceid', $estimate->estimate_automation_log_created_invoice_id)->exists()) {
                //info
                Log::info("an invoice has previously been created for this automation. will now exit", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'estimate_id' => $estimate->bill_estimateid, 'invoice_id' => $estimate->estimate_automation_log_created_invoice_id]);
                return false;
            }
        }

        //convert the estimate to an invoice
        $invoice = $this->estimaterepo->convertEstimateToInvoice($estimate->bill_estimateid);
        $invoice->bill_date = now();
        $invoice->bill_due_date = \Carbon\Carbon::now()->addDays($estimate->estimate_automation_invoice_due_date)->format('Y-m-d');
        $invoice->bill_creatorid = 0;
        $invoice->save();

        //did we also create a project as part of this process
        if ($project instanceof \App\Models\Project) {
            $invoice->bill_projectid = $project->project_id;
            $invoice->save();
        } else {
            //attach the invoice to the project listed in the automation log (if one exists) or null
            $invoice->bill_projectid = $estimate->estimate_automation_log_created_project_id;
            $invoice->save();
        }

        //mark estimate as converted to invoice
        \App\Models\Estimate::where('bill_estimateid', $estimate->bill_estimateid)
            ->update([
                'estimate_automation_log_created_invoice_id' => $invoice->bill_invoiceid,
            ]);

        //return
        return $invoice;

    }

    /**
     * email invoice to the client
     * @param int $id invoice id
     * @return \Illuminate\Http\Response
     */
    public function emailInvoice($invoice) {

        //info
        Log::info("emailing invoice to client", ['process' => '[estimate-automation]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'invoice_id' => $invoice->bill_invoiceid]);

        //generate the invoice
        if (!$payload = $this->invoicegenerator->generate($invoice->bill_invoiceid)) {
            return;
        }

        //invoice
        $invoice = $payload['bill'];

        /** ----------------------------------------------
         * send email [queued]
         * ----------------------------------------------*/
        $users = $this->userrepo->getClientUsers($invoice->bill_clientid, 'owner', 'collection');
        //other data
        $data = [];
        foreach ($users as $user) {
            $mail = new \App\Mail\PublishInvoice($user, $data, $invoice);
            $mail->build();
        }
    }
}