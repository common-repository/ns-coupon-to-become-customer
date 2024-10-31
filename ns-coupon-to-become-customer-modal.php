<?php

function ns_coupon_to_become_customer_modal(){
    
    ?>
    <div class="ns-modal-wc-layer"><!-- layer -->
        
        <div class="ns-modal-wc"><!-- modal -->
            <div id="ns-close-modal">
                <i class="fas fa-times fa-2x"></i>
            </div>
            <br>
            <!-- Success response -->
            <div class="ns-div-success ns-div-response">
                <img src="<?php echo plugin_dir_url( __FILE__ ).'img/ns-checked.svg';?>" width="100" class="ns-div-image-done">
                <br><br>
                <div class="ns-margin">
                    <?php
                    $ns_custom_option_coupon = get_option('ns-ctbc-coupon-name');
                    $ns_custom_option_title = get_option('ns-ctbc-popup-title');
                    echo '<h1>'.$ns_custom_option_coupon.'</h1>';
                    ?>
                    <span><?php _e('Your coupon was successfully sent! Check your mail!', 'ns-coupon-to-become-customer');?></span>
                </div>
                
            </div>
            <!-- Failure response -->
            <div class="ns-div-error ns-div-response">
                <img src="<?php echo plugin_dir_url( __FILE__ ).'img/ns-error.svg';?>" width="100" class="ns-div-image-done">
                <br><br>
                <span class="ns-div-error-span"><?php _e('An error occurred! Please check your inputs.', 'ns-coupon-to-become-customer');?></span><br><br>
                <input type="button" value="try again" class="ns-try-again">
                
            </div>
            <!-- TITLE -->
            <div class="ns-ctbc-title ns-center">
                <?php
                
                    $ns_custom_option_title = get_option('ns-ctbc-popup-title'); 
                    echo '<h2>'.$ns_custom_option_title.'</h2>';
                ?>
            </div>
            <!-- SUBTITLE -->
            <div class="ns-ctbc-subtitle ns-center">
                <?php
                    $ns_custom_option_subtitle = get_option('ns-ctbc-popup-subtitle');
                    echo '<h4>'.$ns_custom_option_subtitle.'</h4>';
                ?>
            </div>
            <!-- PREPARE PRIVACY POLICY -->
            <?php
                if(get_option('ns-ctbc-enable-privacy-policy')=='on'){
                    $ns_link_to_privacy_policy = get_option('ns-ctbc-popup-privacy-policy');
                    $ns_terms_and_conditions = __('I have read and agree to the', 'ns-coupon-to-became-customer');
                    $ns_terms_and_conditions .= '<a href="'.$ns_link_to_privacy_policy.'" target="_blank"> '.__('privacy policy', 'ns-coupon-to-became-customer').'</a>';
                }
            ?>
            <!-- FORM: name and email -->
            <div class="ns-textarea-size">
                <span><b><?php _e('Your name:', 'ns-coupon-to-become-customer');?></b></span>
                <input type="text" id="ns-your-name" name="name" placeholder="John">

                <span><b><?php _e('Your E-mail (required):', 'ns-coupon-to-become-customer');?></b></span>
                <input type="text" id="ns-your-email" name="name" placeholder="JohnDoe@nsthemes.com" >
                <?php
                    if(get_option('ns-ctbc-enable-privacy-policy')=='on'){
                    ?>
                        <input type="checkbox" name="terms_conditions" id="terms_conditions" value="accept" class="ns-ctbc-checkmark ns-ctbc-container"><?php echo $ns_terms_and_conditions;
                    }
                    ?>
                <div class="ns-div-share-now">
                    <input type="button" id="ns-send-mail" name="share" value="<?php _e('SEND NOW!', 'ns-coupon-to-become-customer');?>">
                    <img src="<?php echo plugin_dir_url( __FILE__ ).'img/loader.gif'?>" class="ns-image-loader">
                </div>           
            </div>
            
        </div>
    </div>
    
    <?php
    
}
add_action('wp_footer', 'ns_coupon_to_become_customer_modal');
?>