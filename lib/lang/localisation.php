<?php
/**
 * Purpose of	this file
 * 1.	Add	support	for	gettext, even	if the php extension is	not	
 *		available	(with	php-gettext)
 * 2.	Supply an	array	that lists all available translations	(main
 *		purpose	is to	use	it for creating	html selects to	change language)
 * 
 * TODO:	Maybe	change $available_languages	to just	list the native	
 *				language name	(well, useres	should be	able to	find their own
 *				language,	shouldn't	they?) :)
 * NOTE:	The	gettext	library	might be used, if	it is	available.
 *				The	problem	is that	mo files are cached	by the extension,	so a
 *				server restart is	necessary	if these files are updated (e.g. by	 
 *				a	senayan	update). I replaced all _('') with	__(''), so 
 *				php-gettext is always used, thus circumventing	this problem.	
 *				Obviously	there	is no	real speed disadvantage, since this	is the  
 *				way wordpress	does it. 
 *				Developers should use __('') and _ngettext in code!
 */
require_once(LANGUAGES_BASE_DIR.'php-gettext'.DIRECTORY_SEPARATOR.'gettext.inc');

// gettext setup
$locale = $sysconf['default_lang'];
$domain = 'messages';
$encoding = 'UTF-8';
T_setlocale(LC_ALL, $locale);
bindtextdomain($domain, LANGUAGES_BASE_DIR.'locale');
if (function_exists('bind_textdomain_codeset')) {
  bind_textdomain_codeset($domain, $encoding);
 }
textdomain($domain);


// Array with available translations
//$available_languages[] = array('CODE', _('ENGLISH NAME'), 'NATIVE NAME');
$available_languages[] = array('de_DE', _('German'), 'Deutsch');
$available_languages[] = array('en_US', _('English'), 'English');
$available_languages[] = array('id_ID', _('Indonesian'), 'Indonesia');
?>