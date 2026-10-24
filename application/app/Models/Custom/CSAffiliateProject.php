<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Model;

class CSAffiliateProject extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $table = 'cs_affiliate_projects';
    protected $primaryKey = 'cs_affiliate_project_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['cs_affiliate_project_id'];
    const CREATED_AT = 'cs_affiliate_project_created';
    const UPDATED_AT = 'cs_affiliate_project_updated';

}