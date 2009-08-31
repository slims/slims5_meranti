<?php
// biblio/record detail
// output the buffer
ob_start(); /* <- DONT REMOVE THIS COMMAND */
?>
<table class="border margined" style="width: 99%;" cellpadding="5" cellspacing="0">
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Title'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{title}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Edition'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{edition}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Call Number'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{call_number}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('ISBN/ISSN'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{isbn_issn}</td>
</tr>
<tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Author(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{authors}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Subject(s)'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{subjects}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Classification'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{classification}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Series Title'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{series_title}</td>
</tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('GMD'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{gmd_name}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Language'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{language_name}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Publisher'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{publisher_name}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Publishing Year'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{publish_year}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Publishing Place'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{publish_place}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Collation'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{collation}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Abstract/Notes'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{notes}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Specific Detail Info'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{spec_detail_info}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Image'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{image}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('File Attachment'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{file_att}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top"><?php print _('Availability'); ?></td>
<td class="tblContent" style="width: 80%;" valign="top">{availability}</td>
</tr>
<tr>
<td class="tblHead" style="width: 20%;" valign="top">&nbsp;</td>
<td class="tblContent" style="width: 80%;" valign="top">Press &quot;Back&quot; Button on your browser to back to previous result</td>
</tr>
</table>
<?php
// put the buffer to template var
$detail_template = ob_get_clean();
?>
