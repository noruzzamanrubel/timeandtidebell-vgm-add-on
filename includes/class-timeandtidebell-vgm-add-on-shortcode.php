<?php

class timeandtidebell_Vgm_Add_Shortcode {

    public function shortcode_generator() {
        add_shortcode( 'add_marker_form', [$this, 'timeandtidebell_custom_marker_form'] );
    }

    public function timeandtidebell_custom_marker_form(){
        static $i = 0;
        $i++;
        $id_prefix = 'ttb_vgm_form' . $i;
        ob_start();
        ?>
        <div id="ttb_marker_form_wrapper">
            <form action="#" method="post" id="ttb_marker_form<?php echo($id_prefix); ?>" class="ttb_marker_form">
                <div class="ttb_marker_form_field">
                    <label for="ttb_marker_date">Marker Date</label>
                    <input type="text" name="ttb_marker_date" id="ttb_marker_date" placeholder="Enter Date" value="" readonly="readonly">
                </div>
                <div class="ttb_marker_form_field">
                    <label for="ttb_marker_type">Types of entry</label>
                    <select name="ttb_marker_type" id="ttb_marker_type">
                        <option value="Flora">Flora</option>
                        <option value="Invertebrates">Invertebrates</option>
                        <option value="Crustaceans">Crustaceans</option>
                        <option value="Fish">Fish</option>
                        <option value="Mammals">Mammals</option>
                        <option value="Seashells">Seashells</option>
                    </select>
                </div>
                <div class="ttb_marker_form_field">
                    <label for="ttb_marker_description">Marker Description</label>
                    <textarea name="ttb_marker_description" id="ttb_marker_description" placeholder="Enter Description" maxlength="100"></textarea>
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