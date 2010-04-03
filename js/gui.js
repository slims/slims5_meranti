/**
* Arie Nugraha 2009
* this file need prototype. js
* library to works
*
* UI related functions
*/

var registerAdminEvents = function()
{
    // register submenu event
    $$('.subMenuItem').invoke('observe', 'click', function(evt) {
        evt.preventDefault();
        var subMenu = Event.element(evt);
        // remove other current link marker on non-active submenu
        $$('.subMenuItem').invoke('removeClassName', 'curModuleLink');
        var subMenuHREF = subMenu.addClassName('curModuleLink').readAttribute('href');
        setContent('mainContent', subMenuHREF, 'get');
    }).invoke('observe', 'mouseover', function(evt) { evt.preventDefault(); } );
}

/* change the style of circulation tab */
var setTabClass = function(objTab)
{
    var defaultClass = 'tab';
    var tabSelectedClass = 'tabSelected';
    // remove selected class from other tabs
    $('mainContent').select('input.tab').invoke('removeClassName', tabSelectedClass);
    // add class to current tab object
    $(objTab).addClassName(tabSelectedClass);
}

/* color of highlighted row */
var strRowColor = '#64ff64';
/* color of highlighted row based on checkbox */
var strRowSelColor = '#ffb865';
/* extending prototype's Element methods */
Element.addMethods({
    changeCellColor: function(element) {
        element = $(element);
        if (element.hasClassName('cbChecked')) return;
        element.setStyle({backgroundColor: strRowColor});
        return element;
    },

    removeCellColor: function(element) {
        element = $(element);
        if (element.hasClassName('cbChecked')) return;
        // reset the background color property
        element.setStyle({ backgroundColor: '' });
        return element;
    }
});

/* highlight the selected row */
var highlightRow = function(strRowID)
{
    // get the descendants TD of row
    $(strRowID).select('td').invoke('changeCellColor');
}

/* unhighlight the selected row */
var unHighlightRow = function(strRowID)
{
    // get the descendants TD of row
    $(strRowID).select('td').invoke('removeCellColor');
}

/* highlight the selected row based on checkbox */
var firstChecked = 0;
var secondChecked = 0;
var cbHighlightRow = function(cbObj, strRowID, event)
{
    // color buffer
    var clr = '';
    // check is the checkbox is in checked state
    isChecked = cbObj.checked;
    // get the descendants TD of row
    var descTD = $(strRowID).select('td');

    if (isChecked) {
        clr = strRowSelColor;
        var isShift = event.shiftKey;
        // get cbObj id string
        var idStr = $(cbObj).readAttribute('id');
        // get number from idStr
        var chboxNum = idStr.replace(/[a-z]+/i, '');
        chboxNum = parseInt(chboxNum);
        if (!isShift) {
            firstChecked = chboxNum;
        } else {
            if (firstChecked > 0) {
                secondChecked = chboxNum;
            }
        }
        // check if shift key is pressed
        if (isShift && (firstChecked > 0) && (secondChecked > 0)) {
            var start = Math.min(firstChecked, secondChecked);
            var end = Math.max(firstChecked, secondChecked);
            for (c = start+1; c <= end-1; c++) {
                $('cbRow' + c).click();
            }
            // reset
            firstChecked = 0; secondChecked = 0;
        }
        // set style for each of TD
        descTD.invoke('addClassName', 'cbChecked').invoke('setStyle', {backgroundColor: clr});
    } else {
        // set style for each of TD
        descTD.invoke('removeClassName', 'cbChecked').invoke('setStyle', {backgroundColor: ''});
    }
}

/* Javasript function to open new window  */
var openWin = function(strURL, strWinName, intWidth, intHeight, boolScroll)
{
    // variables to determine the center position of window
    var xPos = (screen.width - intWidth)/2;
    var yPos = (screen.height - intHeight)/2;

    var withScrollbar = 'no';

    // if scrollbar allowed
    if (boolScroll) {
        withScrollbar = 'yes';
    }

    window.open(strURL, strWinName, "height=" + intHeight + ",width=" + intWidth +
    ",menubar=no, scrollbars=" + withScrollbar + ", location=no, toolbar=no," +
    "directories=no,resizable=no,screenY=" + yPos + ",screenX=" + xPos + ",top=" + yPos + ",left=" + xPos);
}

/* Javasript function to open pop-up window floating div  */
var htmlPop = null;
var blocker = null;
var openHTMLpop = function(strURL, intWidth, intHeight, strPopTitle)
{
    // retrieve required dimensions
    var browserDims = document.body.getDimensions();
    // calculate the center of the page using the browser and element dimensions
    var yPos = 30;
    var xPos = (browserDims.width - intWidth)/2;

    $(document.body).insert('<div id="blocker"></div>'
        + '<div id="htmlPop">'
        + '<div id="htmlPopTitle" style="float: left; width: 70%">' + strPopTitle + '</div>'
        + '<div style="float: right; width: 20%; text-align: right;">'
        + '<a href="#" style="color: red; font-weight: bold;" onclick="closeHTMLpop()">Close</a>'
        + '</div>'
        + '<iframe id="htmlPopFrame" src="' + strURL + '" frameborder="0"></iframe>'
        + '</div>');
    // set element
    blocker = $('blocker');
    htmlPop = $('htmlPop');
    htmlPopFrame = $('htmlPopFrame');
    // set pop up styles property
    blocker.setStyle({top: 0, left: 0, width: '100%', height: screen.height+'px', position: 'fixed', backgroundColor: '#000', opacity: 0.3});
    htmlPopFrame.setStyle({width: '100%', height: intHeight+'px'});
    htmlPop.setStyle({position: 'fixed', top: yPos+'px', left: xPos+'px', margin: 'auto', width: intWidth+'px', opacity: 0.9});
    // register ESC button event handler
    top.Event.observe(document.body, 'keypress', function(event) {
        if (event.which == 0) { closeHTMLpop(); }
    });
}

var closeHTMLpop = function()
{
    // stop observing
    top.Event.stopObserving(document.body, 'keypress', function(event) {});
    htmlPop.remove(); blocker.remove();
}

/* set iframe content */
var setIframeContent = function(strIframeID, strUrl)
{
    var iframeObj = $(strIframeID);
    if (iframeObj != undefined) { iframeObj.src = strUrl; }
}

/* register event for dragger */
/* coding all night just to get this thing works :D */
var resizedObj = new Object();
var dragger = new Object();
var resizedObjHeight = 0;
var offSet = 0;
var evtHandler = {
    mouseMove: function(evt) {
        resizedObj.setStyle( {height: Math.max(100, offSet + Event.pointerY(evt)) + 'px'} );
        return false;
    }
}

var registerDraggerEvent = function(str_dragger_id, str_resized_obj_id)
{
    resizedObj = $(str_resized_obj_id);
    dragger = $(str_dragger_id);
    Event.observe(dragger, 'mousedown', function(evt) {
        offSet = resizedObj.getHeight()-Event.pointerY(evt);
        mouseMoveHandler = evtHandler.mouseMove.bindAsEventListener(evtHandler);
        // register the mouse up event handler
        Event.observe(dragger, 'mouseup', function() {
            // unregister mouse move event handler
            Event.stopObserving(dragger, 'mousemove', mouseMoveHandler);
        });
        // register the mouse out event handler
        Event.observe(dragger, 'mouseout', function() {
            // unregister mouse move event handler
            Event.stopObserving(dragger, 'mousemove', mouseMoveHandler);
        });
        // register the mouse move event handler
        Event.observe(dragger, 'mousemove', mouseMoveHandler);
    });
}

/* hide table rows */
var hiddenTables = new Array();
var hideRows = function(str_table_id, int_start_row)
{
    var rows = $(str_table_id).select('.divRow');
    var skip = 0;
    rows.each(function(row_obj) {
        if (skip < int_start_row) {
            skip++;
            return;
        } else {
            row_obj.setStyle({display: 'none'});
        }
    });
    // add table id to hidden table array
    hiddenTables.push(str_table_id);
}

/* show table rows */
var showRows = function(str_table_id)
{
    var rows = $(str_table_id).select('.divRow').invoke('setStyle', {display: 'block'});
}

/* toogle show/hide table rows */
var showHideTableRows = function(str_table_id, int_start_row, obj_button, str_hide_text, str_show_text)
{
    obj_button = $(obj_button);
    if (hiddenTables.include(str_table_id)) {
        showRows(str_table_id);
        hiddenTables = hiddenTables.without(str_table_id);
        obj_button.setValue(str_show_text);
    } else {
        hideRows(str_table_id, int_start_row);
        obj_button.setValue(str_hide_text)
    }
}
