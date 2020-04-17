<?php

function idea_push_header_render_output($boardNumber,$defaultShowing,$defaultStatus,$defaultTag){
    
    global $ideapush_is_pro;
    
    $individualBoardSetting = idea_push_get_board_settings($boardNumber);
    
    //declare standard variables
    $boardId = $individualBoardSetting[0];
    $boardName = $individualBoardSetting[1];
    $voteThreshold = $individualBoardSetting[2];
    $holdIdeas = $individualBoardSetting[3];
    $showComments = $individualBoardSetting[4];
    $showTags = $individualBoardSetting[5];
    $showAttachments = $individualBoardSetting[6];
    $showBoardTitle = $individualBoardSetting[7];
    $showVoteTarget = $individualBoardSetting[8];
    $guestAccess = $individualBoardSetting[9];
    $downVoting = $individualBoardSetting[10];
    $multiIp = $individualBoardSetting[27];
    
    if(!isset($multiIp)){
        $multiIp = 'No';
    }
    
    $currentUserId = idea_push_check_if_non_logged_in_user_is_guest($multiIp);
    
    //get options
    $options = get_option('idea_push_settings');
 
    $html = '';
    
    //filter
    $html .= '<div class="ideapush-idea-filter">';

        $html .= '<span class="showing-text">'.__( 'Showing', 'ideapush' ).'</span>';
        $html .= '<select data-user-id="'.$currentUserId.'" class="ideapush-sort">';

        

            $html .= '<option value="popular" '.idea_push_check_default_showing('popular',$defaultShowing).'>'.__( 'Popular', 'ideapush' ).'</option>';
            $html .= '<option value="recent" '.idea_push_check_default_showing('recent',$defaultShowing).'>'.__( 'Recent', 'ideapush' ).'</option>';
            $html .= '<option value="trending" '.idea_push_check_default_showing('trending',$defaultShowing).'>'.__( 'Trending', 'ideapush' ).'</option>';

            //only show this option if logged in
            if($currentUserId !== false){
                $html .= '<option value="'.$currentUserId.'" '.idea_push_check_default_showing($currentUserId,$defaultShowing).'>'.__( 'My', 'ideapush' ).'</option>';
                
                $html .= '<option value="my-voted" '.idea_push_check_default_showing('my-voted',$defaultShowing).'>'.__( 'My Voted', 'ideapush' ).'</option>';
            }



        $html .= '</select>';
        













        $html .= ' <span class="ideas-that-are-text">'.__( 'ideas that are', 'ideapush' ).'</span>';
        $html .= '<select class="ideapush-status-filter">';

    
            //declare the standard statuses    
            $statusOptions = array('open','reviewed','approved','declined','in-progress','completed','all-statuses');
     
            foreach($statusOptions as $statusOption){

                //replace the dash for the underscore for the settings lookup
                $statusOptionSetting = str_replace('-','_',$statusOption);

                //lets get the translated name of the status
                $translatedStatusName = $options['idea_push_change_'.$statusOptionSetting.'_status'];

                if(isset($translatedStatusName) && strlen($translatedStatusName) > 0){
                    $translatedStatusName = $translatedStatusName;   
                } else {
                    //replace dashes with spaces
                    $translatedStatusName = str_replace('-',' ',$statusOption);
                    $translatedStatusName = ucwords($translatedStatusName);
                }

                //check if disabled
                if(!isset($options['idea_push_disable_'.$statusOptionSetting.'_status'])){
                    //check if the item is selected
                    if($statusOption == $defaultStatus){
                        $html .= '<option value="'.$statusOption.'" selected="selected">'.esc_html($translatedStatusName).'</option>';
                    } else {
                        $html .= '<option value="'.$statusOption.'">'.esc_html($translatedStatusName).'</option>'; 
                    }
                }
    
            }
          
        $html .= '</select>';








    

        //now conditionally show the tags
        if($showTags == 'Yes'){


            




            $html .= ' <span class="with-tags-text">'.__( 'with tags', 'ideapush' ).'</span>'; 
            $html .= '<select class="ideapush-tags-filter">';



                $html .= '<option value="all">'.__( 'All', 'ideapush' ).'</option>';

                $tagTerms = idea_push_get_tags($boardId);

                //lets sort these tags alphabetically
                $tagTermsArray = array();

                foreach($tagTerms as $tagTerm){

                    //if tag contains BoardTag, remove it from the tag name
                    if(strpos($tagTerm->name, 'BoardTag-') !== false){

                        $positionOfSecondHyphen = strpos($tagTerm->name, '-', strpos($tagTerm->name, '-') + 1);

                        $tagName = substr($tagTerm->name,$positionOfSecondHyphen+1,strlen($tagTerm->name)-$positionOfSecondHyphen);

                    } else {
                        $tagName = $tagTerm->name;
                    }

                    $tagTermsArray[$tagTerm->term_id] = $tagName; 


                }    

                //sort the array by value
                natcasesort($tagTermsArray);

                //lets only grab the top 15 tags otherwise the dropdown will become too big
                foreach($tagTermsArray as $tagId => $tagName){

                    if($tagId == $defaultTag){

                        $html .= '<option value="'.esc_attr($tagId).'" selected="selected">'.esc_html($tagName).'</option>';

                        // $tagMatch = $tagTerm->term_id;

                    } else {
                        $html .= '<option value="'.esc_attr($tagId).'">'.esc_html($tagName).'</option>';    

                    }
                }    

            $html .= '</select>';
    
        }

    $html .= '</div>';

    //search
    $html .= '<div class="ideapush-idea-search">';
        $html .= '<input class="ideapush-search-input" placeholder="'.__( 'Search', 'ideapush' ).'"><i class="ideapush-icon-Search search-icon"></i></input>';
    $html .= '</div>';


    return $html;
    
}



?>