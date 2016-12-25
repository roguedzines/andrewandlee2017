jQuery(document).ready(function($) {

    var $mainContent = $(".main-postcontent"),
        siteUrl = "http://" + top.location.host.toString(),
        url = '';

    // more code here
    $(document).on("click", "a[href^='"+siteUrl+"']:not([href*='/wp-admin/']):not([href*='/wp-login.php']):not([href$='/feed/'])", function() {
    location.hash = this.pathname;
    return false;
    });
    $("#searchform").submit(function(e) {
        location.hash = '?s=' + $("#s").val();
        e.preventDefault();
    });

    $(window).bind('hashchange', function() {
        url = window.location.hash.substring(1);

        if (!url) {
            return;
        }

        url = url + " .post-content, .products";

        $mainContent.animate({
            opacity: "0.1"}).html('<center><img src="wp-content/themes/ltomchik/images/ripple.gif"></center>').load(url, function() {
            $mainContent.animate({
                opacity: "1"
            });
        });
    });

    $(window).trigger('hashchange');

});
