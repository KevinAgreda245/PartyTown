var hoy = new Date();
$(document).ready(function () {
  $('select').formSelect();
  $('.collapsible').collapsible();
  validateDate(hoy.getFullYear()-18+"/"+hoy.getMonth()+"/"+hoy.getDate());
  $('.materialboxed').materialbox();
  $('.slider').slider();
  $('.sidenav').sidenav();
  $('.modal').modal();
  $('.dropdown-trigger').dropdown({
    coverTrigger: false
  });
  $('.tooltipped').tooltip();
  $('.tabs').tabs();
  $('input#input_text, textarea#textarea2').characterCounter();
});
