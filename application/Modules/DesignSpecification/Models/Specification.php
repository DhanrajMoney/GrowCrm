<?php

namespace Modules\DesignSpecification\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model {

    /**
     * @primaryKey string - primry key column.
     * @dateFormat string - date storage format
     * @guarded string - allow mass assignment except specified
     * @CREATED_AT string - creation date column
     * @UPDATED_AT string - updated date column
     */

    protected $table = 'mod_specifications';
    protected $primaryKey = 'mod_specification_id';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded = ['mod_specification_id'];
    const CREATED_AT = 'mod_specification_created';
    const UPDATED_AT = 'mod_specification_updated';

    /**
     * display format for the spec
     * [EXAMPLE] RD-22-S1-1
     * e.g. INV-000001
     */
    public function getSpecIdAttribute() {

        $spec_id = $this->mod_specification_id_building_type . '-' . $this->mod_specification_id_building_number . '-' . $this->mod_specification_id_spec_type . '-' . $this->mod_specification_id;

        //uppercase
        $spec_id = strtoupper($spec_id);
        
        return $spec_id;
    }


        /**
     * display format for the spec
     * [EXAMPLE] RD-22-S1-1
     * e.g. INV-000001
     */
    public function getSpecVenueIdAttribute() {

        $venue_id = $this->mod_specification_id_building_type . '-' . $this->mod_specification_id_building_number;

        //uppercase
        $venue_id = strtoupper($venue_id);
        
        return $venue_id;
    }

}