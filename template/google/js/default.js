//      default.js
//      
//      Copyright 2011 Indra Sutriadi Pipii <indra@sutriadi.web.id>
//      

$(document).ready(function() {
	var cacheSubject = {},
			lastXhr;
	var cacheAuthor = {},
			lastXhr;
	var cacheKey = {},
			lastXhr;

	$( "#keywords" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var suggest = new Array();
			var term = request.term;
			if ( term in cacheKey ) {
				if(cacheKey[ term ].length > 0)
					response( cacheKey[ term ] );
				return;
			}
			lastXhr = $.ajax({
				url: "lib/contents/advsearch_AJAX_response.php",
				type: "POST",
				data: "type=topic&inputSearchVal="+escape(term),
				success: function( data, status, xhr ) {
					var data = eval(data);
					if(data){
						cacheSubject[ term ] = data;
						suggest = $.merge(suggest, cacheSubject[ term ]);
					}
				},
			});
			lastXhr = $.ajax({
				url: "lib/contents/advsearch_AJAX_response.php",
				type: "POST",
				data: "type=author&inputSearchVal="+escape(term),
				success: function( data, status, xhr ) {
					var data = eval(data);
					if(data){
						cacheAuthor[ term ] = data;
						suggest = $.merge(suggest, cacheAuthor[ term ]);
					}
				},
			});
			if(suggest){
				cacheKey[ term ] = suggest;
			}
			response(suggest);
		}
	});

	$( "#subject" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cacheSubject ) {
				response( cacheSubject[ term ] );
				return;
			}
			lastXhr = $.ajax({
				url: "lib/contents/advsearch_AJAX_response.php",
				type: "POST",
				data: "type=topic&inputSearchVal="+escape(term),
				success: function( data, status, xhr ) {
					var data = eval(data);
					cacheSubject[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				},
			});
		},
	});

	$( "#author" ).autocomplete({
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cacheAuthor ) {
				response( cacheAuthor[ term ] );
				return;
			}
			lastXhr = $.ajax({
				url: "lib/contents/advsearch_AJAX_response.php",
				type: "POST",
				data: "type=author&inputSearchVal="+escape(term),
				success: function( data, status, xhr ) {
					var data = eval(data);
					cacheAuthor[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				},
			});
		},
	});

	$( "#fileviewer" ).dialog({
		autoOpen: false,
		modal: true,
		close: function(event, ui) {
			$( "#framehtml" ).attr('src', '');
		}
	});

	$( "a[href='#']" ).attr('href', '#refviewer');

	$( "#keywords" ).focus();
	$( "input[name=memberID]" ).focus();

});

function show_advanced() {
	window.location="index.php?view=advanced";
}

function change_lang(t) {
	var f=t.form;
	f.method="POST";
	f.action=f.action+"?dest="+encodeURIComponent(document.URL)+"&select_lang="+t.value;
	f.submit();
}

function openHTMLpop(url, w, h, title) {
	$( "#framehtml" ).removeAttr('src');
	$( "#framehtml" ).attr('src', url);
	$( "#fileviewer" ).dialog( "option", "title", title );
	$( "#fileviewer" ).dialog( "option", "height", h+70 );
	$( "#fileviewer" ).dialog( "option", "width", w+40 );
	$( "#fileviewer" ).dialog( "open" );
	return false;
}
