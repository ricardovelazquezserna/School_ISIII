<!DOCTYPE html>
<html>
    <head>
        <title>Log in</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="alert alert-danger" id="alert_error" style="display: none">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Warning!</strong> User or Password are incorrect.
        </div>
      <input type="text" autocomplete="on" placeholder="User"  id="user" required="">
      <input type="password" placeholder="Password" id="password" required="">
      <input type="button" value="Log in" onclick="submit()">
    </body>
    <script>
    function submit(){
      var user=$('#user').val();
      var password=$('#password').val();
      console.log(user,password);
    $.get('http://localhost/School/api/getuser', {user,password}, function (data) {


            console.log(data);
        });}

    </script>
    </html>
