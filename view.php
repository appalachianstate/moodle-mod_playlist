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

    require_once("../../config.php");



    // Course module id is supplied
    $id = optional_param('id',0,PARAM_INT);

    // Set this up in case print_error() is needed
    $PAGE->set_url('/mod/playlist/view.php', array('id' => $id));

    $cm = get_coursemodule_from_id('playlist', $id);
    if (!$cm) {
        throw new moodle_exception('invalidcoursemodule', 'error');
    }

    // Authenticate & authorize
    require_login($cm->course, true, $cm);

    // Fetch the playlist instance
    $playlist = $DB->get_record('playlist', array('id' => $cm->instance));
    if (!$playlist) {
        throw new moodle_exception('coursemisconf', 'error');
    }

    $context = context_module::instance($cm->id);
    require_capability('mod/playlist:view', $context);


    add_to_log($COURSE->id, 'playlist', 'view', 'view.php?id=' . $cm->id, $playlist->id, $cm->id);


    $PAGE->set_title("{$COURSE->shortname}: {$playlist->name}");
    $PAGE->set_heading($COURSE->fullname);
    if (optional_param('inpopup', 0, PARAM_BOOL)) {
        $PAGE->set_pagelayout('popup');
        $PAGE->set_heading('');
    }

    echo $OUTPUT->header();
    echo $OUTPUT->heading(format_string($playlist->name), 2, 'main', 'pageheading');
    echo $OUTPUT->box(get_string('example_usage', 'mod_playlist') . "<br /><br />&lt;a href=\"rtmp://playlist={$playlist->name}\"&gt;{$playlist->name}&lt;/a&gt;", "generalbox center clearfix");

    $formatoptions              = new stdClass;
    $formatoptions->noclean     = true;
    $formatoptions->overflowdiv = true;
    $formatoptions->context     = $context;

    echo $OUTPUT->box(format_text($playlist->list, FORMAT_PLAIN, $formatoptions), "generalbox center clearfix");
    echo $OUTPUT->continue_button(new moodle_url("/course/view.php", array('id' => $COURSE->id)));
    echo $OUTPUT->footer();
