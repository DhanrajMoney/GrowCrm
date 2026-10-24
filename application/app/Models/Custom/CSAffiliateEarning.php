<?php

namespace App\Models\Custom;

use Illuminate\Database\Eloquent\Model;

class CSAffiliateEarning extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $table = 'cs_affiliate_earnings';
    protected $primaryKey = 'cs_affiliate_earning_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['cs_affiliate_earning_id'];
    const CREATED_AT = 'cs_affiliate_earning_created';
    const UPDATED_AT = 'cs_affiliate_earning_updated';

}