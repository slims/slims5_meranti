/**
* Arie Nugraha 2009
* this file need prototype. js
* library to works
*
* Form related functions
*/

/* function to fill select list with AJAX */
var ajaxFillSelect = function(str_handler_file, str_table_name, str_table_fields, str_container_ID) {
    var additionalParams = '';
    if (arguments[4] != undefined) {
        additionalParams = '&keywords=' + arguments[4];
    }

    // fill the select list
    var ajaxUpdate = new Ajax.Updater(
        str_container_ID,
        str_handler_file,
        {
            method: 'post',
            parameters: 'tableName=' + str_table_name + '&tableFields=' + str_table_fields + additionalParams
        });
}

/* AJAX check ID */
var ajaxCheckID = function(str_handler_file, str_table_name, str_ID_fields, str_container_ID, str_input_obj_ID) {
    var inputVal = $(str_input_obj_ID).getValue();
    if (inputVal) {
        additionalParams = '&id=' + inputVal;
    } else {
        $(str_container_ID).update('<strong style="color: #FF0000;">Please supply valid ID!</strong>');
        $(str_input_obj_ID).setStyle( { backgroundColor: '#FFCC00' } );
        return;
    }
    // fill the select list
    var ajaxUpdate = new Ajax.Updater(
        str_container_ID,
        str_handler_file,
        {
            method: 'post',
            parameters: 'tableName=' + str_table_name + '&tableFields=' + str_ID_fields + additionalParams,
            evalScripts: true
        });
}

/* function to empty select list */
var emptySelectList = function(str_select_elmnt_ID, str_default_text) {
    var selectObj = $(str_select_elmnt_ID);

    var optionNum = selectObj.length;
    if (optionNum > 0) {
        while (optionNum > 0) {
            for (var i=0; i <= optionNum; i++) {
                selectObj.options[i] = null;
            }
            optionNum--;
        }
    }

    selectObj[0] = new Option(str_default_text, '0', true, true);
    return true;
}

/* Javasript function to check or uncheck all checkbox element */
var checkAll = function(strFormID, boolUncheck) {
    var formObj = $(strFormID);
    // get all checkbox element
    var chkBoxs = formObj.getInputs('checkbox');

    if (!boolUncheck) {
        // check all these checkbox
        chkBoxs.each( function(elmntObj) {
            elmntObj.click();
        });
    } else {
        // check all these checkbox
        chkBoxs.each( function(elmntObj) {
            if (elmntObj.checked) {
                elmntObj.click();
            }
        });
    }
}

/* function to collect checkbox data and submit form */
var chboxFormSubmit = function(strFormID) {
    var formObj = $(strFormID);
    // get all checkbox element
    var chkBoxs = formObj.getInputs('checkbox');

    if (!chkBoxs) {
        return;
    } else {
        var confirmMsg = 'Are You Sure Want to DELETE Selected Data?';
        if (arguments[1] != undefined) {
            confirmMsg = arguments[1];
        }
        var isConfirm = confirm(confirmMsg);
        if (isConfirm) {
            // submit the form
            formObj.submit();
        }
    }
}

/* function to serialize all checkbox element in form */
var serializeChbox = function(strParentID) {
    var serialized = '';
    $(strParentID).select('input[type=checkbox]').each(function(cb) {
        var cbData = cb.getValue();
        if (cbData) {
            serialized += 'itemID[]='+cbData+'&';
        }
    })
    serialized = serialized.sub(/&+$/, '');
    return serialized;
}

/* form submit confirmation */
var confSubmit = function(strFormID, strMsg) {
    strMsg = strMsg.sub('\'', '\\\'');
    var yesno = confirm(strMsg);
    if (yesno) {
        $(strFormID).submit();
    }
}

/* AJAX drop down */
/* catch JSON response and populate it to list */
var listID = '';
var noResult = true;
var jsonToList = function(strURL, strElmntID) {
    var addParams = '';
    if (arguments[2] != undefined) {
        addParams = arguments[2];
    }
    // escape single quotes
    strURL = strURL.sub("'", "\'");
    var ajaxJSON = new Ajax.Request(strURL, {
        method: 'post',
        parameters: addParams,
        onSuccess: function(ajaxTransport) {
                listID = strElmntID + 'List';
                // get AJAX response text
                var respText = ajaxTransport.responseText.strip();
                if (!respText) {
                    noResult = true;
                    return;
                }
                noResult = false;
                // evaluate json respons
                var jsonObj = respText.evalJSON();
                var strListVal = '';
                jsonObj.each(function(vals) {
                    vals = vals.toString();
                    strListVal += '<li><a class="DDlink" onclick="setInputValue(\'' + strElmntID + '\', \'' + vals.sub("'", "\\'") + '\')">' + vals + '</a></li>';
                });
                // update the list content
                $(listID).update(strListVal);
            }
        });
}

/* set drop down input value */
var setInputValue = function(strElmntID, strValue) {
    $(strElmntID).value = strValue;
    $(strElmntID + 'List').hide();
}

/* populate AJAX drop down list and show the list */
var showDropDown = function(strURL, strElmntID, strAddParams) {
    var inputObj = $(strElmntID);
    var inputVal = inputObj.value;
    var inputObjWidth = inputObj.getWidth();
    var inputObjXY = inputObj.positionedOffset();
    // List ID
    var listObj = $(strElmntID + 'List');
    if (inputVal.length < 4) { listObj.hide(); return; }
    // populate list ID
    jsonToList(strURL, strElmntID, 'inputSearchVal=' + escape(inputVal) + '&' + strAddParams);
    if (noResult) { return; }
    // show list
    listObj.setStyle({left: inputObjXY.left+'px', width: inputObjWidth+'px', display: 'block'});
    // observe click
    $(document.body).observe('click', function(event) {
        var clickedElement = Event.element(event);
        if (!clickedElement.match('#' + strElmntID + 'List')) {
            listObj.hide();
        }
    });
}
