<?php

/** --------------------------------------------------------------------------------
 * [template]
 * This classes renders the [new email] email and stores it in the queue
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Modules\DesignSpecification\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class EmailSpecification extends Mailable {
    use Queueable;

    /**
     * The data for merging into the email
     */
    public $data;

    /**
     * Model instance
     */
    public $obj;

    public $emailerrepo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data = [], $obj = []) {

        $this->data = $data;
        $this->obj = $obj;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {

        //email template
        if (!$template = \App\Models\EmailTemplate::Where('emailtemplate_name', 'New Design Specification')
            ->Where('emailtemplate_module_unique_id', '61fff4cf002d28.36611450')->first()) {
            return false;
        }

        //validate
        if (!$this->obj instanceof \Modules\DesignSpecification\Models\Specification) {
            return false;
        }

        //only active templates
        if ($template->emailtemplate_status != 'enabled') {
            return false;
        }

        //get common email variables
        $payload = config('mail.data');

        //set template variables
        $payload += [
            'to_name' => $this->data['user_name'],
            'specification_date_issued' => runtimeDate($this->obj->specification_date_issued),
            'specification_date_revised' => runtimeDate($this->obj->specification_date_revised),
            'specification_name' => $this->obj->mod_specification_item_name,
            'specification_id' => $this->obj->spec_id,
        ];

        //save in the database queue
        $queue = new \App\Models\EmailQueue();
        $queue->emailqueue_to = $this->data['user_email'];
        $queue->emailqueue_subject = $template->parse('subject', $payload);
        $queue->emailqueue_message = $template->parse('body', $payload);
        $queue->emailqueue_type = 'module_design_specification_pdf';
        $queue->emailqueue_resourceid = $this->obj->mod_specification_id;
        $queue->save();
    }
}