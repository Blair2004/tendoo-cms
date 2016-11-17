<?php
$this->load->config('rest');
$header_key        =    $this->config->item('rest_key_name');
$key            =    @$Options[ 'rest_key' ];
?>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
        var elf = $('#elfinder').elfinder({
            // lang: 'ru',             // language (OPTIONAL)
            url : '<?php echo site_url( array( 'rest', 'fileManager' ) );?>', // connector URL (REQUIRED)
            customHeaders   :   {
                '<?php echo $header_key;?>' :  '<?php echo $key;?>'
            },
            height      :   $( '.content-wrapper' ).height() - 75
        }).elfinder('instance');
    });
</script>

<!-- Element where elFinder will be created (REQUIRED) -->
<div id="elfinder"></div>
