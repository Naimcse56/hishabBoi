
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

    const deleteData = function(title, route, id) {
      Swal.fire({
          title: "Are you sure?",
          text: "You want to delete "+title,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Delete it!"
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  type: 'POST',
                  url: route,
                  data: {
                      _token: APP_TOKEN,
                      id: id,
                  },
                  success: function(response) {
                      Swal.fire({
                          title: "Success",
                          text: title+" Deleted",
                          icon: "success"
                      }).then((result) => {
                          // Check if the user clicked "OK"
                          if (result.isConfirmed) {
                              // Reload the page
                              location.reload();
                          }
                      });
                  },
                  error: function(error) {
                      console.error(error);
                  }
              });
          }
      });
  };
  const approveData = function(title, route, id) {
      Swal.fire({
          title: "Are you sure?",
          text: "You want to approve "+title,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, Approve It!"
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  type: 'POST',
                  url: route,
                  data: {
                      _token: APP_TOKEN,
                      id: id,
                  },
                  success: function(response) {
                      Swal.fire({
                          title: "Success",
                          text: title+" Approved",
                          icon: "success"
                      }).then((result) => {
                          // Check if the user clicked "OK"
                          if (result.isConfirmed) {
                              // Reload the page
                              location.reload();
                          }
                      });
                  },
                  error: function(error) {
                      console.error(error);
                  }
              });
          }
      });
  };
  
  const approveMultipleVoucherData = function(title, route, approval) {
      var selectedLanguage = new Array();
      var rejectNote = new Array();
      if (approval == "reject" || approval == "query") {
          $('input[name="ids"]:checked').each(function() {
              selectedLanguage.push(this.value);
              rejectNote.push($('.'+this.value+'_comment').val());
              console.log($('.'+this.value+'_comment').val());
          });
      } else {
          $('input[name="ids"]:checked').each(function() {
              selectedLanguage.push(this.value);
          });
      }
      if (selectedLanguage.length > 0) {
          Swal.fire({
              title: "Are you sure?",
              text: "You want to "+approval+" "+title,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes!"
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      type: 'POST',
                      url: route,
                      data: {
                          _token: APP_TOKEN,
                          id: selectedLanguage,
                          rejection_comment: rejectNote,
                          approval: approval,
                      },
                      success: function(response) {
                          Swal.fire({
                              title: "Success",
                              text: title+" Approved",
                              icon: "success"
                          }).then((result) => {
                              // Check if the user clicked "OK"
                              if (result.isConfirmed) {
                                  // Reload the page
                                  location.reload();
                              }
                          });
                      },
                      error: function(error) {
                          console.error(error);
                      }
                  });
              }
          });
      } else {
          toastr.error('Select Voucher First!');
      }    
  };
