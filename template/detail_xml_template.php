<?php

// key to authenticate
if (!defined('INDEX_AUTH')) {
    define('INDEX_AUTH', '1');
}

// XML detail template
// output the buffer
ob_start();
?>
<record>
<ID>{biblio_id}</ID>
<title>{title}</title>
<edition>{edition}</edition>
<specific_detail_info>{spec_detail_info}</specific_detail_info>
<classification>{classification}</classification>
<call_number>{call_number}</call_number>
<isbn_issn>{isbn_issn}</isbn_issn>
<authors>{authors}</authors>
<subjects>{subjects}</subjects>
<series>{series_title}</series>
<medium>{gmd_name}</medium>
<collection_type>{coll_type_name}</collection_type>
<language>{language_name}</language>
<publication>
    <publisher>{publisher_name}</publisher>
    <publish_year>{publish_year}</publish_year>
    <publish_place>{publish_place}</publish_place>
</publication>
<collation>{collation}</collation>
<abstract_notes>{notes}</abstract_notes>
<item_location>{location}</item_location>
</record>
<?php
// put the buffer to template var
$detail_template = ob_get_clean();
?>
