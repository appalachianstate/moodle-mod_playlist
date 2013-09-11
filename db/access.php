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



    $capabilities = array(

        'mod/playlist:view'         => array('captype'            => 'read',
                                             'contextlevel'       => CONTEXT_MODULE,
                                             'archetypes'         => array('editingteacher' => CAP_ALLOW,
                                                                           'manager'        => CAP_ALLOW)),

        'mod/playlist:addinstance' => array('captype'              => 'write',
                                            'contextlevel'         => CONTEXT_COURSE,
                                            'riskbitmask'          => RISK_XSS,
                                            'archetypes'           => array('editingteacher' => CAP_ALLOW,
                                                                            'manager'        => CAP_ALLOW),
                                            'clonepermissionsfrom' => 'moodle/course:manageactivities'),

    );
