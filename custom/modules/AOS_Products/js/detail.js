$(document).ready(function () {
  $('.nav.nav-tabs a').not('.dropdown-toggle').on('click', function (event) {
    var the_id = event.target.id;

    if (the_id == 'tab0') {
      $('.panel-content').show();
    } else {
      $('.panel-content').hide();
    }
  });
});
