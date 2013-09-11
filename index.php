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

    require('../../config.php');



    // View index of playlists for which course
    $id = required_param('id', PARAM_INT);
    // Authenticate and authorize
    require_login($id, true);


    add_to_log($COURSE->id, 'playlist', 'view all', "index.php?id={$COURSE->id}", '');


    $lbl_playlists = get_string('modulenameplural', 'mod_playlist');
    $lbl_name      = get_string('name');
    $lbl_intro     = get_string('moduleintro');


    $PAGE->set_pagelayout('incourse');
    $PAGE->set_url('/mod/playlist/index.php', array('id' => $COURSE->id));
    $PAGE->set_title("{$COURSE->shortname}: {$lbl_playlists}");
    $PAGE->set_heading($COURSE->fullname);
    $PAGE->navbar->add($lbl_playlists);


    $playlists = get_all_instances_in_course('playlist', $COURSE);
    if (!$playlists) {
        // notice() will take care of emitting header and footer
        notice(get_string('thereareno', 'moodle', $lbl_playlists), new moodle_url('/course/view.php', array('id' => $COURSE->id)));
        exit;
    }


    $table = new html_table();
    $table->attributes['class'] = 'generaltable mod_index';
    $table->align = array ('left', 'left');

    $usesections = course_format_uses_sections($COURSE->format);
    if ($usesections) {
        // Two column
        $table->head  = array (get_string('sectionname', 'format_'.$COURSE->format), $lbl_name);
        $table->align = array ('left', 'left');
        $table->size  = array('40%', '%60%');
    } else {
        // One column
        $table->head  = array ($lbl_name);
        $table->align = array ('left');
    }

    $modinfo = get_fast_modinfo($COURSE);

    $last_section = '';
    foreach ($playlists as $playlist) {

        $link = "<a href=\"view.php?id={$modinfo->cms[$playlist->coursemodule]->id}\">" . format_string($playlist->name) . "</a>";

        if ($usesections) {

            // Two column
            $section_label = '';
            if ($playlist->section !== $last_section) {
                $section_label = get_section_name($COURSE, $playlist->section);
                $last_section = $playlist->section;
            }

            $table->data[] = array ($section_label, $link);

        } else {

            // One column
            $table->data[] = array ($link);

        }

    } // foreach


    echo $OUTPUT->header();
    echo $OUTPUT->heading($lbl_playlists);
    echo html_writer::table($table);
    echo $OUTPUT->footer();
