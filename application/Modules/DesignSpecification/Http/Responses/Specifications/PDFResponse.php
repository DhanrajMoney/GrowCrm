<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [pdf] process for the invoices
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Modules\DesignSpecification\Http\Responses\Specifications;

use Illuminate\Contracts\Support\Responsable;
use PDF;

class PDFResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //[debugging purposes] view invoice in browser (https://domain.com/modules/designspecification/1/pdf?view=preview)
        if (request('view') == 'preview') {
            config(['doc_render_mode' => 'preview-mode']);
            $html = view('designspecification::specifications.pdf.pdf', compact('page', 'specification', 'settings'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#commonModalBody',
                'action' => 'replace',
                'value' => $html,
            ];
            return response()->json($jsondata);
        }

        //download pdf view
        config(['doc_render_mode' => 'pdf-mode']);
        $pdf = PDF::loadView('designspecification::specifications.pdf.pdf', compact('page', 'specification', 'settings'));
        $filename = $specification->spec_id . '.pdf';
        return $pdf->download($filename);
    }
}
