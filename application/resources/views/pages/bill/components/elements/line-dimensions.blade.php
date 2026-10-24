<!--EACH LINE ITEM X-->
<tr class="billing-line-item" id="lineitem_{{ $lineitem->lineitem_id ?? '' }}" type="dimensions">
    <!--action-->
    <td class="td-action list-table-action x-action bill_col_action">
        <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
            class="data-toggle-tooltip btn btn-outline-danger btn-circle btn-sm js-billing-line-item-delete">
            <i class="sl-icon-trash"></i>
        </button>
    </td>
    <!--description-->
    <td class="form-group x-description bill_col_description">
        <textarea class="form-control form-control-sm js_item_description js_line_validation_item" rows="3"
            name="js_item_description[{{ $lineitem->lineitem_id ?? '' }}]">{{ $lineitem->lineitem_description ?? '' }}</textarea>
    </td>
    <!--quantity-->
    <td class="form-group x-quantity bill_col_quantity">
        <!--length-->
        <div class="input-group input-group-sm m-b-4">
            <span class="input-group-addon" id="fx-line-item-hrs">L</span>
            <input type="number" class="form-control js_item_length calculation-element js_line_validation_item"
                name="js_item_length[{{ $lineitem->lineitem_id ?? '' }}]"
                value="{{ $lineitem->lineitem_dimensions_length ?? '' }}">
        </div>
        <!--width-->
        <div class="input-group input-group-sm">
            <span class="input-group-addon" id="fx-line-item-min">W</span>
            <input type="number" class="form-control js_item_width calculation-element js_line_validation_item"
                name="js_item_width[{{ $lineitem->lineitem_id ?? '' }}]"
                value="{{ $lineitem->lineitem_dimensions_width ?? '' }}">
        </div>

    </td>
    <!--units (hrs)-->
    <td class="form-group x-unit bill_col_unit">
        <input class="form-control form-control-sm js_item_unit js_line_validation_item" type="text"
            name="js_item_unit[{{ $lineitem->lineitem_id ?? '' }}]" value="{{ $lineitem->lineitem_unit ?? '' }}">
    </td>
    <!--rate-->
    <td class="form-group x-price bill_col_price">
        <input
            class="form-control form-control-sm js_item_rate calculation-element decimal-field js_line_validation_item"
            type="number" step="1" name="js_item_rate[{{ $lineitem->lineitem_id ?? '' }}]"
            value="{{ $lineitem->lineitem_rate ?? '' }}">
    </td>

    <!--total-->
    <td class="form-group x-total" id="bill_col_total">
        <input class="form-control form-control-sm js_item_total decimal-field" type="number" step="0.01"
            name="js_item_total[{{ $lineitem->lineitem_id ?? '' }}]" value="{{ $lineitem->lineitem_total ?? '' }}"
            disabled>
    </td>

    <!--line item type-->
    <input type="hidden" class="js_item_type" name="js_item_type[{{ $lineitem->lineitem_id ?? '' }}]"
        value="dimensions">
    <input type="hidden" class="js_item_linked_type" name="js_item_linked_type[{{ $lineitem->lineitem_id ?? '' }}]"
        value="dimensions">
    <input type="hidden" class="js_item_linked_id" name="js_item_linked_id[{{ $lineitem->lineitem_id ?? '' }}]"
        value="{{ $lineitem->lineitemresource_linked_id ?? '' }}">
    <input type="hidden" class="js_item_dimensionsrs_list"
        name="js_item_dimensionsrs_list[{{ $lineitem->lineitem_id ?? '' }}]"
        value="{{ $lineitem->lineitem_dimensions_dimensionsrs_list ?? '' }}">

</tr>
<!--/#EACH LINE ITEM-->