<footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <?php if (USE_LANG_TRANSLATOR) { ?>
    <span style="float: left;">
        <div id="google_translate_element"></div>
        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false, multilanguagePage: true}, 'google_translate_element');
            }
        </script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script type="text/javascript">
            $('.goog-logo-link').hide();
        </script>
    </span>
    <?php } ?>
    <div style="text-align: center; margin-top: 2px;">
    Copyright <?php echo COPYRIGHT_TEXT; ?>
    </div>
   
</footer>

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>