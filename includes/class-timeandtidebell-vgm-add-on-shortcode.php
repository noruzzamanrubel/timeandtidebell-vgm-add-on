<?php

class timeandtidebell_Vgm_Add_Shortcode {

    public function shortcode_generator() {
        add_shortcode( 'add_marker_form', [$this, 'timeandtidebell_custom_marker_form'] );
    }

    public function timeandtidebell_custom_marker_form($atts){

        $atts = shortcode_atts(
            array(
                'date-label'                      => __('Marker Date', 'timeandtidebell-vgm-add-on'),
                'address-label'                   => __('Marker Address or GPS Location', 'timeandtidebell-vgm-add-on'),
                'address-info-label'              => __('Or right-click on the map and drag to add a marker', 'timeandtidebell-vgm-add-on'),
                'type-entry-label'                => __('Types of entry', 'timeandtidebell-vgm-add-on'),
                'description-label'               => __('Marker Description', 'timeandtidebell-vgm-add-on'),
                'description-placeholder'   => __('Enter Description', 'timeandtidebell-vgm-add-on'),
                'image-label'                     => __('Upload Image', 'timeandtidebell-vgm-add-on'),
                'success-message'           => __('Thank you, your submission is received and will be added to the map once approved by an admin.', 'timeandtidebell-vgm-add-on'),
                'error-message'             => __('The information you provided is not valid. Please check your input and try again.', 'timeandtidebell-vgm-add-on'),
            ), $atts);

        ob_start();
        ?>
        <div id="ttb_marker_form_wrapper" data-success-message='<?php echo $atts['success-message']; ?>' data-error-message="<?php echo $atts['error-message']; ?>">
            <form action="" method="post" id="ttb_marker_form" class="ttb_marker_form" enctype="multipart/form-data">
                <div class="ttb_marker_form_field" id="ttb_marker_form_date_field">
                    <label for="ttb_marker_date"><?php echo __($atts['date-label']);?><span class="ttb-required-label"> *</span></label>
                    <input type="text" name="ttb_marker_date" id="ttb_marker_date" placeholder="Enter Date" value="" readonly="readonly">
                </div>
                <div class="ttb_marker_form_field" id="ttb_marker_address">
                    <label for="ttb_marker_address"><?php echo __($atts['address-label']);?><span class="ttb-required-label"> *</label>
                </div>
                <div class="ttb_marker_form_field" id="ttb_marker_address_info">
                    <span><?php echo __($atts['address-info-label']);?></span>
                </div>
                <div class="ttb_marker_form_field" id="ttb_marker_type">
                    <label for="ttb_marker_type"><?php echo __($atts['type-entry-label']);?><span class="ttb-required-label"> *</label>
                </div>
                <div class="ttb_marker_form_field" id="ttb_marker_des">
                    <label for="ttb_marker_description"><?php echo __($atts['description-label']);?></label>
                    <textarea name="ttb_marker_description" id="ttb_marker_description" placeholder="<?php echo __($atts['description-placeholder']);?>" maxlength="100"></textarea>
                </div>
                <div class="ttb_marker_form_field" id="ttb_upload_image">
                    <label for="ttb_upload_image"><?php echo __($atts['image-label']);?></label>
                    <input type="file" name="file" id="ttb_file">
                </div>
                <div class="ttb_marker_form_field" id="ttb_submit">
                    <input type="submit" name="ttb_marker_submit" id="ttb_marker_submit" value="Add Marker">
                </div>
                <div class="form-row" id="result_message"></div>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}