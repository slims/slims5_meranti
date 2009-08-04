<?php
/**
 * Simbio CRUD Abstract class
 *
 * Copyright (C) 2009  Arie Nugraha (dicarve@yahoo.com)
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

abstract class simbio_CRUD
{
    protected $obj_db;
    protected $db_table;
    protected $fields = array();
    protected $ID_field;


    /**
     * Constructor
     *
     * @param   object  $obj_db : Database connection object
     *
     */
    public function __construct($obj_db) {
        $this->obj_db = $obj_db;
    }


    /**
     * Create record method
     *
     * @return  boolean
     */
    public function create() {

    }


    /**
     * Delete record method
     *
     * @param   mixed   $mix_ID : a scalar OR an array of criteria of record deletion
     * @return  boolean
     */
    public function delete($mix_ID) {

    }


    /**
     * Get record data by ID
     *
     * @param   mixed   $mix_ID_value : ID field value of record
     * @return  array
     */
    public function getByID($mix_ID_value) {

    }


    /**
     * Get List record data
     *
     * @param   array   $arr_criteria_value : an array of field = value pairs of criteria
     * @return  array
     */
    public function getList($arr_criteria_value) {

    }


    /**
     * Update record method
     *
     * @return  boolean
     */
    public function update() {

    }
}
?>
