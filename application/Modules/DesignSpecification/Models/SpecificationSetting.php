<?php

namespace Modules\DesignSpecification\Models;

use Illuminate\Database\Eloquent\Model;

class SpecificationSetting extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $table = 'mod_specifications_settings';
    protected $primaryKey = 'mod_specification_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['mod_specifications_settings_id'];
    const CREATED_AT = 'mod_specifications_settings_created';
    const UPDATED_AT = 'mod_specifications_settings_updated';
    
}