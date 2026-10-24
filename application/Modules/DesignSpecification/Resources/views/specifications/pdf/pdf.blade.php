<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" id="meta-csrf" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('system.settings_company_name') }}</title>


    <!--
        web preview example
        https://domain.com/modules/designspecification/1/pdf?view=preview
    -->

    @if(request('view') == 'preview')
    <base href="{{ url('/') }}" target="_self">
    <link href="public/vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!--GOOGLE FONTS-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet"
        type="text/css">
    @else
    <base href="" target="_self">
    <link href="{{ BASE_DIR }}/public/vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- [DYNAMIC] style sets dynamic paths to font files-->
    <style>
        @font-face {
            font-family: 'DejaVuSans';
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path("app/DejaVuSans.ttf") }}') format("truetype");
        }

        @font-face {
            font-family: 'DejaVuSans';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path("app/DejaVuSans.ttf") }}') format("truetype");
        }

        @font-face {
            font-family: 'DejaVuSans';
            font-style: normal;
            font-weight: bold;
            src: url('{{ storage_path("app/DejaVuSans-Bold.ttf") }}') format("truetype");
        }

        @font-face {
            font-family: 'DejaVuSans';
            font-style: normal;
            font-weight: 600;
            src: url('{{ storage_path("app/DejaVuSans-Bold.ttf") }}') format("truetype");
        }
    </style>



    @if(request('view') == 'preview')
    <link href="{{ url('application/Modules/DesignSpecification/Resources/assets/css/pdf.css') }}" rel="stylesheet">
    @else
    <link href="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/css/pdf.css" rel="stylesheet">
    @endif

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="public/images/favicon.png">
</head>

<body class="module-designspeficifation-pdf {{ config('doc_render_mode') }}">

    <div class="pdf-wrapper {{ config('doc_render_mode') }}">

        <!--SECTION 1-->
        <table class="table-1">
            <tbody>
                <tr>
                    <td class="table-1-td-1">
                        <!--logo-->
                        @if(request('view') == 'preview')
                        <img src="{{ url('storage/logos/app/'.config('system.settings_system_logo_large_name')) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/storage/logos/app/{{ config('system.settings_system_logo_large_name') }}">
                        @endif
                    </td>
                    <td class="table-1-td-2">
                        <table class="table-2">
                            <tbody>
                                <tr>
                                    <td class="table-2-td-1">
                                        {{ $specification->spec_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="table-2-td-2">
                                        {{ $specification->mod_specification_item_name }}
                                    </td>
                                <tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <!--SECTION-2-->
        <table class="table-3">
            <tbody>
                <tr>
                    <td class="table-3-td-1 td-border-bottom p-t-10 p-b-10">
                        <table class="table-4">
                            <tbody>
                                <tr>
                                    <td class="p-b-6">
                                        <span class="x-label">@lang('designspecification::lang.venue'): </span>
                                        <span
                                            class="x-text">{{ $specification->mod_specification_id_building_venue  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="x-label">@lang('designspecification::lang.venue')#: </span>
                                        <span class="x-text">{{ $specification->spec_venue_id }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="table-3-td-2 td-border-bottom p-t-10 p-b-10">
                        <table class="table-5">
                            <tbody>
                                <tr>
                                    <td class="p-b-6">
                                        <span class="x-label">@lang('designspecification::lang.issue_date'): </span>
                                        <span
                                            class="x-text">{{ runtimeDate($specification->mod_specification_date_issue)  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="x-label">@lang('designspecification::lang.revision_date'): </span>
                                        <span
                                            class="x-text">{{ runtimeDate($specification->mod_specification_date_revision) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>


        <!--SECTION-3-->
        <table class="table-3">
            <tbody>
                <tr>
                    <td class="table-3-td-1 td-border-bottom p-t-15 p-b-0 vertical-align-top">
                        <table class="table-4">
                            <tbody>
                                <tr>
                                    <td class="p-b-20">
                                        <span class="x-label">@lang('designspecification::lang.manufacturer'): </span>
                                        <span
                                            class="x-text">{{ $specification->mod_specification_manufacturer ?? ''  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-b-10">
                                        <table class="contact">
                                            <tbody>
                                                <tr>
                                                    <td class="vertical-align-top">
                                                        <span
                                                            class="x-label">@lang('designspecification::lang.contact'):
                                                        </span>
                                                    </td>
                                                    <td class="vertical-align-top w-100">
                                                        @if($specification->mod_specification_contact_name)
                                                        <div>{{ $specification->mod_specification_contact_name }}
                                                        </div>
                                                        @endif
                                                        @if($specification->mod_specification_contact_email)
                                                        <div>{{ $specification->mod_specification_contact_email }}</div>
                                                        @endif
                                                        @if($specification->mod_specification_contact_address_1)
                                                        <div class="word-wrap">
                                                            {{ $specification->mod_specification_contact_address_1 }}
                                                        </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td class="table-3-td-2 td-border-bottom p-t-20 p-b-30 vertical-align-top">
                        <table class="table-5">
                            <tbody>
                                <tr>
                                    <td class="p-b-20">
                                        <table class="contact">
                                            <tbody>
                                                <tr>
                                                    <td class="vertical-align-top">
                                                        <span class="x-label">@lang('designspecification::lang.rep'):
                                                        </span>
                                                    </td>
                                                    <td class="vertical-align-top w-100">
                                                        <div>{{ $specification->mod_specification_rep_name }}
                                                        </div>
                                                        <div>{{ $specification->mod_specification_rep_company }}
                                                        </div>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>



        <!--SECTION 4-->
        <table class="table-5">
            <tbody>
                <tr>
                    <td class="td-border-bottom vertical-align-top">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="p-t-20 p-b-6">
                                        <span class="x-label">@lang('designspecification::lang.item_name'): </span>
                                        <span class="x-text">{{ $specification->mod_specification_item_name  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-b-6">
                                        <span class="x-label">@lang('designspecification::lang.description'): </span>
                                        <span
                                            class="x-text">{{ $specification->mod_specification_item_description  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-b-6">
                                        <span class="x-label">@lang('designspecification::lang.dimenensions'): </span>
                                        <span
                                            class="x-text">{{ $specification->mod_specification_item_dimensions  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vertical-align-top p-t-15">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="vertical-align-top">
                                                        <span
                                                            class="x-label">@lang('designspecification::lang.requirements'):
                                                        </span>
                                                    </td>
                                                    <td class="vertical-align-top w-100 p-r-30">
                                                        {!! $specification->mod_specification_item_requirements !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="vertical-align-top p-t-15 p-b-20">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class="vertical-align-top">
                                                        <span class="x-label">@lang('designspecification::lang.note'):
                                                        </span>
                                                    </td>
                                                    <td class="vertical-align-top w-100 p-r-30">
                                                        {!! $specification->mod_specification_item_note !!}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </td>

                    <!--images-->
                    <td class="td-border-bottom td-border-left w-40 p-l-30 p-r-30 vertical-align-top p-t-20">

                        @if($specification->mod_specification_has_image_1 =='yes' || $specification->mod_specification_has_image_2 =='yes')
                        <table class="images-table">
                                <tr>
                                    <td class="p-b-5">
                                        <span
                                            class="x-title">{{ $specification->mod_specification_images_title }}</span>
                                    </td>
                                </tr>

                                @if($specification->mod_specification_has_image_1 =='yes')
                                <tr>
                                    <td>{{ $specification->mod_specification_image_1_details }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(request('view') == 'preview')
                                            <img class="spec_image"
                                                src="{{ url('storage/files/'.$specification->mod_specification_image_1_directory.'/'.$specification->mod_specification_image_1_filename) }}">
                                        </div>
                                        @else
                                        <div class="x-dimensions">
                                            {{ $specification->mod_specification_image_1_details }}</div>
                                        <img class="spec_image"
                                            src="{{ BASE_DIR }}/storage/files/{{ $specification->mod_specification_image_1_directory }}/{{ $specification->mod_specification_image_1_filename }}">
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($specification->mod_specification_has_image_2 =='yes')
                                <tr>
                                    <td>{{ $specification->mod_specification_image_2_details }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(request('view') == 'preview')
                                            <img class="spec_image"
                                                src="{{ url('storage/files/'.$specification->mod_specification_image_2_directory.'/'.$specification->mod_specification_image_2_filename) }}">
                                        </div>
                                        @else
                                        <div class="x-dimensions">
                                            {{ $specification->mod_specification_image_2_details }}</div>
                                        <img class="spec_image"
                                            src="{{ BASE_DIR }}/storage/files/{{ $specification->mod_specification_image_2_directory }}/{{ $specification->mod_specification_image_2_filename }}">
                                        @endif
                                    </td>
                                </tr>
                                @endif
                        </table>
                        @endif

                    </td>


                </tr>
            </tbody>
        </table>


        <!--SECTION 5-->
        <table>
            <tbody>
                <tr>
                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_finish_sample) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_finish_sample) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.finish_sample')</span>
                    </td>


                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_strike_off) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_strike_off) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.strike_off')</span>
                    </td>


                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_cutting) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_cutting) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.cuttting')</span>
                    </td>


                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_shop_drawing) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_shop_drawing) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.shop_drawings')</span>
                    </td>


                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_prototype) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_prototype) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.prototype')</span>
                    </td>


                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_seaming_diagram) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_seaming_diagram) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.seaming_diagram')</span>
                    </td>


                    <td class="vertical-align-middle td-border-bottom p-t-5 p-b-5">
                        @if(request('view') == 'preview')
                        <img
                            src="{{ url('application/Modules/DesignSpecification/Resources/assets/images/') }}/{{ moduleCheckBoxStatus($specification->mod_specification_type_cut_sheet) }}">
                        @else
                        <img
                            src="{{ BASE_DIR }}/application/Modules/DesignSpecification/Resources/assets/images/{{ moduleCheckBoxStatus($specification->mod_specification_type_cut_sheet) }}">
                        @endif
                        <span class="vertical-align-middle">@lang('designspecification::lang.cut_sheet')</span>
                    </td>
                </tr>
            </tbody>
        </table>

        <!--SECTION 6-->
        <table>
            <tbody>
                <tr>
                    <td class="p-t-10">
                        {!! $settings->mod_specifications_settings_notes !!}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>