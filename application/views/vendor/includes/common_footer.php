<!-- Main Footer -->
<footer class="main-footer" style="bottom: 0;width: 100%;">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        <!--        Other info-->
    </div>
    <!-- Default to the left -->
    <div style="display: inline-block; margin-left: 380px; margin-top:2px">
    Copyright  <?php echo COPYRIGHT_TEXT; ?>
    </div>
    <?php if (USE_LANG_TRANSLATOR) { ?>
    <span style="float: left;">
        <div id="google_translate_element"></div><script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false, multilanguagePage: true}, 'google_translate_element');
            }
        </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    </span>
    <?php } ?>
</footer>

<div class="control-sidebar-bg"></div>