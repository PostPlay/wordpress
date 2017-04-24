<div id="postp-metabox-wrap">
    <?php if (!isset($api_status) || !isset($api_status->data) || !$api_status) : ?>
        <p>Please check your PostPlay <a href="<?php echo admin_url('options-general.php?page=postplay-options'); ?>">API settings</a>.</p>
        <?php
    else:
        $api_status_data = $api_status->data;
        ?>
        <div id="credit-bal">You have <?php echo $api_status->data->credits; ?> credits available</div>
        <p>Would you like this post in audio format as well?</p>
        <div id="credit-charge-wrap">
            <div id="charge-display-oval"><div>0</div></div>
        </div>
        <h1 id="credits-spend">Credits</h1>
        <h4 id="pp-words-count"><span class='count-dsp'>0</span> Words</h4>

        <div id="postp-switch-wrap">
            <div id="postp-switch">
                <div class="switch-split switch-yes">Yes</div>
                <div class="switch-split switch-no active">No</div>
                <input type="hidden" name="postplay_send" id="postplay_send" value="0">
            </div>
        </div>


        <?php if (isset($api_status_data->prev_agents) && is_array($api_status_data->prev_agents)): ?>
            <div class="postplay-select-wrapper">
                <select name="pref_agent">
                    <option value="">Any Voice Actor</option>
                    <?php
                    foreach ($api_status_data->prev_agents as $agent) {
                        echo '<option value="' . $agent->id . '">' . $agent->name . '</option>';
                    }
                    ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="postplay-select-wrapper">
            <select name="pref_gender">
                <option value="">Any voice gender</option>
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>
        </div>
    <?php endif; ?>
</div>

<script>
    var minimum_credit_usage = 300;
    function toggleSendValue() {
        var theVal = jQuery("#postplay_send").val();
        if (theVal != '1') {
            jQuery("#postplay_send").val('1');
        } else {
            jQuery("#postplay_send").val('0');
        }

    }
    jQuery(document).on('click', '.switch-split', function () {
        jQuery('.switch-split').toggleClass('active');
        toggleSendValue();
    });

    function postplayWordCount(str) {
        return str.split(" ").length;
    }

    function countContentLength(textarea) {
        var textContent = "";
        if (textarea) {
            textContent = jQuery('#content').val();
        } else {
            textContent = tinymce.editors.content.getBody().textContent;
        }

        var theCount = postplayWordCount(textContent);
        var cost = theCount;
        if (cost < minimum_credit_usage)
            cost = minimum_credit_usage;
        jQuery("#pp-words-count span.count-dsp").html(theCount);
        jQuery('#charge-display-oval div').html(Math.ceil((cost)));
    }


    jQuery(document).on('ready', function () {
        setTimeout(function () {
            countContentLength(true);
            tinymce.editors.content.on('change', function (e) {
                countContentLength(false);
            });

            jQuery("textarea#content").on('change', function () {
                countContentLength(true);
            });
        }, 1000);

    });

</script>