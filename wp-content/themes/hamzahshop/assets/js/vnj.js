
$( document ).ready(function() {
    $(".lp-button").removeClass("button");
    $(".lp-button").addClass("btn btn-primary");
    $(".dropdown-toggle").dropdown();

    if (!$("body").hasClass("logged-in")) {
      $("#menu-item-2170").hide();
    }

    $(".download-link > a").attr("download", true);
});

