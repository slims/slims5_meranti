/**
 * 
 * Keyboard Shortkey
 * 
 * Require : jQuery library
 * 
 * by Indra Sutriadi Pipii 2012
 * 
 */

$(function() {}).keypress(function(event) {
	if(event.shiftKey && event.keyCode){
		if(event.keyCode - 110 != 10)
			window.location=$('div#mainMenu ul#menuList li a').eq(event.keyCode - 110).attr('href');
		if(event.keyCode == 36)
			window.location=$('div#mainMenu ul#menuList li a:first').attr('href');
		if(event.keyCode == 27)
			window.location=$('div#mainMenu ul#menuList li a:last').attr('href');
	}
	if(event.ctrlKey && event.which){
		slength=$('td#sidepan a').length;
		eWhich=event.which;
		if(!event.altKey){
			if(eWhich-49>=0 && eWhich-49<=9 && eWhich-49<=slength)
				$('td#sidepan a').eq(eWhich-49).click();
			if(eWhich-49==-1 && slength>=9)
				$('td#sidepan a').eq(9).click();
		}else{
			if(eWhich-49>=0 && eWhich-49<=9 && eWhich-39<=slength)
				$('td#sidepan a').eq(eWhich-39).click();
			if(eWhich-49==-1 && slength>=9)
				$('td#sidepan a').eq(19).click();
		}
	}
	return false;
}).keydown(function(event) {
	if(event.ctrlKey || event.shiftKey){
		for(n=0;n<=9;n++){
			x=n+1;
			if(x==10) x=0;
			$('td#sidepan a').eq(n).append('<span class="keytip" style="font-weight: bold; position: relative; top: -10px; padding: 10px;">Ctrl+'+x+'</span>');
		}
		for(n=0;n<=9;n++){
			x=n+1;
			if(x==10) x=0;
			$('td#sidepan a').eq(n+10).append('<span class="keytip" style="font-weight: bold; position: relative; top: -10px; padding: 10px;">Ctrl+Alt+'+x+'</span>');
		}
		$('div#mainMenu ul#menuList li a:first').append('<span class="keytip" style="border: none; padding:0; margin: 0; font-weight: bold; position: relative; left: -50px;">&uArr;+Home</span>');
		$('div#mainMenu ul#menuList li a:last').append('<span class="keytip" style="border: none; padding:0; margin: 0; font-weight: bold; position: relative; left: -50px;">&uArr;+Esc</span>');
		for(n=2;n<=$('div#mainMenu ul#menuList li a').length - 2;n++){
			$('div#mainMenu ul#menuList li a').eq(n).append('<span class="keytip" style="border: none; padding:0; margin: 0; font-weight: bold; position: relative; left: -50px;">&uArr;+F'+eval(n-1)+'</span>');
		}
	}
}).keyup(function(event) {
	if(event.ctrlKey || event.shiftKey){
		$('span.keytip').remove();
		$('var.keytip').remove();
	}
});
