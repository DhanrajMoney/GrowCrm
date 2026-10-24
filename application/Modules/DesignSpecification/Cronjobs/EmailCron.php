<?php

/** -------------------------------------------------------------------------------------------------
 * [MODULES] [CRONJOB]
 * Email the specification as a PDF file to the client main user
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace Modules\DesignSpecification\Cronjobs;

use App\Mail\SendQueued;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class EmailCron {

    public function __invoke() {

        Log::debug("spec schdule has run");

        /**
         * Generate PDF invoices and email them out
         *   - These emails are being sent every minute. You can set a higher or lower sending limit.
         *   - Note: processing PDF files takes some time and if you set too high a limit, the process
         *    could timeout
         */
        //Get the emails marked as [pdf] and [invoice]
        $limit = 5;
        if ($emails = \App\Models\EmailQueue::Where('emailqueue_type', 'module_design_specification_pdf')->where('emailqueue_status', 'new')->take($limit)->get()) {

            //mark all emails in the batch as processing - to avoid batch duplicates/collisions
            foreach ($emails as $email) {
                $email->update([
                    'emailqueue_status' => 'processing',
                    'emailqueue_started_at' => now(),
                ]);

                //get the specification
                if (!$specification = \Modules\DesignSpecification\Models\Specification::Where('mod_specification_id', $email->emailqueue_resourceid)->first()) {
                    Log::error("the specification for this queued email could not be found", ['process' => '[module-designspecification-email-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'mod_specification_id' => $email->emailqueue_resourceid]);
                    $email->delete();
                    continue;
                }

                //get the specification module settings
                if (!$settings = \Modules\DesignSpecification\Models\SpecificationSetting::Where('mod_specifications_settings_id', 'default')->first()) {
                    Log::error("the settings for this module could not be loaded", ['process' => '[module-designspecification-email-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'mod_specification_id' => $email->emailqueue_resourceid]);
                    $email->delete();
                    continue;
                }

                //save the pdf file to disk
                $attachment = $this->savePDF($specification, $settings);

                //send email with attachement (only to a valid email address)
                if ($email->emailqueue_to != '') {
                    Mail::to($email->emailqueue_to)->send(new SendQueued($email, $attachment));

                    //log email
                    $log = new \App\Models\EmailLog();
                    $log->emaillog_email = $email->emailqueue_to;
                    $log->emaillog_subject = $email->emailqueue_subject;
                    $log->emaillog_body = $email->emailqueue_message;
                    $log->emaillog_attachment = $attachment['filename'];
                    $log->save();
                }

                //delete email from the queue
                $email->delete();

                //reset last cron run data
                \App\Models\Settings::where('settings_id', 1)
                    ->update([
                        'settings_cronjob_has_run' => 'yes',
                        'settings_cronjob_last_run' => now(),
                    ]);
            }
        }
    }

    /**
     * Render the PDF invoice and save it to disk (temp folder)
     *  @return array filename & filepath
     */
    public function savePDF($specification = [], $settings = []) {

        //unique file id & directory name
        $uniqueid = Str::random(40);
        $directory = $uniqueid;

        //filename
        $filename = $specification->spec_id . '.pdf';

        //filepath
        $filepath = BASE_DIR . "/storage/temp/$directory/$filename";

        config(['doc_render_mode' => 'pdf-mode']);
        $pdf = PDF::loadView('designspecification::specifications.pdf.pdf', compact('specification', 'settings'));

        //save file
        Storage::put("temp/$directory/$filename", $pdf->output());

        //return the file path
        return [
            'filename' => $filename,
            'filepath' => $filepath,
        ];

    }

}