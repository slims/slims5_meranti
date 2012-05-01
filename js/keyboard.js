/**
 * 
 * Keyboard Shortkey
 * 
 * Require : jQuery library
 * 
 * by Indra Sutriadi Pipii 2012
 * 
 */

var slims_hotkey=false;

$(function() {}).keypress(function(event) {
	/*
	 * global hotkey for navigation module's menu and submodule's menu
	 */
	// hotkey for module's menu (Shift+F[1-12])
	if(event.shiftKey && event.keyCode){
		mlength=$('div#mainMenu ul#menuList li a').length-1;
		index=event.keyCode-110;
		if(index>=2 && index<mlength)
			window.location=$('div#mainMenu ul#menuList li a').eq(event.keyCode - 110).attr('href');
		else if(event.keyCode == 36)
			window.location=$('div#mainMenu ul#menuList li a:first').attr('href');
		else if(event.keyCode == 27)
			window.location=$('div#mainMenu ul#menuList li a:last').attr('href');
		return false;
	}
	// hotkey for submodule's menu (Ctrl+[0-9] until Ctrl+Alt[0-9])
	else if(event.ctrlKey && event.which){
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
	/*
	 * SLiMS special hotkey for specific purpose
	 */
	// toggle both enable or disable SLiMS special hotkey
	if(event.ctrlKey && event.which==109 && !event.altKey && !event.shiftKey){
		slims_hotkey=true;
		alert('SLiMS hotkey activated!');
		return false;
	}else if(event.ctrlKey && event.shiftKey && event.which==77 && !event.altKey){
		slims_hotkey=false;
		alert('SLiMS hotkey disabled!');
		return false;
	}
	if(slims_hotkey===true){
		// navigation paging list
		if($('table.datagrid-action-bar span.pagingList a').length>0){
			switch(event.keyCode){
				case 39: //next
					$('table.datagrid-action-bar span.pagingList a.next_link:first').click();
					break;
				case 37: //prev
					$('table.datagrid-action-bar span.pagingList a.prev_link:first').click();
					break;
				case 36: //first
					$('table.datagrid-action-bar span.pagingList a.first_link:first').click();
					break;
				case 35: //last
					$('table.datagrid-action-bar span.pagingList a.last_link:first').click();
					break;
			}
		}
		// select all data from list
		if(event.ctrlKey && event.which==97 && !event.altKey && !event.shiftKey){
			$('table#dataList :checkbox').click();
		}
	}
}).keydown(function(event) { // show up hotkeys tip
	$('span.keytip').remove();
	if(event.ctrlKey || event.altKey && !event.shiftKey && !event.which){
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
	}else if(event.shiftKey && !event.ctrlKey && !event.altKey){
		$('div#mainMenu ul#menuList li a:first').append('<span class="keytip" style="border: none; padding:0; margin: 0; font-weight: bold; position: relative; left: -50px;">&uArr;+Home</span>');
		$('div#mainMenu ul#menuList li a:last').append('<span class="keytip" style="border: none; padding:0; margin: 0; font-weight: bold; position: relative; left: -50px;">&uArr;+Esc</span>');
		for(n=2;n<=$('div#mainMenu ul#menuList li a').length - 2;n++){
			$('div#mainMenu ul#menuList li a').eq(n).append('<span class="keytip" style="border: none; padding:0; margin: 0; font-weight: bold; position: relative; left: -50px;">&uArr;+F'+eval(n-1)+'</span>');
		}
	}
}).keyup(function(event) { // hide hotkeys tip
	if(event.ctrlKey || event.shiftKey){
		$('span.keytip').remove();
	}
});
