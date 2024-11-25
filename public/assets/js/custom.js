
    // "use strict";
    $(".datepicker").flatpickr({dateFormat: "d/m/Y"});


    function textEditor(selector, height = 400) {
      if (!$().summernote) {
          console.warn('summernote is not loaded');
          return;
      }
      $(selector).summernote({
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
          ],
          height:height,
      })
    }
