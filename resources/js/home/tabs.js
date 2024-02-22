$(".tabBox").each(function () {
  var thisTAb = $(this);
  thisTAb.find(".tablinks").click(function (e) {
    e.preventDefault();
    var thisLink = $(this);
    var tabId = thisLink.attr("tabId");
    var tabId = "#" + tabId;
    thisTAb.find(".tabcontent").hide();
    thisTAb.find(tabId).show();
    thisLink.parent().siblings().find(".tablinks").removeClass("active");
    thisLink.addClass("active");
  });
});
