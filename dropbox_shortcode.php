<?php

function dropbox_music_shortcode($atts) {
    $swf_path = plugins_url('wp-dropbox-music/assets/uploadify.swf');
    $upload_path = plugins_url('wp-dropbox-music/upload.php');
?>
<!-- This is hacky, but wordpress doesn't use a good version of jquery so I can't use wp_enqueue_script -->
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="<?php echo plugins_url('wp-dropbox-music/js/jquery.uploadify-3.1.js'); ?>"></script>
<script>
    function append_from_data() {
        var username = $("#name").val();
        var email = $("#email").val();

        $('#file_upload').uploadify('settings', 'formData', {
            'name': username,
            'email': email
        });
    }

    $(document).ready(function() {
        var upload_field = $('#file_upload');

        upload_field.uploadify({
            'swf': '<?php echo $swf_path; ?>',
            'uploader': '<?php echo $upload_path; ?>',
            'onUploadStart': append_from_data,
            'fileTypeDesc': 'MP3 Files',
            'fileTypeExt': '*.mp3',
            'uploadLimit': 5,
            'onSWFReady' : function() {
                $('#file_upload').uploadify('disable', true);
            }
         });

        $('.required_field focus').focus();
        $('.required_field').change(function(evt) {
            var result = true;
            $.each($('.required_field'), function(idx, tag) {
                var ele = $(tag);
                console.log(ele.val());
                result &= ele.val() != "";
            });

            if (result) {
                $('#file_upload').uploadify('disable', false);
            } else {
                $('#file_upload').uploadify('disable', true);
            }
        })
    });
</script>
<p><span class="form_label">Name:</span> <input class="required_field focus" type="text" name="name" id="name" /></p>
<p><span class="form_label">Email Address: </span><input class="required_field" type="text" name="email" id="email" /></p>
<input type="file" name="file_upload" id="file_upload" />
<?php
}
?>
