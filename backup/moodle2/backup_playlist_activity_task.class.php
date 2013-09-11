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

    require_once($CFG->dirroot . '/mod/playlist/backup/moodle2/backup_playlist_stepslib.php');



    class backup_playlist_activity_task extends backup_activity_task
    {


        /**
         * Defines activity specific settings to be added to the common ones
         *
         * This method is called from {@link self::define_settings()}. The activity module
         * author may use it to define additional settings that influence the execution of
         * the backup.
         *
         * Most activities just leave the method empty.
         *
         * @see self::define_settings() for the example how to define own settings
         */
        protected function define_my_settings()
        {
        }



        /**
         * Defines activity specific steps for this task
         *
         * This method is called from {@link self::build()}. Activities are supposed
         * to call {self::add_step()} in it to include their specific steps in the
         * backup plan.
         */
        protected function define_my_steps()
        {
            $this->add_step(new backup_playlist_activity_structure_step('playlist_structure', 'playlist.xml'));
        }



        /**
         * Encodes URLs to the activity instance's scripts into a site-independent form
         *
         * The current instance of the activity may be referenced from other places in
         * the course by URLs like http://my.moodle.site/mod/workshop/view.php?id=42
         * Obvisouly, such URLs are not valid any more once the course is restored elsewhere.
         * For this reason the backup file does not store the original URLs but encodes them
         * into a transportable form. During the restore, the reverse process is applied and
         * the encoded URLs are replaced with the new ones valid for the target site.
         *
         * Every plugin must override this method in its subclass.
         *
         * @see backup_xml_transformer class that actually runs the transformation
         * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
         * @return string the content with the URLs encoded
         */
        static public function encode_content_links($content)
        {
            return $content;
        }

    }
