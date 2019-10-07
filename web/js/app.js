$(function () {
  "use strict";
  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999
  }).disableSelection();
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  $('.sidebar-menu .opened').each(function () {
    $(this).children('a').children('.menu-item-toggle-icon').removeClass('fa-plus-square-o');
    $(this).children('a').children('.menu-item-toggle-icon').addClass('fa-minus-square-o');
    $(this).children('ul').css('display', 'block');
  });

  $('.modal').on('hidden.bs.modal', function () {
    if ($('.lobibox-notify').length) {
      setTimeout(function () {
        window.location.reload();
      }, 1350);
    }
  });

  $('#idRemoveVideoButton').click(function (ev) {
    ev.preventDefault();
    $('#idRemoveVideo').val('1');
    $('#idVideoFileInput').val('');
  });

  $('#idRemoveMobileVideoButton').click(function (ev) {
    ev.preventDefault();
    $('#idRemoveMobileVideo').val('1');
    $('#idMobileVideoFileInput').val('');
  });

  $('#idRemoveFileButton').click(function (ev) {
    ev.preventDefault();
    $('#idRemoveFile').val('1');
    $('#idFileInput').val('');
  });

  function lobiNotify(type, title, msg) {
    Lobibox.notify(type, {
      sound: false,
      position: 'top right',
      delay: 1500,
      showClass: 'fadeInDown',
      title: title,
      msg: msg
    });
  }


  $(document).on("change", "#activate-doubleopt-users", function () {
    var $this = $(this);
    var val;
    var id = $this.closest('tr').data('key');
    if ($(this).is(":checked")) {
      val = 1;
    } else {
      val = 0;
    }
    $.ajax({
      url: '/base/activate-doubleopt-user',
      type: 'POST',
      data: {
        id: id,
        value: val
      },
      success: function (res) {
        if (res == false) {
          lobiNotify('error', 'Activation', 'Changes not Saved');
        } else {
          lobiNotify('success', 'Activation', 'Changes Saved');
          return false;
        }
      },
      error: function (err) {
        lobiNotify('error', 'Hidden Option', 'Changes not Saved');
      }
    });
  });
  $('#date_from,#date_to,#datepicker').datepicker({format: 'dd.mm.yy'});

  //CodeMirror AutoCompletion

  $(document).ready(function () {
    if (document.querySelector('.CodeMirror')) {
      let cm = document.querySelector('.CodeMirror').CodeMirror;
      cm.on('inputRead', function onChange(editor, input) {
        if (input.text[0] === ';' || input.text[0] === ' ') {
          return;
        }
        CodeMirror.commands.autocomplete(cm, null, {completeSingle: false});
      });
    }
  });
});
