$(document).ready(function() {
  $("#new_user").validate({
      rules: {
          password: {
              required:true,
          },
          cfmPassword: {
              required:true,
              equalTo: "#password",
          }
      }
  });
});
