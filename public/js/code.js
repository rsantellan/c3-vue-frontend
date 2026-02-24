
function init_table_list() {
  $("div.table-list div.item i.arrow-blue").click(function() {

    var content_item = $(this).parents('.header').next('.content');

    if ($(this).attr("class").indexOf("open") != -1) {
      // Item desplegado
      $(this).removeClass("open");
      content_item.slideUp();

    } else {
      // Item cerrado
      $(this).addClass("open");    
      content_item.slideDown();
    }
  });
}

function init_table_list_second() {
  $("h4 a.arrow").click(function() {

    var content_item_second = $(this).parents('.title_client_amount').next('.content_amounth');

    if ($(this).attr("class").indexOf("open") != -1) {
      // Item desplegado
      $(this).removeClass("open");
      content_item_second.slideUp();

    } else {
      // Item cerrado
      $(this).addClass("open");
      content_item_second.slideDown();
   }
  });
}

function init_table_list_blog() {
  $("div.title_client_blog h4 a.arrow").click(function() {

    var content_item_blog = $(this).parents('.title_client_blog').next('.content_blog');

    if ($(this).attr("class").indexOf("open") != -1) {
      // Item desplegado
      $(this).removeClass("open");
      content_item_blog.slideUp();

    } else {
      // Item cerrado
      $(this).addClass("open");
      content_item_blog.slideDown();
    }
  });
}

function init_slidebox(className) {

	if ($(className).length == 0)
    return;

  $(className).mouseenter(function () {
   $("div:first", this).stop();
   $("div:last", this).stop();
   $("div:first", this).animate({ marginTop: -($("div:first", this).height()), opacity: 0.0 }, 300);
   $("div:last", this).animate({ opacity: 1.0 }, 300);
 });

  $(className).mouseleave( function () {
   $("div:first", this).stop();
   $("div:last", this).stop();
   $("div:first", this).animate({ marginTop: 0, opacity: 1.0 }, 300);  
   $("div:last", this).animate({ opacity: 0.0 }, 300);
 });
  
}

$(document).ready(function() {
 init_slidebox(".slide-box");
 init_table_list();;
init_table_list_second();;
//init_table_list_blog();
});
