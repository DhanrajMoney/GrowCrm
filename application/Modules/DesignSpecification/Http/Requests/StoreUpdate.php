<?php

/** --------------------------------------------------------------------------------
 * This middleware class validates input requests for the template controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Modules\DesignSpecification\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdate extends FormRequest {

    /**
     * we are checking authorised users via the middleware
     * so just retun true here
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * custom error messages for specific valdation checks
     * @optional
     * @return array
     */
    public function messages() {
        return [
            //'mod_specification_client.required' => __('lang.client') . ' - ' . __('lang.is_required'),
            'mod_specification_id_building_type.required' => __('designspecification::lang.building_type') . ' - ' . __('lang.is_required'),
            'mod_specification_id_building_number.required' => __('designspecification::lang.building_number') . ' - ' . __('lang.is_required'),
            'mod_specification_id_spec_type.required' => __('designspecification::lang.specification_type') . ' - ' . __('lang.is_required'),
            'mod_specification_item_name.required' => __('designspecification::lang.item_name') . ' - ' . __('lang.is_required'),
            'mod_specification_date_issue.required' => __('designspecification::lang.issue_date') . ' - ' . __('lang.is_required'),
            'mod_specification_manufacturer.required' => __('designspecification::lang.manufacturer_name') . ' - ' . __('lang.is_required'),
            'mod_specification_rep_name.required' => __('designspecification::lang.rep_name') . ' - ' . __('lang.is_required'),
            'mod_specification_contact_name.required' => __('designspecification::lang.contact_name') . ' - ' . __('lang.is_required'),
            'mod_specification_contact_email.required' => __('designspecification::lang.contact_email') . ' - ' . __('lang.is_required'),
            'mod_specification_contact_address_1.required' => __('designspecification::lang.contact_address') . ' - ' . __('lang.is_required'),
            'mod_specification_item_description.required' => __('designspecification::lang.description') . ' - ' . __('lang.is_required'),
            'mod_specification_item_dimensions.required' => __('designspecification::lang.dimenensions') . ' - ' . __('lang.is_required'),
            'mod_specification_id_building_venue.required' => __('designspecification::lang.venue_name') . ' - ' . __('lang.is_required'),
            'mod_specification_item_requirements.required' => __('designspecification::lang.requirements') . ' - ' . __('lang.is_required'),
        ];
    }

    /**
     * Validate the request
     * @return array
     */
    public function rules() {

        //initialize
        $rules = [];

        /**-------------------------------------------------------
         * common rules for both [create] and [update] requests
         * ------------------------------------------------------*/
        $rules += [
            'mod_specification_id_building_type' => [
                'required',
            ],
            'mod_specification_id_building_number' => [
                'required',
            ],
            'mod_specification_id_spec_type' => [
                'required',
            ],
            'mod_specification_item_name' => [
                'required',
            ],
            'mod_specification_date_issue' => [
                'required',
            ],
            'mod_specification_manufacturer' => [
                'required',
            ],
            'mod_specification_rep_name' => [
                'required',
            ],
            'mod_specification_contact_name' => [
                'required',
            ],
            'mod_specification_contact_email' => [
                'required',
            ],
            'mod_specification_contact_address_1' => [
                'required',
            ],
            'mod_specification_id_building_venue' => [
                'required',
            ],
        ];

        //validate
        return $rules;
    }

    /**
     * Deal with the errors - send messages to the frontend
     */
    public function failedValidation(Validator $validator) {

        $errors = $validator->errors();
        $messages = '';
        foreach ($errors->all() as $message) {
            $messages .= "<li>$message</li>";
        }

        abort(409, $messages);
    }
}