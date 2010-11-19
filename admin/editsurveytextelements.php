<?php
/*
* LimeSurvey
* Copyright (C) 2007 The LimeSurvey Project Team / Carsten Schmitz
* All rights reserved.
* License: GNU/GPL License v2 or later, see LICENSE.php
* LimeSurvey is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*
* $Id:
*
*/

  include_once("login_check.php");  //Login Check dies also if the script is started directly

  if(bHasSurveyPermission($surveyid,'surveylocale','read'))
    {

        $grplangs = GetAdditionalLanguagesFromSurveyID($surveyid);
        $baselang = GetBaseLanguageFromSurveyID($surveyid);
        array_unshift($grplangs,$baselang);

        $editsurvey = PrepareEditorScript();


        $editsurvey .="<div class='header ui-widget-header'>".$clang->gT("Edit survey text elements")."</div>\n";
        $editsurvey .= "<form id='addnewsurvey' class='form30' name='addnewsurvey' action='$scriptname' method='post'>\n"
        . '<div class="tab-pane" id="tab-pane-surveyls-'.$surveyid.'">';
        foreach ($grplangs as $grouplang)
        {
            // this one is created to get the right default texts fo each language
            $bplang = new limesurvey_lang($grouplang);
            $esquery = "SELECT * FROM ".db_table_name("surveys_languagesettings")." WHERE surveyls_survey_id=$surveyid and surveyls_language='$grouplang'";
            $esresult = db_execute_assoc($esquery); //Checked
            $esrow = $esresult->FetchRow();
            $editsurvey .= '<div class="tab-page"> <h2 class="tab">'.getLanguageNameFromCode($esrow['surveyls_language'],false);
            if ($esrow['surveyls_language']==GetBaseLanguageFromSurveyID($surveyid)) {$editsurvey .= '('.$clang->gT("Base Language").')';}
            $editsurvey .= '</h2><ul>';
            $esrow = array_map('htmlspecialchars', $esrow);
            $editsurvey .= "<li><label for=''>".$clang->gT("Survey title").":</label>\n"
            . "<input type='text' size='80' name='short_title_".$esrow['surveyls_language']."' value=\"{$esrow['surveyls_title']}\" /></li>\n"
            . "<li><label for=''>".$clang->gT("Description:")."</label>\n"
            . "<textarea cols='80' rows='15' name='description_".$esrow['surveyls_language']."'>{$esrow['surveyls_description']}</textarea>\n"
            . getEditor("survey-desc","description_".$esrow['surveyls_language'], "[".$clang->gT("Description:", "js")."](".$esrow['surveyls_language'].")",'','','',$action)
            . "</li>\n"
            . "<li><label for=''>".$clang->gT("Welcome message:")."</label>\n"
            . "<textarea cols='80' rows='15' name='welcome_".$esrow['surveyls_language']."'>{$esrow['surveyls_welcometext']}</textarea>\n"
            . getEditor("survey-welc","welcome_".$esrow['surveyls_language'], "[".$clang->gT("Welcome:", "js")."](".$esrow['surveyls_language'].")",'','','',$action)
            . "</li>\n"
            . "<li><label for=''>".$clang->gT("End message:")."</label>\n"
            . "<textarea cols='80' rows='15' name='endtext_".$esrow['surveyls_language']."'>{$esrow['surveyls_endtext']}</textarea>\n"
            . getEditor("survey-endtext","endtext_".$esrow['surveyls_language'], "[".$clang->gT("End message:", "js")."](".$esrow['surveyls_language'].")",'','','',$action)
            . "</li>\n"
            . "<li><label for=''>".$clang->gT("End URL:")."</label>\n"
            . "<input type='text' size='80' name='url_".$esrow['surveyls_language']."' value=\"{$esrow['surveyls_url']}\" />\n"
            . "</li>"
            . "<li><label for=''>".$clang->gT("URL description:")."</label>\n"
            . "<input type='text' size='80' name='urldescrip_".$esrow['surveyls_language']."' value=\"{$esrow['surveyls_urldescription']}\" />\n"
            . "</li>"
            . "<li><label for=''>".$clang->gT("Date format:")."</label>\n"
            . "<select size='1' name='dateformat_".$esrow['surveyls_language']."'>\n";
            foreach (getDateFormatData() as $index=>$dateformatdata)
            {
                $editsurvey.= "<option value='{$index}'";
                if ($esrow['surveyls_dateformat']==$index) {
                    $editsurvey.=" selected='selected'";
                }
                $editsurvey.= ">".$dateformatdata['dateformat'].'</option>';
            }
            $editsurvey.= "</select></li></ul>"
            . "</div>";
        }
        $editsurvey .= '</div>';
        if(bHasSurveyPermission($surveyid,'surveylocale','update'))
        {
            $editsurvey .= "<p><input type='submit' class='standardbtn' value='".$clang->gT("Save")."' />\n"
            . "<input type='hidden' name='action' value='updatesurveylocalesettings' />\n"
            . "<input type='hidden' name='sid' value=\"{$surveyid}\" />\n"
            . "<input type='hidden' name='language' value=\"{$esrow['surveyls_language']}\" />\n"
            . "</p>\n"
            . "</form>\n";
        }

    }
    else
    {
        include("access_denied.php");
    }

?>