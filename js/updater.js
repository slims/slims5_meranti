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

/* register event after each AJAX call */
Element.addMethods({
    registerAJAXEvents: function(element) {
        // change all anchor to AJAX behaviour
        element.select('a:not(.notAJAX)').invoke('observe', 'click', function(evt) {
            evt.preventDefault();
            var anchor = Event.element(evt);
            var aHREF = anchor.readAttribute('href');
            // check where to load AJAX content from loadcontainer attribute
            var ajaxContainer = anchor.readAttribute('loadcontainer');
            if (!ajaxContainer) { ajaxContainer = 'mainContent'; }
            // check if link have postdata attribute
            var postData = anchor.readAttribute('postdata');
            if (postData) {
                setContent(ajaxContainer, aHREF, 'post', postData);
            } else {
                setContent(ajaxContainer, aHREF, 'get');
            }
        });

        // change all search form submit behaviour to AJAX
        element.select('.editFormLink').invoke('observe', 'click', function(evt) {
            evt.stop();
            var button = Event.element(evt);
            var theForm = button.up('form');
            theForm.enable();
        });

        // change all search form submit behaviour to AJAX
        element.select('.menuBox form:not(.notAJAX)').invoke('observe', 'submit', function(evt) {
            evt.preventDefault();
            var theForm = Event.element(evt);
            var formAction = theForm.readAttribute('action');
            var formMethod = theForm.readAttribute('method');
            var formData = theForm.serialize();
            setContent('mainContent', formAction, formMethod, formData);
        });

        return element;
    }
});

/* set the content of layer */
var setContent = function(strContainer, strURL, strMethod) {
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
        {success: strContainer},
        strURL,
        {
            asynchronous: false,
            method: strMethod,
            parameters: ajaxParams,
            evalScripts: isEvalScript,
            onFailure: errorReport,
            onComplete: hideLoading,
            requestHeaders: {'Pragma': 'no-cache',
                'Cache-Control': 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
                'Expires': 'Sat, 26 Jul 1997 05:00:00 GMT'}
        });
}

/* show error when ajax updater failed */
var errorReport = function(ajaxObj) {
    alert('Error on AJAX request! Probably page you requested not found on server.');
}

/* show loading when ajax updater is in middle of requesting */
var showLoading = function() {
    $$('.loader').invoke('addClassName', 'loadingImage').invoke('update', 'LOADING CONTENT... PLEASE WAIT');
}

/* hide loading when ajax updater complete the request */
var hideLoading = function(ajaxObj) {
    var loaders = $$('.loader');
    if (loaders.length > 0) { loaders.invoke('removeClassName', 'loadingImage').invoke('update', lastStr); }
    // focus all first form input element
    var inputEl = $$('input[type=text]'); if (inputEl.length > 0) {inputEl[0].focus();}
    $(lastAJAXcontainer).registerAJAXEvents();
}

/* get previous AJAX url */
var getPreviousAJAXurl = function() {
    if (urlNum > 1) {
        return ajaxURLhistory[urlNum-2];
    } else {
        ajaxURLhistory[0] = defaultAJAXurl;
        return defaultAJAXurl;
    }
}

/* get latest AJAX url */
var getLatestAJAXurl = function() {
    if (urlNum > 0) {
        return ajaxURLhistory[urlNum-1];
    } else {
        return defaultAJAXurl;
    }
}

/* invoke UCS upload catalog */
var ucsUpload = function(strUploadHandler, strData) {
    var confUpload = false;
    if (strData.strip()) {
        confUpload = confirm('Are you sure to upload selected data to Union Catalog Server?');
    } else {
        alert('Please select bibliographic data to upload!');
        return;
    }
    if (!confUpload) {
        return;
    }
    var ajaxJSON = new Ajax.Request(strUploadHandler, {
        method: 'post',
        parameters: strData,
        onSuccess: function(ajaxTransport) {
                // get AJAX response text
                var respText = ajaxTransport.responseText.strip();
                // debugging purpose only
                // alert(respText);
                // evaluate json
                var jsonObj = respText.evalJSON();
                // alert(jsonObj.status + ': ' + jsonObj.message);
                alert(jsonObj.message);
            },
        onFailure: function() {
            alert('UCS Upload error!');
            }
        });
}

/* invoke UCS record update */
var ucsUpdate = function(strURLHandler, strData) {
    strData = strData.strip();
    var ajaxJSON = new Ajax.Request(strURLHandler, {
        method: 'post',
        parameters: strData,
            onSuccess: function(ajaxTransport) {
            // get AJAX response text
            // var respText = ajaxTransport.responseText.strip();
            // debugging purpose only
            // alert(respText);
            }
        });
}
