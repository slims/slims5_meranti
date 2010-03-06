<?php
/**
 * Copyright (C) 2010  Arie Nugraha (dicarve@yahoo.com)
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

/* Authority List */

// main system configuration
require '../../../ucsysconfig.inc.php';
// start the session
require UCS_BASE_DIR.'admin/default/session.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

// page title
$page_title = 'Authority List';
// get id from url
$biblioID = 0;
if (isset($_GET['biblioID']) AND !empty($_GET['biblioID'])) {
    $biblioID = (integer)$_GET['biblioID'];
}

// start the output buffer
ob_start();
?>
<script type="text/javascript">
function confirmProcess(int_biblio_id, int_item_id)
{
    var confirmBox = confirm('Are you sure to remove selected author?' + "\n" + 'Once deleted, it can\'t be restored!');
    if (confirmBox) {
        // set hidden element value
        document.hiddenActionForm.bid.value = int_biblio_id;
        document.hiddenActionForm.remove.value = int_item_id;
        // submit form
        document.hiddenActionForm.submit();
    }
}
</script>
<?php
/* main content */
// author of removal
if (isset($_GET['removesess'])) {
    $idx = $_GET['removesess'];
    unset($_SESSION['biblioAuthor'][$idx]);
    echo '<script type="text/javascript">';
    echo 'alert(\''.__('Author succesfully removed!').'\');';
    echo 'location.href = \'iframe_author.php\';';
    echo '</script>';
}

if (isset($_POST['remove'])) {
    $id = (integer)$_POST['remove'];
    $bid = (integer)$_POST['bid'];
    $sql_op = new simbio_dbop($dbs);
    $sql_op->delete('biblio_author', 'author_id='.$id.' AND biblio_id='.$bid);
    echo '<script type="text/javascript">';
    echo 'alert(\''.__('Author removed!').'\');';
    echo 'location.href = \'iframe_author.php?biblioID='.$bid.'\';';
    echo '</script>';
}

// if biblio ID is set
if ($biblioID) {
    $table = new simbio_table();
    $table->table_attr = 'align="center" style="width: 100%;" cellpadding="2" cellspacing="0"';

    // database list
    $biblio_author_q = $dbs->query("SELECT ba.*, a.author_name FROM biblio_author AS ba
        LEFT JOIN mst_author AS a ON ba.author_id=a.author_id
        WHERE ba.biblio_id=$biblioID ORDER BY level ASC");

    $row = 1;
    while ($biblio_author_d = $biblio_author_q->fetch_assoc()) {
        // alternate the row color
        $row_class = ($row%2 == 0)?'alterCell':'alterCell2';

        // remove link
        $remove_link = '<a href="#" onclick="confirmProcess('.$biblioID.', '.$biblio_author_d['author_id'].')"
            style="color: #FF0000; text-decoration: underline;">Delete</a>';
        $author = $biblio_author_d['author_name'];

        $table->appendTableRow(array($remove_link, $author, $sysconf['authority_level'][$biblio_author_d['level']]));
        $table->setCellAttr($row, 0, 'valign="top" class="'.$row_class.'" style="font-weight: bold; width: 10%;"');
        $table->setCellAttr($row, 1, 'valign="top" class="'.$row_class.'" style="font-weight: bold; width: 70%;"');
        $table->setCellAttr($row, 2, 'valign="top" class="'.$row_class.'" style="width: 20%;"');
        $row++;
    }

    echo $table->printTable();
    // hidden form
    echo '<form name="hiddenActionForm" method="post" action="'.$_SERVER['PHP_SELF'].'"><input type="hidden" name="bid" value="0" /><input type="hidden" name="remove" value="0" /></form>';
} else {
    if ($_SESSION['biblioAuthor']) {
        $table = new simbio_table();
        $table->table_attr = 'align="center" style="width: 100%;" cellpadding="2" cellspacing="0"';

        $row = 1;
        $row_class = 'alterCell2';
        foreach ($_SESSION['biblioAuthor'] as $biblio_session) {
            // remove link
            $remove_link = '<a href="iframe_author.php?removesess='.$biblio_session[0].'"
                style="color: #000000; text-decoration: underline;">Remove</a>';

            if ($biblio_session) {
                $author_q = $dbs->query("SELECT author_name FROM mst_author
                    WHERE author_id=".$biblio_session[0]);
                $author_d = $author_q->fetch_row();
                $author = $author_d[0];
            }

            $table->appendTableRow(array($remove_link, $author, $sysconf['authority_level'][$biblio_session[1]]));
            $table->setCellAttr($row, 0, 'valign="top" class="'.$row_class.'" style="font-weight: bold; background-color: #ffc466; width: 10%;"');
            $table->setCellAttr($row, 1, 'valign="top" class="'.$row_class.'" style="background-color: #ffc466; width: 70%;"');
            $table->setCellAttr($row, 2, 'valign="top" class="'.$row_class.'" style="background-color: #ffc466; width: 20%;"');

            $row++;
        }

        echo $table->printTable();
    }
}
/* main content end */
$content = ob_get_clean();
// include the page template
require UCS_BASE_DIR.'/admin/admin_themes/notemplate_page_tpl.php';
?>
