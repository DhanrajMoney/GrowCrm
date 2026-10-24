"use strict";

$(document).ready(function () {






});



/**--------------------------------------------------------------------------------------
 * [ADD SPECIFICATION]
 * @description: Add edit sources
 * -------------------------------------------------------------------------------------*/
function ModuleSpecificationAddEdit() {

    //upload avatar
    $("#mod_specification_image_1").dropzone({
        url: "/upload-general-image",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        maxFiles: 1,
        maxFilesize: 2, // MB
        acceptedFiles: 'image/jpeg, image/png',
        thumbnailWidth: null,
        thumbnailHeight: null,
        init: function () {
            this.on("error", function (file, message, xhr) {

                //is there a message from backend [abort() response]
                if (typeof xhr != 'undefined' && typeof xhr.response != 'undefined') {
                    var error = $.parseJSON(xhr.response);
                    var message = error.notification.value;
                }

                //any other message
                message = (typeof message == 'undefined' || message == '' ||
                    typeof message == 'object') ? NXLANG.generic_error : message;

                //error message
                NX.notification({
                    type: 'error',
                    message: message
                });
                //remove the file
                this.removeFile(file);
            });
        },
        success: function (file, response) {
            //get the priview box dom elemen
            var $preview = $(file.previewElement);
            //create a hidden form field for this file
            $preview.append('<input type="hidden" name="image_filename_1"  value="' + response.filename + '">');
            $preview.append('<input type="hidden" name="image_directory_1"  value="' + response.uniqueid + '">');
        }
    });



    //upload avatar
    $("#mod_specification_image_2").dropzone({
        url: "/upload-general-image",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        maxFiles: 1,
        maxFilesize: 2, // MB
        acceptedFiles: 'image/jpeg, image/png',
        thumbnailWidth: null,
        thumbnailHeight: null,
        init: function () {
            this.on("error", function (file, message, xhr) {

                //is there a message from backend [abort() response]
                if (typeof xhr != 'undefined' && typeof xhr.response != 'undefined') {
                    var error = $.parseJSON(xhr.response);
                    var message = error.notification.value;
                }

                //any other message
                message = (typeof message == 'undefined' || message == '' ||
                    typeof message == 'object') ? NXLANG.generic_error : message;

                //error message
                NX.notification({
                    type: 'error',
                    message: message
                });
                //remove the file
                this.removeFile(file);
            });
        },
        success: function (file, response) {
            //get the priview box dom elemen
            var $preview = $(file.previewElement);
            //create a hidden form field for this file
            $preview.append('<input type="hidden" name="image_filename_2"  value="' + response.filename + '">');
            $preview.append('<input type="hidden" name="image_directory_2"  value="' + response.uniqueid + '">');
        }
    });


    $("#commonModalForm").validate().destroy();
    $("#commonModalForm").validate({
        rules: {
            //mod_specification_client: "required",
            mod_specification_id_building_type: "required",
            mod_specification_id_building_number: "required",
            mod_specification_id_spec_type: "required",
            mod_specification_item_name: "required",
            mod_specification_date_issue: "required",
            mod_specification_manufacturer: "required",
            mod_specification_rep_name: "required",
            mod_specification_contact_name: "required",
            mod_specification_contact_email: "required",
            mod_specification_contact_address_1: "required",
            mod_specification_id_building_venue: "required"
        },
        submitHandler: function (form) {
            nxAjaxUxRequest($("#commonModalSubmitButton"));
        }
    });
}



/**--------------------------------------------------------------------------------------
 * [ADD SPECIFICATION]
 * @description: Add edit sources
 * -------------------------------------------------------------------------------------*/
function ModuleSpecificationSettingsNotes() {
    $("#commonModalForm").validate().destroy();
    $("#commonModalForm").validate({
        rules: {},
        submitHandler: function (form) {
            nxAjaxUxRequest($("#commonModalSubmitButton"));
        }
    });
}