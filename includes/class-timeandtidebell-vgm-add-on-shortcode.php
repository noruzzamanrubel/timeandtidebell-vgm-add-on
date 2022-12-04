<?php

class timeandtidebell_Vgm_Add_Shortcode {

    public function shortcode_generator() {
        add_shortcode( 'add_marker_form', [$this, 'timeandtidebell_custom_marker_form'] );
    }

    public function timeandtidebell_custom_marker_form($atts){
        $atts = shortcode_atts(array(
            "type" => "Flora, Invertebrates, Crustaceans, Fish, Mammals, Seashells"
        ), $atts);

        $attr_type = explode(",", $atts['type']);

        ob_start();
        ?>
        <div id="ttb_marker_form_wrapper">
            <form action="" method="post" id="ttb_marker_form" class="ttb_marker_form" enctype="multipart/form-data">
                <div class="ttb_marker_form_field" id="ttb_marker_form_date_field">
                    <label for="ttb_marker_date">Marker Date</label>
                    <input type="text" name="ttb_marker_date" id="ttb_marker_date" placeholder="Enter Date" value="" readonly="readonly">
                </div>
                <div class="ttb_marker_form_field">
                    <label for="ttb_marker_type">Types of entry</label>
                    <select name="ttb_marker_type" id="ttb_marker_type">
                        <?php
                            foreach($attr_type as $key => $option) {?>
                                <option value="<?php echo strtolower($option); ?>"><?php echo $option; ?></option>
                            <?php }
                        ?>
                    </select>
                </div>
                <div class="ttb_marker_form_field">
                    <label for="ttb_marker_description">Marker Description</label>
                    <textarea name="ttb_marker_description" id="ttb_marker_description" placeholder="Enter Description" maxlength="100"></textarea>
                </div>
                <div class="ttb_marker_form_field" id="ttb_upload_image">
                    <label for="ttb_upload_image">Upload Image</label>
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