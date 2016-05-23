<?php /* PLUGIN K Editor */ ?>     
        <!-- CK Editor -->
        <script src="<?php echo(JAVA_PLUGIN_PATH.'ckeditor/core/ckeditor.js'); ?>" type="text/javascript"></script>
        <script type="text/javascript">
            $(function() {
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace('editor1');
            });
        </script>