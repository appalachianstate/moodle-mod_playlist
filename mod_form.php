<?php

    // This file is part of Moodle - http://moodle.org/
    //
    // Moodle is free software: you can redistribute it and/or modify
    // it under the terms of the GNU General Public License as published by
    // the Free Software Foundation, either version 3 of the License, or
    // (at your option) any later version.
    //
    // Moodle is distributed in the hope that it will be useful,
    // but WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    // GNU General Public License for more details.
    //
    // You should have received a copy of the GNU General Public License
    // along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

    /**
     *  Playlist resource plugin
     *
     *  This plugin provides a simple container for a list of URLs that
     *  can be referenced by the RTMP filter plugin
     *
     * @author      Fred Woolard <woolardfa@appstate.edu>
     * @copyright   (c) 2013 Appalachian State Universtiy, Boone, NC
     * @license     GNU General Public License version 3
     * @package     mod
     * @subpackage  playlist
     */

    defined('MOODLE_INTERNAL') || die;

    require_once ($CFG->dirroot . '/course/moodleform_mod.php');



    class mod_playlist_mod_form extends moodleform_mod
    {

        function definition()
        {

            $mform = $this->_form;

            $mform->addElement('header', 'generalhdr', get_string('general'));


            // name text box
            // -------------------------------------------------------------------------------
            $mform->addElement('text', 'name', get_string('name'), array('size'=>'50'));
            $mform->setType('name', PARAM_TEXT);
            $mform->addRule('name', get_string('required'), 'required', null, 'client');
            $mform->addRule('name', get_string('maximumchars', '', 50), 'maxlength', 50, 'client');


            // list editor textarea
            // -------------------------------------------------------------------------------
            $mform->addElement('textarea', 'list', get_string('list', 'mod_playlist'), array('rows' => 20, 'cols' => 75));
            $mform->setType('list', PARAM_TEXT);
            $mform->addRule('list', get_string('required'), 'required', null, 'client');
            $mform->addHelpButton('list', 'list', 'mod_playlist');


            // Common module elements
            // -------------------------------------------------------------------------------
            $this->standard_coursemodule_elements();
            // This resource does not normally display
            $mform->freeze('visible');


            // buttons
            // -------------------------------------------------------------------------------
            $this->add_action_buttons(true, false, null);

        }



        /**
         * (non-PHPdoc)
         * @see moodleform_mod::data_preprocessing()
         */
        function data_preprocessing(&$default_values)
        {

            parent::data_preprocessing($default_values);
            $default_values['visible'] = 0;

        }



        /**
         * (non-PHPdoc)
         * @see moodleform_mod::validation()
         */
        function validation($data, $files)
        {
            global $DB, $COURSE;


            // Basic validation
            $errors = parent::validation($data, $files);
            if ($errors) {
                return $errors;
            }

            // Try to validate the list of rtmp:// URLs

            $playlist_rec = $DB->get_record('playlist', array('name' => $data['name'], 'course' => $COURSE->id));
            if ($playlist_rec && (!empty($data['add']) || (!empty($data['update']) && $playlist_rec->id != $data['instance']))) {
                $errors['name'] = get_string('err_list_name_is_taken', 'mod_playlist');
                return $errors;
            }

            $list = array_map('trim', explode("\n", $data['list']));
            foreach ($list as $item) {
                if (empty($item)) continue;

                @list($url, $name) = array_map('trim', explode(',', $item));
                if (empty($url)) continue;

                if (!preg_match('/^rtmp:\/\//', $url)) {
                    $errors['list'] = get_string('err_list_url_invalid', 'mod_playlist');
                    return $errors;
                }

                // Substitute the rtmp scheme with http to allow
                // validation against everything else
                $url = str_replace(' ', '+', $url);
                $url = clean_param(preg_replace('/^rtmp:\/\//i', 'http://', $url, 1), PARAM_URL);
                if (empty($url)) {
                    $errors['list'] = get_string('err_list_url_invalid', 'mod_playlist');
                    return $errors;
                }

            } // foreach

            // Success
            return array();

        }

    }
