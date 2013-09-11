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



    $string['pluginname'] = 'Playlist';
    $string['pluginadministration'] = 'Playlist administration';

    $string['modulename'] = 'Playlist';
    $string['modulenameplural'] = 'Playlists';
    $string['modulename_link'] = 'mod/playlist/view';
    $string['modulename_help'] = 'RTMP Playlists are used by the RTMP filter to configure a media player with a list of media streams to play. Each line should contain the rtmp:// URL for the video or audio stream, with an optional name for the stream separated by a comma.';

    $string['playlist:addinstance'] = 'Add a new playlist';
    $string['page-mod-playlist-x']  = 'Any playlist module page';

    $string['list']         = 'List';
    $string['list_help']    = 'List of RTMP URLs, one per line, with an optional name, seperated by a comma, to display in the list for that URL.';

    $string['err_list_url_invalid']    = 'One or more of the URLs in the list is invalid.';
    $string['err_list_name_is_taken']  = 'Playlist name is already used.';
