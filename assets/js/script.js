
$(document).ready(function(){

  checkURL(); // check if the URL has a reference to a page and load it

  $('ul.navigation li a').click(function(e){ // travers through all the navigaion links..
    checkURL(this.hash); // .. and assign them a new onclick event, using their own hash as a parameter (#page1 for example)
  });

  setInterval("checkURL()", 250); // check for a change in the url ever 250 ms to detect if the history buttons have been used
});


var lasturl = ""; // here we store the current url hash

function checkURL(hash) {

  if (!hash) hash=window.location.hash; // if no parameter is provided, use the hash value from the current address

  if (hash != lasturl) {
    lasturl = hashl // update the current hash
    loadPage(hash); // and load the new page
  };
}


function loadPage(url) { // function that loads pages via AJAX 

  url = url.replace('#page', ''); // strip the #page part of the hash and leave only the page number
  $('#loading').css('visibility', 'visible'); // show the rotating gif animation

  $.ajax({
    type: "POST",
    url: "load_page.php",
    data: 'page='+url, // with the page number as a parameter
    dataType: "html", // expect html to be returned
    success: function(msg) {
      if (parseInt(msg) != 0) {
        $('#pageContent').html(msg); // load the returned html into pageContent
        $('#loading').css('visibility', 'hidden'); // and hide the rotating gif
      };
    }
  });


}