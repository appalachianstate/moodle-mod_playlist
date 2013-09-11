
 README for mod_playlist resource plugin

 DISCLAIMER AND LICENSING
 ------------------------
 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or (at
 your option) any later version.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program. If not, see <http://www.gnu.org/licenses/>.


 GENERAL INFORMATION
 -------------------
 The playlist plugin, used in conjunction with the filter_rtmp plugin,
 provides a way to save a reference a list of rtmp URLs in a course. It
 does little more than a label, except to provide a name for each set
 of URLs.
 
 Once a set of rtmp URLs is named and saved, you can reference it in a
 URL that will be used by the rtmp filter. For example, for a course's
 section/topic description, or in a label, type the word 'link' and then
 click on the wysiwyg editor's link button. In the URL field, type the
 following: rtmp://playlist=CLASSICAL. That's assuming you named your
 playlist 'CLASSICAL'. When the filter detects the rtmp link, it will
 fetch the named playlist and build a list of clips on which the user
 can click.


 INSTALLATION
 ------------
 Place the playlist directory in the site's mod directory. Access the
 notifications admin page to confirm installation.
