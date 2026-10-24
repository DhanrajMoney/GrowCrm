<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for templates
 *
 * @foo    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories\CS_Affiliates;

use App\Models\Custom\CSAffiliateEarning;
use App\Models\Custom\CSAffiliateProject;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AffiliateRepository {

    protected $user;
    protected $project;
    protected $earning;

    /**
     * Inject dependecies
     */
    public function __construct(User $user, CSAffiliateProject $project, CSAffiliateEarning $earning) {
        $this->user = $user;
        $this->project = $project;
        $this->earning = $earning;

    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object foos collection
     */
    public function searchUsers($id = '', $data = []) {

        $users = $this->user->newQuery();

        // all fields
        $users->selectRaw('*');

        //count payments
        $users->selectRaw("(SELECT COALESCE(SUM(cs_affiliate_earning_amount), 0.00)
                FROM cs_affiliate_earnings
                WHERE cs_affiliate_earning_status='unpaid'
                AND cs_affiliate_earning_affiliateid = users.id)
                AS sum_pending_earnings");

        //count payments
        $users->selectRaw("(SELECT COALESCE(SUM(cs_affiliate_earning_amount), 0.00)
                FROM cs_affiliate_earnings
                WHERE cs_affiliate_earning_status='paid'
                AND cs_affiliate_earning_affiliateid = users.id)
                AS sum_completed_earnings");

        $users->where('type', 'cs_affiliate');

        //filter id
        if (is_numeric($id)) {
            $users->where('id', $id);
        }

        //search:
        if (request()->filled('search_query')) {
            $users->where(function ($query) {
                $query->where('first_name', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('last_name', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('email', 'LIKE', '%' . request('search_query') . '%');
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('users', request('orderby'))) {
                $users->orderBy(request('orderby'), request('sortorder'));
            }

            //others
            switch (request('orderby')) {
            case 'project':
                $users->orderBy('project_id', request('sortorder'));
                break;
            case 'bill_final_amount':
                $users->orderBy('bill_final_amount', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $users->orderBy('first_name', 'asc');
        }

        // Get the results and return them.
        return $users->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object foos collection
     */
    public function searchProjects($id = '', $data = []) {

        $projects = $this->project->newQuery();

        $projects->leftJoin('projects', 'projects.project_id', '=', 'cs_affiliate_projects.cs_affiliate_project_projectid');
        $projects->leftJoin('users', 'users.id', '=', 'cs_affiliate_projects.cs_affiliate_project_affiliateid');

        // all fields
        $projects->selectRaw('*');

        //count payments
        $projects->selectRaw("(SELECT COALESCE(SUM(cs_affiliate_earning_amount), 0.00)
                                      FROM cs_affiliate_earnings
                                      WHERE cs_affiliate_earning_projectid = cs_affiliate_projects.cs_affiliate_project_id)
                                      AS sum_earnings");

        //filter id
        if (is_numeric($id)) {
            $projects->where('cs_affiliate_project_id', $id);
        }

        //search:
        if (request()->filled('search_query')) {
            $projects->where(function ($query) {
                $query->where('project_title', 'LIKE', '%' . request('search_query') . '%');
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('cs_affiliate_projects', request('orderby'))) {
                $projects->orderBy(request('orderby'), request('sortorder'));
            }

            //others
            switch (request('orderby')) {
            case 'first_name':
                $projects->orderBy('first_name', request('sortorder'));
                break;
            case 'project_title':
                $projects->orderBy('project_title', request('sortorder'));
                break;
            case 'earned':
                $projects->orderBy('sum_earnings', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $projects->orderBy('cs_affiliate_project_id', 'asc');
        }

        // Get the results and return them.
        return $projects->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object foos collection
     */
    public function searchEarnings($id = '', $data = []) {

        $earnings = $this->earning->newQuery();

        $earnings->leftJoin('invoices', 'invoices.bill_invoiceid', '=', 'cs_affiliate_earnings.cs_affiliate_earning_invoiceid');
        $earnings->leftJoin('projects', 'projects.project_id', '=', 'invoices.bill_projectid');
        $earnings->leftJoin('users', 'users.id', '=', 'cs_affiliate_earnings.cs_affiliate_earning_affiliateid');

        // all fields
        $earnings->selectRaw('*');

        //filter id
        if (is_numeric($id)) {
            $earnings->where('cs_affiliate_earning_id', $id);
        }

        //filter affiliate
        if (request()->filled('cs_affiliate_earning_affiliateid')) {
            $earnings->where('cs_affiliate_earning_affiliateid', request('cs_affiliate_earning_affiliateid'));
        }

        //search:
        if (request()->filled('search_query')) {
            $earnings->where(function ($query) {
                $query->where('project_title', 'LIKE', '%' . request('search_query') . '%');

                //clean for invoice id search
                $bill_invoiceid = str_replace(config('system.settings_invoices_prefix'), '', request('search_query'));
                $bill_invoiceid = preg_replace("/[^0-9.,]/", '', $bill_invoiceid);
                $bill_invoiceid = ltrim($bill_invoiceid, '0');
                $query->Where('bill_invoiceid', '=', $bill_invoiceid);

                $query->orWhere('cs_affiliate_earning_invoice_payment_date', '=', date('Y-m-d', strtotime(request('search_query'))));

            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('cs_affiliate_earnings', request('orderby'))) {
                $earnings->orderBy(request('orderby'), request('sortorder'));
            }

            //others
            switch (request('orderby')) {
            case 'project':
                $earnings->orderBy('project_id', request('sortorder'));
                break;
            case 'bill_final_amount':
                $earnings->orderBy('bill_final_amount', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $earnings->orderBy('cs_affiliate_earning_id', 'asc');
        }

        // Get the results and return them.
        return $earnings->paginate(config('system.settings_system_pagination_limits'));
    }
}
