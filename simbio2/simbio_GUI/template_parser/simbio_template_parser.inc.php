<?php
/**
 * simbio_template_parser class
 * Simbio Template parser class for easy templating
 *
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

class simbio_template_parser
{
    private $file = ''; // variable to store template name info
    private $result = ''; // variable to store template result


    /**
     * Class Constructor
     *
     * @param   string  $tpl_file_path
     * @return  void
     */
    public function __construct($tpl_file_path)
    {
        // check if file exists
        if (!file_exists($tpl_file_path)) {
            die('Template file '.$tpl_file_path.' doesnt exists!');
        }

        // check if the template file is HTML or not
        if (substr($tpl_file_path, -5) != '.html') {
            die('Template file must be HTML file!');
        } else {
            $this->file = $tpl_file_path;
        }

        // reading template file and store it into result properties
        if ($tpl_str = file_get_contents($this->file)) {
            $this->result = $tpl_str;
        } else {
           die('<div style="border: 1px solid #FF0000; color: #FF0000;">Template file '.$this->file.' cant be opened!</div>');
        }
    }


    /**
     * Method assign content to template marker
     *
     * @param   string  $str_maker
     * @param   string  $str_replacement
     * @param   boolean $bool_show_error
     * @return  void
     */
    public function assign($str_maker, $str_replacement, $bool_show_error = false)
    {
        if (!preg_match("/".preg_quote($str_maker)."/i", $this->result)) {
            if ($bool_show_error) {
                $str_maker = str_ireplace(array('<!--','-->'), '', $str_maker);
                echo "Marker : <b>".htmlentities($str_maker)."</b> doesnt exist in ".$this->file;
            }
            return;
        }
        $this->result = str_ireplace($str_maker, $str_replacement, $this->result);
        // get any language constant
        preg_match_all('@<!--lang_[^>]+-->@', $this->result, $lang_const);
        if (count($lang_const[0]) > 0) {
            foreach ($lang_const[0] as $const_marker) {
                $const = trim(str_ireplace(array('<!--','-->'), '', $const_marker));
                if (defined($const)) {
                    $this->result = str_ireplace($const_marker, constant($const), $this->result);
                }
            }
        }
    }


    /**
     * Method to print out the template
     *
     * @return  void
     */
    public function printOut()
    {
        echo $this->result;
    }
}
?>
