<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for templates
 *
 * @specification    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Modules\DesignSpecification\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\DesignSpecification\Models\Specification;

class SpecificationsRepository {

    /**
     * The leads repository instance.
     */
    protected $specification;

    /**
     * Inject dependecies
     */
    public function __construct(Specification $specification) {
        $this->specification = $specification;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @return object specifications collection
     */
    public function search($id = '', $data = []) {

        $specifications = $this->specification->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //joins
        $specifications->leftJoin('users', 'users.id', '=', 'mod_specifications.mod_specification_creatorid');
        $specifications->leftJoin('clients', 'clients.client_id', '=', 'mod_specifications.mod_specification_client');
        $specifications->leftJoin('projects', 'projects.project_id', '=', 'mod_specifications.mod_specification_project');

        // all client fields
        $specifications->selectRaw('*');

        //count all specifications
        $specifications->selectRaw("(SELECT COUNT(*)
                                      FROM mod_specifications)
                                      AS count_all_specifications");

        //default where
        $specifications->whereRaw("1 = 1");

        //filters: id
        if (request()->filled('filter_specification_id')) {
            $specifications->where('mod_specification_id', request('filter_specification_id'));
        }
        if (is_numeric($id)) {
            $specifications->where('mod_specification_id', $id);
        }

        //client limits
        if (auth()->check()) {
            if (auth()->user()->is_client) {
                $specifications->where('mod_specification_client', auth()->user()->clientid);
            }
        }

        //filter company
        if (request()->filled('filter_mod_specification_client')) {
            $specifications->where('mod_specification_client', request('filter_mod_specification_client'));
        }

        //filter project
        if (request()->filled('filter_mod_specification_project')) {
            $specifications->where('mod_specification_project', request('filter_mod_specification_project'));
        }

        //filter: mod_specification_date_issue (start)
        if (request()->filled('filter_mod_specification_date_issue_start')) {
            $specifications->where('mod_specification_date_issue', '>=', request('filter_mod_specification_date_issue_start'));
        }

        //filter: mod_specification_date_issue (end)
        if (request()->filled('filter_mod_specification_date_issue_end')) {
            $specifications->where('mod_specification_date_issue', '<=', request('filter_mod_specification_date_issue_end'));
        }

        //filter: mod_specification_date_revision (start)
        if (request()->filled('filter_mod_specification_date_revision_start')) {
            $specifications->where('mod_specification_date_revision', '>=', request('filter_mod_specification_date_revision_start'));
        }

        //filter: mod_specification_date_revision (end)
        if (request()->filled('filter_mod_specification_date_revision_end')) {
            $specifications->where('mod_specification_date_revision', '<=', request('filter_mod_specification_date_revision_end'));
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $specifications->where(function ($query) {
                $query->Where('mod_specification_item_name', '=', request('search_query'));
                $query->orWhere('mod_specification_id_building_type', '=', request('search_query'));
                $query->orWhere('mod_specification_id_building_number', '=', request('search_query'));
                $query->orWhere('mod_specification_manufacturer', '=', request('search_query'));
                $query->orWhere('mod_specification_rep_name', '=', request('search_query'));
                $query->orWhere('mod_specification_contact_name', '=', request('search_query'));
                $query->orWhere('mod_specification_contact_email', '=', request('search_query'));
                $query->orWhere('mod_specification_spec_id', '=', request('search_query'));
                $query->orWhere('mod_specification_date_issue', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('mod_specification_date_revision', 'LIKE', '%' . date('Y-m-d', strtotime(request('search_query'))) . '%');
                $query->orWhere('project_title', 'LIKE', '%' . request('search_query') . '%');
                $query->orWhere('client_company_name', 'LIKE', '%' . request('search_query') . '%');
            });

        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('mod_specifications', request('orderby'))) {
                $specifications->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'client_name':
                $specifications->orderBy('client_company_name', request('sortorder'));
                break;
            case 'project_title':
                $specifications->orderBy('project_title', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $specifications->orderBy('mod_specification_id', 'asc');
        }

        // Get the results and return them.
        return $specifications->paginate(config('system.settings_system_pagination_limits'));
    }
}