/**
* Arie Nugraha 2009
* this file need prototype. js
* library to works
*
* Form related functions
*/

/* function to fill select list with AJAX */
var ajaxFillSelect = function(str_handler_file, str_table_name, str_table_fields, str_container_ID)
{
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
var ajaxCheckID = function(str_handler_file, str_table_name, str_ID_fields, str_container_ID, str_input_obj_ID)
{
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

/*function to empty select list*/
var emptySelectList = function(str_select_elmnt_ID, str_default_text)
{
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
var checkAll = function(strFormID, boolUncheck)
{
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

/* Javascript function to collect checkbox data and submit form */
var chboxFormSubmit = function(strFormID)
{
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

/* moving option from select list to another select list */
var moveOption = function(strSelect, strSelectDest)
{
    var selectObj = $(strSelect);
    var destSelectObj = $(strSelectDest);
    var numOptions = destSelectObj.length;
    var idx = selectObj.selectedIndex;
    // get the text and value
    var optText = selectObj.options[idx].text;
    var optValue = selectObj.options[idx].value;
    // create new option for destination select object
    var newOpt = new Option(optText, optValue, true);
    // add it to select list
    destSelectObj.options[numOptions] = newOpt;
}

/* deleting option from select list */
var deleteOption = function(strSelect)
{
    var selectObj = $(strSelect);
    var numOptions = selectObj.length;
    var idx = selectObj.selectedIndex;
    // remove the option object
    selectObj.options[numOptions] = null;
    // select all options
    for (var o=0; o<numOptions; o++) {
        selectObj.options[o].selected = true;
    }
}

/* form submit confirmation */
var confSubmit = function(strFormID, strMsg)
{
    strMsg = strMsg.sub('\'', '\\\'');
    var yesno = confirm(strMsg);
    if (yesno) {
        $(strFormID).submit();
    }
}

/* disable all forms elements
this function is my own implementation for disabling all form elements
*/
var disableForm = function(strFormID)
{
    var formObj = $(strFormID);
    // get all elements in form
    var formElementsArray = formObj.getElements();
    // disable it
    formElementsArray.each( function(elmntObj) { elmntObj.disabled = true; } );
}

/* enable all forms elements
this function is my own implementation for disabling all form elements
*/
var enableForm = function(strFormID, event)
{
    event.preventDefault();
    var formObj = $(strFormID);
    // get all elements in form
    var formElementsArray = formObj.getElements();
    // enable it
    formElementsArray.each( function(elmntObj) { elmntObj.disabled = false; } );
    // display all object with defaultHidden class
    formObj.select('.makeHidden').each( function(hiddenObj) { hiddenObj.className = 'makeVisible'; } );
}

/* submit form */
var showDetailForm = function(strFormID, strFormActionURL, strID)
{
    var formObj = $(strFormID);
    // set form URL
    formObj.action = strFormActionURL;
    // set ID value
    formObj.itemID.value = strID;
    // submit and add additional query
    formObj.submit();
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
                    $(listID).update('<li style="color: red; padding: 2px; font-weight: bold;">NO RESULT FOUND</li>');
                    // remove drop down list
                    setTimeout('$(listID).setStyle({display : \'none\'})', 300);
                    return;
                }
                noResult = false;
                // evaluate json respons
                var jsonObj = respText.evalJSON();
                var strListVal = '';
                jsonObj.each(function(vals) {
                    vals = vals.toString();
                    strListVal += '<li><a class="DDlink" onclick="setInputValue(\'' + strElmntID + '\', \'' + vals + '\')">' + vals + '</a></li>';
                });
                // update the list content
                $(listID).update(strListVal);
            }
        });
}

/* set drop down input value */
var setInputValue = function(strElmntID, strValue) {
    $(strElmntID).value = strValue;
    var listID = strElmntID + 'List';
    $(listID).setStyle({display: 'none'});
}

/* populate AJAX drop down list and show the list */
var showDropDown = function(strURL, strElmntID, strAddParams) {
    var inputObj = $(strElmntID);
    var inputVal = inputObj.value;
    var inputObjWidth = inputObj.getWidth();
    var inputObjXY = inputObj.positionedOffset();
    // List ID
    var listID = strElmntID + 'List';
    if (inputVal.length < 4) {
        $(listID).setStyle({display: 'none'});
        return;
    }
    // populate list ID
    jsonToList(strURL, strElmntID, 'inputSearchVal=' + escape(inputVal) + '&' + strAddParams);
    if (noResult) {
        return;
    }
    $(listID).setStyle({left: inputObjXY.left+'px'});
    $(listID).setStyle({width: inputObjWidth+'px'});
    $(listID).setStyle({display: 'block'});
}

