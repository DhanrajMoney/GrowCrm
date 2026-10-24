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
use App\Repositories\CS_Affiliates\AffiliateRepository;

class Profit extends Controller {

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

        //affilate user only
        if (auth()->user()->type != 'cs_affiliate') {
            abort(403);
        }

        request()->merge([
            'cs_affiliate_earning_affiliateid' => auth()->id(),
        ]);

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
            'mainmenu_cs_affiliate_earnings' => 'active',
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