<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
      <div class="alert alert-danger" id="alert_pass" style="display: none">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong>Warning!</strong> Passwords don't match.
</div>
      <input type="text" autocomplete="on" placeholder="Name" id="name" required="">
      <input type="text" autocomplete="on" placeholder="Lastname" id="lastname" required="">
      <input type="email" autocomplete="on" placeholder="Email" id="email" required="">
      <input type="password" placeholder="Password" id="password" required="">
      <input type="password" autocomplete="on" placeholder="Confirm Password" id="password2" required="">
      <input type="button" value="Log in" onclick="submit()">

    </body>
    <script>

    function submit() {
        var pass = $('#password').val();
        var pass2=$('#password2').val();
        if(pass==pass2){
         var formData = {
              "name": $('#name').val(),
              "last_name": $('#lastname').val(),
              "password": pass,
              "email": $('#email').val()

            };
          console.log(formData);
         $.ajax({
              url: "http://localhost/School/api/newuser",
              type: 'POST',
              data: JSON.stringify(formData),
              dataType: 'json',
              encode: true
          }).done(function (data) {

              console.log(data);
          }).fail(function (data) {
              console.log(data);
          });
        }else {
         $('#alert_pass').show();
        }




    }

    </script>
    </html>
