<?php
/**
 * Collection general report
 * Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

/* Reporting section */

if (!defined('SENAYAN_BASE_DIR')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
}

require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';

// privileges checking
$can_read = utility::havePrivilege('reporting', 'r');
$can_write = utility::havePrivilege('reporting', 'w');

if (!$can_read) {
    die('<div class="errorBox">'._('You don\'t have enough privileges to access this area!').'</div>');
}

/* collection statistic */
$table = new simbio_table();
$table->table_attr = 'align="center" class="border" cellpadding="5" cellspacing="0"';

// total number of titles
$stat_query = $dbs->query('SELECT COUNT(biblio_id) FROM biblio');
$stat_data = $stat_query->fetch_row();
$collection_stat[_('Total Titles')] = $stat_data[0];

// total number of items
$stat_query = $dbs->query('SELECT COUNT(item_id) FROM item');
$stat_data = $stat_query->fetch_row();
$collection_stat[_('Total Items/Copies')] = $stat_data[0];

// total number of checkout items
$stat_query = $dbs->query('SELECT COUNT(item_id) FROM item AS i
    LEFT JOIN loan AS l ON i.item_code=l.item_code
    WHERE is_lent=1 AND is_return=0');
$stat_data = $stat_query->fetch_row();
$collection_stat[_('Total Checkout Items')] = $stat_data[0];

// total number of items in library
$collection_stat[_('Total Items In Library')] = $collection_stat[_('Total Items/Copies')]-$collection_stat[_('Total Checkout Items')];

// total titles by GMD/medium
$stat_query = $dbs->query('SELECT gmd_name, COUNT(biblio_id) AS total_titles
    FROM `biblio` AS b
    INNER JOIN mst_gmd AS gmd ON b.gmd_id = gmd.gmd_id
    GROUP BY b.gmd_id HAVING total_titles>0 ORDER BY COUNT(biblio_id) DESC');
$stat_data = '';
while ($data = $stat_query->fetch_row()) {
    $stat_data .= '<strong>'.$data[0].'</strong> : '.$data[1];
    $stat_data .= ', ';
}
$collection_stat[_('Total Titles By Medium/GMD')] = $stat_data;

// total items by Collection Type
$stat_query = $dbs->query('SELECT coll_type_name, COUNT(item_id) AS total_items
    FROM `item` AS i
    INNER JOIN mst_coll_type AS ct ON i.coll_type_id = ct.coll_type_id
    GROUP BY i.coll_type_id
    HAVING total_items >0
    ORDER BY COUNT(item_id) DESC');
$stat_data = '';
while ($data = $stat_query->fetch_row()) {
    $stat_data .= '<strong>'.$data[0].'</strong> : '.$data[1];
    $stat_data .= ', ';
}
$collection_stat[_('Total Items By Collection Type')] = $stat_data;

// popular titles
$stat_query = $dbs->query('SELECT b.title,l.item_code,COUNT(l.loan_id) AS total_loans FROM `loan` AS l
    LEFT JOIN item AS i ON l.item_code=i.item_code
    LEFT JOIN biblio AS b ON i.biblio_id=b.biblio_id
    GROUP BY l.item_code ORDER BY COUNT(l.loan_id) DESC LIMIT 10');
$stat_data = '<ul>';
while ($data = $stat_query->fetch_row()) {
    $stat_data .= '<li>'.$data[0].'</li>';
}
$stat_data .= '</ul>';
$collection_stat[_('10 Most Popular Titles')] = $stat_data;

// table header
$table->setHeader(array(_('Collection Statistic Summary')));
$table->table_header_attr = 'class="dataListHeader" colspan="3"';
// initial row count
$row = 1;
foreach ($collection_stat as $headings=>$stat_data) {
    $table->appendTableRow(array($headings, ':', $stat_data));
    // set cell attribute
    $table->setCellAttr($row, 0, 'class="alterCell" valign="top" style="width: 170px;"');
    $table->setCellAttr($row, 1, 'class="alterCell" valign="top" style="width: 1%;"');
    $table->setCellAttr($row, 2, 'class="alterCell2" valign="top" style="width: auto;"');
    // add row count
    $row++;
}

// if we are in print mode
if (isset($_GET['print'])) {
    // html strings
    $html_str = '<html><head><title>'.$sysconf['library_name'].' Membership General Statistic Report</title>';
    $html_str .= '<style type="text/css">'."\n";
    $html_str .= 'body {padding: 0.2cm}'."\n";
    $html_str .= 'body * {color: black; font-size: 11pt;}'."\n";
    $html_str .= 'table {border: 1px solid #000000;}'."\n";
    $html_str .= '.dataListHeader {background-color: #000000; color: white; font-weight: bold;}'."\n";
    $html_str .= '.alterCell {border-bottom: 1px solid #666666; background-color: #CCCCCC;}'."\n";
    $html_str .= '.alterCell2 {border-bottom: 1px solid #666666; background-color: #FFFFFF;}'."\n";
    $html_str .= '</style>'."\n";
    $html_str .= '</head>';
    $html_str .= '<body>'."\n";
    $html_str .= '<h3>'.$sysconf['library_name'].' - '._('Collection Statistic Report').'</h3>';
    $html_str .= '<hr size="1" />';
    $html_str .= $table->printTable();
    $html_str .= '<script type="text/javascript">self.print();</script>'."\n";
    $html_str .= '</body></html>';
    // write to file
    $file_write = @file_put_contents(REPORT_FILE_BASE_DIR.'biblio_stat_print_result.html', $html_str);
    if ($file_write) {
        // open result in new window
        echo '<script type="text/javascript">parent.openWin(\''.SENAYAN_WEB_ROOT_DIR.'/'.FILES_DIR.'/'.REPORT_DIR.'/biblio_stat_print_result.html\', \'popMemberReport\', 800, 500, true)</script>';
    } else { utility::jsAlert('ERROR! Loan statistic report failed to generate, possibly because '.REPORT_FILE_BASE_DIR.' directory is not writable'); }
    exit();
}

?>
<fieldset class="menuBox">
<div class="menuBoxInner statisticIcon">
    <?php echo strtoupper(_('Collection Statistic')); ?>
    <hr />
    <form name="printForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="submitPrint" id="printForm" id="printForm" method="get" style="display: inline;">
    <input type="hidden" name="print" value="true" /><input type="submit" value="<?php echo _('Download Report'); ?>" class="button" />
    </form>
    <iframe name="submitPrint" style="visibility: hidden; width: 0; height: 0;"></iframe>
</div>
</fieldset>
<?php
echo $table->printTable();
/* collection statistic end */
?>
