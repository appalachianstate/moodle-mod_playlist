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

    defined('MOODLE_INTERNAL') || die();

    require_once($CFG->dirroot . '/mod/playlist/backup/moodle2/restore_playlist_stepslib.php');



    class restore_playlist_activity_task extends restore_activity_task
    {

        /**
         * Define (add) particular settings that each activity can have
         */
        protected function define_my_settings()
        {
        }



        /**
         * Define (add) particular steps this activity can have
         */
        protected function define_my_steps()
        {
            $this->add_step(new restore_playlist_activity_structure_step('playlist_structure', 'playlist.xml'));
        }



        /**
         * Define the contents in the activity that must be
         * processed by the link decoder
         */
        static public function define_decode_contents()
        {
            return array();
        }



        /**
         * Define the decoding rules for links belonging
         * to the activity to be executed by the link decoder
         */
        static public function define_decode_rules()
        {
            return array();
        }



        /**
         * Define the restore log rules that will be applied
         * by the {@link restore_logs_processor} when restoring
         * activity logs. It must return one array
         * of {@link restore_log_rule} objects
         */
        static public function define_restore_log_rules()
        {

            return array(
                new restore_log_rule('playlist', 'add',     'view.php?id={course_module}', '{playlist}'),
                new restore_log_rule('playlist', 'update',  'view.php?id={course_module}', '{playlist}'),
                new restore_log_rule('playlist', 'view',    'view.php?id={course_module}', '{playlist}')
            );

        }



        /**
         * Define the restore log rules that will be applied
         * by the {@link restore_logs_processor} when restoring
         * course logs. It must return one array
         * of {@link restore_log_rule} objects
         *
         * Note these rules are applied when restoring course logs
         * by the restore final task, but are defined here at
         * activity level. They are rules not linked to any module
         * instance (cmid = 0)
         */
        static public function define_restore_log_rules_for_course()
        {

            return array(
                new restore_log_rule('playlist', 'view all', 'index.php?id={course}', null)
            );

        }

    }
