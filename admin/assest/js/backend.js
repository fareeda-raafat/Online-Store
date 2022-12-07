// Hide placeholder on focus

$(function () {

  //  function to hide placeholder in focus

  $('[placeholder]').focus(function () {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).removeAttr('placeholder');
  }).blur(function () {
    $(this).attr('placeholder', $(this).attr('data-text'));
  });

  // function to add * to required feild
  // Add Asterisk At Required Feilds

  $('input').each(function () {
    if ($(this).attr('required') === 'required') {
      $(this).after('<span class="asterisk">*</span>')
    }
  });


  // function to confirm message before delete

  $('.confirm').click(function () {
    return confirm('Are You Sure ?');
  });


  // function to hide description or view 

  $('.cat h4').click(function () {
    $(this).next('.full-view').fadeToggle(100);
  });

  $('.view span').click(function () {

    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view')==='full'){
      $('.cat .full-view').fadeIn(100);
      
    }else{
      $('.cat .full-view').fadeOut(100);
    }
  });
});





