/**
 * Arie Nugraha 2009
 * Simbio GUI related functions
 *
 * Require : jQuery library
 */


/**
 * jQuery Plugins function to set row event on datagrid table
 *
 * @param       object      an additional option for table
 * @return      jQuery
 *
 * @example usage
 * $('.datagrid').simbioTable();
 * or
 * $('.datagrid').simbioTable({ mouseoverCol: '#bcd4ec', highlightCol: 'yellow' });
 */
jQuery.fn.simbioTable = function(params) {
    // set some options
    var options = {
        mouseoverCol: '#6dff77',
        highlightCol: 'yellow'
    };
    jQuery.extend(options, params);

    var tableRows = $(this).children('thead,tbody,tfoot').children('tr');
    // try straight search to TR
    if (tableRows.length < 1) { tableRows = $(this).children('tr'); }
    // add non-standar 'row' attribute to indicate row position
    tableRows.each(function(i) {
            $(this).attr('row', i);
        });

    // event register
    tableRows.mouseover(function() {
        // on mouse over change background color
        if (!this.highlighted) {
            this.originColor = $(this).css('background-color');
            $(this).css('background-color', options.mouseoverCol);
        }
    }).mouseout(function() {
        // on mouse over revert background color to original
        if (!this.highlighted) {
            $(this).css('background-color', this.originColor);
        }
    }).click(function(evt) {
        var currRow = $(this);
        if (!this.originColor) {
            this.originColor = currRow.css('background-color');
        }
        // on click highlight row with new background color
        if (this.highlighted) {
            this.highlighted = false;
            currRow.removeClass('highlighted last-highlighted').css({'background-color': this.originColor}).find('td');
            // uncheck the checkbox on row if exists
            currRow.find('input:checkbox[name=itemID\[\]]').removeAttr('checked');
        } else {
            // set highlighted flag
            this.highlighted = true;
            // check the checkbox on row if exists
            currRow.find('input:checkbox[name=itemID\[\]]').attr('checked', 'checked');
            currRow.find('input:text,textarea,select').first().focus();

            // get parent table of row
            var parentTable = $( currRow.parents('table')[0] );

            // get last highlighted row index
            var lastRow = parseInt(parentTable.find('.last-highlighted').attr('row'));
            // get current row index
            var currentRow = parseInt(currRow.attr('row'));

            if (evt.shiftKey) {
                var start = Math.min(currentRow, lastRow);
                var end = Math.max(currentRow, lastRow);
                for (var r = start+1; r <= end-1; r++) {
                    parentTable.find('tr[row=' + r + ']').trigger('click');
                }
            }

            // remove all last-highlighted row class
            parentTable.find('.last-highlighted').removeClass('last-highlighted');
            // highlight current clicked row
            currRow.addClass('highlighted last-highlighted').css({'background-color': options.highlightCol}).find('td');
        }
    });

    return $(this);
};


/**
 * jQuery Plugins function to make dynamic addition form field
 *
 *
 * @return      jQuery
 */
jQuery.fn.dynamicField = function() {
    var dynFieldClass = this.attr('class');
    this.find('.add').click(function() {
        // get div parent element
        var currentField = $(this).parent();
        var addField = currentField.clone(true);
        // append remove button and remove ".add" button for additional field
        addField.append(' <a href="#" class="remove-field">Remove</a>').children().remove('.add');
        // add cloned field after
        currentField.after(addField[0]);
        // register event for remove button
        $(document).ready(function() {
            $('.remove-field', this).click(function() {
                // remove field
                var toRemove = $(this).parent().remove();
            });
        });
    });

    return $(this);
}


/**
 * jQuery plugins to disable all input field inside form
 *
 *
 * @return      jQuery
 */
jQuery.fn.disableForm = function() {
    var disabledForm = $(this);
    disabledForm.find('input,select,textarea').each(function() {
        this.disabled = true;
    });
    return disabledForm;
}


/**
 * jQuery plugins to enable all input field inside form
 *
 *
 * @return      jQuery
 */
jQuery.fn.enableForm = function() {
    var enabledForm = $(this);
    enabledForm.find('input,select,textarea').each(function() {
        this.disabled = false;
    });
    return enabledForm;
}


/**
 * JQuery method to unbind all related event on specified selector
 */
jQuery.fn.unRegisterEvents = function() {
    var container = $(this);
    // unbind all event handlers
    container.find('a,table,tr,td,input,textarea,div').unbind();
    return container;
}


/**
 * Add some utilities function to jQuery namespace
 */
jQuery.extend({
    unCheckAll: function(strSelector) {
        $(strSelector).find('tr').each(function() {
            if ($(this).hasClass('highlighted')) {
                $(this).trigger('click');
            }
        });
    },
    checkAll: function(strSelector) {
        $(strSelector).find('tr').each(function() {
            if (!$(this).hasClass('highlighted')) {
                $(this).trigger('click');
            }
        });
    }
});

/* AJAX plugins for SLiMS */
jQuery.fn.registerAdminEvents = function(params) {
    // set some options
    var options = {
        ajaxifyLink: true,
        ajaxifyForm: true
    };
    jQuery.extend(options, params);

    // cache AJAX container
    var container = $(this);

    // avoid conflict with tinyMCE
    container.find('.mceEditor a').addClass('notAJAX');

    if (options.ajaxifyLink) {
        // change all anchor behaviour to AJAX in main content
        container.find('a:not(.notAJAX)').click(function(evt) {
            evt.preventDefault();
            var anchor = $(this);
            // get anchor href
            var url = anchor.attr('href');
            var postData = anchor.attr('postdata');
            var loadContainer = anchor.attr('loadcontainer');
            if (loadContainer) {
                container = jQuery('#'+loadContainer);
            }
            // set ajax
            if (postData) {
                container.simbioAJAX(url, {method: 'post', addData: postData});
            } else {
                container.simbioAJAX(url, {addData: {ajaxload: 1}});
            }
        });
    }

    // set all table with class datagrid
    container.find('table.datagrid,#dataList').each(function() {
        var datagrid = $(this);
        datagrid.simbioTable();
        // register uncheck click event
        $('.uncheck-all').click(function() {
            jQuery.unCheckAll('.datagrid,#dataList');
        });
        // register check click event
        $('.check-all').click(function() {
            jQuery.checkAll('.datagrid,#dataList');
        });
        // set all row to show detail when double clicked
        datagrid.children('thead,tbody,tfoot').children('tr').each( function() {
            var tRow = $(this);
            var rowLink = tRow.css({'cursor' : 'pointer'}).find('.editLink');
            if (rowLink[0] != undefined) {
                tRow.dblclick(function() {$(rowLink[0]).trigger('click')});
            }
        });
        // unregister event for table-header
        $('.table-header', datagrid).parent().unbind();
    });

    // change all search form submit behaviour to AJAX
    container.find('form.disabled').disableForm();

    // change all search form submit behaviour to AJAX
    container.find('.editFormLink').click(function(evt) {
        evt.preventDefault();
        var theForm = $(this).parents('form').enableForm().find('input,textarea').not(':submit,:button').first().focus();
        $('.makeHidden').removeClass('makeHidden');
        // enable hidden delete form
        container.find('#deleteForm').enableForm();
    });

    if (options.ajaxifyForm) {
        // change all search form submit behaviour to AJAX
        container.find('.menuBox form:not(.notAJAX)').submit(function(evt) {
            var theForm = $(this);
            if (theForm.attr('target')) {
                theForm[0].submit();
                return;
            }
            evt.preventDefault();
            var formAction = theForm.attr('action');
            var formMethod = theForm.attr('method');
            var formData = theForm.serialize();
            var loadContainer = theForm.attr('loadcontainer');
            if (loadContainer) {
                container = jQuery('#'+loadContainer);
            }
            container.simbioAJAX(formAction, {method: formMethod, addData: formData});
        });
    }

    // focus first element
    container.find('input[type=text]:first').focus();
    // focus first form element
    var mainForm = container.find('#mainForm'); if (mainForm.length > 0) { mainForm.find('input,textarea').not(':submit,:button').first().focus(); }
    // disable form marked with disabled attribute
    container.find('form.disabled').disableForm().find('.cancelButton').removeAttr('disabled').click(function() {
        jQuery.ajaxPrevious(0);
    });

    container.find('input.tab').click(function() {
        container.find('input.tab').removeClass('tabSelected');
        var tabButton = $(this).addClass('tabSelected');
        var tabSrc = tabButton.attr('src');
        if (tabSrc) {
            // set iframe content
            setIframeContent('listsFrame', tabSrc);
        }
    });

    return container;
}

/* Javasript function to open new window  */
var openWin = function(strURL, strWinName, intWidth, intHeight, boolScroll) {
    // variables to determine the center position of window
    var xPos = (screen.width - intWidth)/2;
    var yPos = (screen.height - intHeight)/2;

    var withScrollbar = 'no';
    // if scrollbar allowed
    if (boolScroll) { withScrollbar = 'yes'; }

    window.open(strURL, strWinName, "height=" + intHeight + ",width=" + intWidth +
    ",menubar=no, scrollbars=" + withScrollbar + ", location=no, toolbar=no," +
    "directories=no,resizable=no,screenY=" + yPos + ",screenX=" + xPos + ",top=" + yPos + ",left=" + xPos);
}

/* Javasript function to open pop-up window floating div  */
var htmlPop = null;
var blocker = null;
var openHTMLpop = function(strURL, intWidth, intHeight, strPopTitle) {
    // calculate the center of the page
    var yPos = 30;
    var xPos = ($(window).width() - intWidth)/2;
    htmlPop = $('#htmlPop');
    blocker = $('#blocker');
    var htmlPopFrame = $('iframe#htmlPopFrame');
    if (htmlPop.length > 0 && blocker.length > 0) {
        if (htmlPopFrame.length) {
            htmlPopFrame[0].src = strURL;
        } else {
            $('#htmlPopContainer').html(strURL);
        }
        $('#htmlPopTitle', htmlPop).text(strPopTitle);
        htmlPop.css({'left': xPos+'px', 'width': intWidth+'px'}).fadeIn();
        blocker.fadeIn();
    } else {
        // set pop content
        var popContent = '<iframe id="htmlPopFrame" src="' + strURL + '" frameborder="0"></iframe>';
        // if the 5th argument is set then it is straight content not URL
        if (arguments[4] != undefined) { popContent = strURL; }
        // append content to pop window
        var toAdded = $('<div id="blocker"></div>'
            + '<div id="htmlPop">'
            + '<div id="htmlPopTitle" style="float: left; width: 70%">' + strPopTitle + '</div>'
            + '<div style="float: right; width: 20%; text-align: right;">'
            + '<a href="#" id="closePop" style="color: red; font-weight: bold;">Close</a>'
            + '</div>'
            + '<div id="htmlPopContainer">' + popContent + '</div>'
            + '</div>').hide().appendTo('body');
        htmlPopFrame = $('iframe#htmlPopFrame');
        htmlPop = $('#htmlPop').css({'position': 'fixed', 'top': yPos+'px', 'left': xPos+'px', 'margin': 'auto', 'width': intWidth+'px', 'z-index': 99}).fadeIn();
        blocker = $('#blocker').css({'top': 0, 'left': 0, 'width': '100%', 'height': screen.height+'px', 'position': 'fixed', 'background-color': '#000', 'opacity': 0.5, 'z-index': 98}).fadeIn();
    }
    if (htmlPopFrame.length) { htmlPopFrame.css({'width': '100%', 'height': intHeight+'px'}); }
    // register ESC button event handler
    $('#closePop').click(function(evt) { evt.preventDefault(); closeHTMLpop(); });
}

var closeHTMLpop = function() { htmlPop.fadeOut(); blocker.fadeOut(); }

/* set iframe content */
var setIframeContent = function(strIframeID, strUrl) {
    var iframeObj = $('#'+strIframeID);
    if (iframeObj.length > 0) { iframeObj[0].src = strUrl; }
    return iframeObj;
}

/* hide table rows */
var hiddenTables = new Array();
var hideRows = function(str_table_id, int_start_row) {
    var rows = $('#'+str_table_id).find('.divRow');
    var skip = 0;
    rows.each(function() {
        if (skip < int_start_row) {
            skip++; return;
        } else {
            $(this).css('display','none');
        }
    });
    // add table id to hidden table array
    hiddenTables.push(str_table_id);
}

/* show table rows */
var showRows = function(str_table_id) {
    $('#'+str_table_id).find('.divRow').slideDown();
}

/* toogle show/hide table rows */
var showHideTableRows = function(str_table_id, int_start_row, obj_button, str_hide_text, str_show_text) {
    obj_button = $(obj_button);
    if (obj_button.hasClass('hideButton')) {
        hideRows(str_table_id, int_start_row);
        obj_button.removeClass('hideButton').val(str_hide_text);
    } else {
        showRows(str_table_id);
        obj_button.addClass('hideButton').val(str_show_text);
    }
}

/**
 * Register all events
 */
$('document').ready(function() {
    // register submenu event
    $('.subMenuItem').click(function(evt) {
        evt.preventDefault();
        // remove other menu class
        $('.subMenuItem').removeClass('curModuleLink');
        var subMenu = $(this).addClass('curModuleLink');
        var subMenuHREF = subMenu.attr('href');
        $('#mainContent').simbioAJAX(subMenuHREF, {method: 'get'});
    });

    // Register admin event for AJAX event
    $('#mainContent,#pageContent').bind('simbioAJAXloaded', function(evt) {
        $(this).registerAdminEvents({ajaxifyLink: true, ajaxifyForm: true});
        // report filter
        $('#filterForm').children('.divRow:gt(0)').wrapAll('<div class="hiddenFilter"></div>');
        var hiddenFilter = $('.hiddenFilter').hide();
        $('[name=moreFilter]').toggle(function() { hiddenFilter.fadeIn(); }, function() { hiddenFilter.hide(); });
    });

    // disable form with class "disabled"
    $('form.disabled').disableForm();
    $(document).registerAdminEvents({ajaxifyLink: false, ajaxifyForm: false});
});
