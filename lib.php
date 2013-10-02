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



    /**
     * @param string $feature FEATURE_xx constant for requested feature
     * @return bool|null True if module supports feature, false if not, null if doesn't know
     */
    function playlist_supports($feature)
    {

        switch($feature) {

            case FEATURE_IDNUMBER:                return true;
            case FEATURE_GROUPS:                  return false;
            case FEATURE_GROUPINGS:               return false;
            case FEATURE_GROUPMEMBERSONLY:        return false;
            case FEATURE_MOD_INTRO:               return false;
            case FEATURE_COMPLETION_TRACKS_VIEWS: return false;
            case FEATURE_GRADE_HAS_GRADE:         return false;
            case FEATURE_GRADE_OUTCOMES:          return false;
            case FEATURE_MOD_ARCHETYPE:           return MOD_ARCHETYPE_RESOURCE;
            case FEATURE_BACKUP_MOODLE2:          return true;
            case FEATURE_NO_VIEW_LINK:            return false;

            default:                              return null;

        }

    }



    function playlist_page_type_list($pagetype, $parentcontext, $currentcontext)
    {
        return array('mod-playlist-*' => get_string('page-mod-playlist-x', 'mod_playlist'));
    }



    function playlist_get_view_actions()
    {
        return array('view', 'view all');
    }



    function playlist_get_post_actions()
    {
        return array('update', 'add');
    }



    function playlist_reset_userdata($data)
    {
        return array();
    }



    /**
     * Add a new playlist instance
     *
     * @param stdClass $playlist
     * @return int
     * @uses $DB
     */
    function playlist_add_instance($playlist, $form)
    {
        global $DB;


        $playlist->list = playlist_clean_list($playlist->list);
        return $DB->insert_record('playlist', $playlist);

    }



    /**
     * Update a playlist instance
     *
     * @param stdClass $playlist
     * @return boolean
     * @uses $DB
     */
    function playlist_update_instance($playlist, $form)
    {
        global $DB;


        $playlist->id = $playlist->instance;
        $playlist->list = playlist_clean_list($playlist->list);
        return (boolean)$DB->update_record('playlist', $playlist);

    }



    /**
     * Delete a playlist instance
     *
     * @param int $id
     * @return boolean
     * @uses $DB
     */
    function playlist_delete_instance($id)
    {
        global $DB;


        return (boolean)$DB->delete_records('playlist', array('id' => $id));

    }



    /**
     * Clean the submitted playlist (text)
     *
     */
    function playlist_clean_list($list_text)
    {

        $buf  = array();
        $list = array_map('trim', explode("\n", $list_text));
        foreach ($list as $item) {
            if (empty($item)) continue;

            @list($url, $name) = array_map('trim', explode(',', $item, 2));

            if (empty($url)) continue;

            $url   = str_replace(' ', '+', $url);
            $name  = clean_param(trim($name), PARAM_TEXT);
            $buf[] = $url . (empty($name) ? '' : ",$name");

        } // foreach

        return implode("\n", array_unique($buf));

    }
