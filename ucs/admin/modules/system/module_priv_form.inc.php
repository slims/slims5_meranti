<?php
/**
 *
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

// start the output buffer
ob_start();
$table = new simbio_table();
$table->table_attr = 'align="center" class="detailTable" style="width: 100%;" cellpadding="2" cellspacing="0"';
$table->setHeader(array(__('Module Name'), __('Read'), __('Write')));
$table->table_header_attr = 'class="dataListHeader" style="font-weight: bold;"';

// initial row count
$row = 1;
$row_class = 'alterCell2';

// database list
$module_query = $dbs->query("SELECT * FROM mst_module AS m");
while ($module_data = $module_query->fetch_assoc()) {
    // alternate the row color
    if ($row_class == 'alterCell2') {
        $row_class = 'alterCell';
    } else {
        $row_class = 'alterCell2';
    }

    $read_checked = '';
    $write_checked = '';

    if (isset($priv_data[$module_data['module_id']]['r']) AND $priv_data[$module_data['module_id']]['r'] == 1) {
        $read_checked = 'checked';
    }

    if (isset($priv_data[$module_data['module_id']]['w']) AND $priv_data[$module_data['module_id']]['w'] == 1) {
        $read_checked = 'checked';
        $write_checked = 'checked';
    }

    $chbox_read = '<input type="checkbox" name="read[]" value="'.$module_data['module_id'].'" '.$read_checked.' />';
    $chbox_write = '<input type="checkbox" name="write[]" value="'.$module_data['module_id'].'" '.$write_checked.' />';

    $table->appendTableRow(array(__( ucwords(str_replace('_', ' ', $module_data['module_name'])) ), $chbox_read, $chbox_write));
    $table->setCellAttr($row, 0, 'valign="top" class="'.$row_class.'" style="font-weight: bold;"');
    $table->setCellAttr($row, 1, 'valign="top" class="'.$row_class.'" style="width: 5%;"');
    $table->setCellAttr($row, 2, 'valign="top" class="'.$row_class.'" style="width: 5%;"');

    $row++;
}

echo $table->printTable();
$priv_table = ob_get_clean();
?>
