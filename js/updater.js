/**
* Arie Nugraha 2009
* this file need prototype. js
* library to works
*
* AJAX related functions
*/

var lastAJAXcontainer = 'mainContent';
var ajaxURLhistory = new Array();
var urlNum = 0;
var loadingImage = './admin_template/default/loader.gif';
var defaultAJAXurl = '';

/* set the content of layer */
var setContent = function(strContainer, strURL, strMethod)
{
    // fill the lastAJAXcontainer global var
    lastAJAXcontainer = strContainer;
    // fill the lastAJAXurl global var
    ajaxURLhistory[urlNum] = strURL
    urlNum++;

    var ajaxParams = '';
    var isEvalScript = false;
    if (arguments[3] != undefined) {
        ajaxParams = arguments[3];
    }

    if (arguments[4] != undefined) {
        isEvalScript = arguments[4];
    } else { isEvalScript = true; }

    // escape single quotes chars
    strURL = strURL.sub('\'', '\\\'');

    // show loading
    showLoading();
    var ajaxObj = new Ajax.Updater(
        strContainer,
        strURL,
        {
            method: strMethod,
            parameters: ajaxParams,
            evalScripts: isEvalScript,
            onFailure: errorReport,
            onComplete: hideLoading
        });
}

/* show error when ajax updater failed */
var errorReport = function(ajaxObj)
{
    alert('Error on AJAX request');
}

/* show loading when ajax updater is in middle of requesting */
var showLoading = function()
{
    var blocker = $('blocker');
    if (!blocker) {
        $(document.body).insert('<div id="blocker"></div>');
        blocker = $('blocker');
    }
    blocker.setStyle({top: 0, left: 0, width: '100%', height: screen.height+'px', position: 'fixed'});
    $$('.loader').invoke('addClassName', 'loadingImage').invoke('update', 'LOADING CONTENT... PLEASE WAIT');
}

/* hide loading when ajax updater complete the request */
var hideLoading = function(ajaxObj)
{
    $('blocker').remove();
    $$('.loader').invoke('removeClassName', 'loadingImage').invoke('update', lastStr);
}

/* get previous AJAX url */
var getPreviousAJAXurl = function()
{
    if (urlNum > 1) {
        return ajaxURLhistory[urlNum-2];
    } else {
        ajaxURLhistory[0] = defaultAJAXurl;
        return defaultAJAXurl;
    }
}

/* get latest AJAX url */
var getLatestAJAXurl = function()
{
    if (urlNum > 0) {
        return ajaxURLhistory[urlNum-1];
    } else {
        return defaultAJAXurl;
    }
}
