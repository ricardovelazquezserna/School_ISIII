<!DOCTYPE html>
<html>
    <head>
        <title>Add</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        
        <h2>Search by:</h2>
        </select>
        <input type="text" id="search_name" name="name" placeholder="Name">
        <input type="text" id="student_number_search" name="student_number" placeholder="Student number">
        <select id="semester">          
            <option value="1">1 Semestre</option>
            <option value="2">2 Semestre</option>
            <option value="3">3 Semestre</option>
            <option value="4">4 Semestre</option> 
            <option value="5">5 Semestre</option>
            <option value="6">6 Semestre</option>
            <option value="7">7 Semestre</option>
            <option value="8">8 Semestre</option>
        </select>
        <select id="career"></select>
          <select id="subject"></select>

        <script>
                function search(){
                var formData = {
                    "student_number": $('#student_number').val(),
                    "name": $('#search').val(),
                    "semester": $('#semester').val(),
                    "subject": $('#subject').val(),
                   
                };
                console.log(formData);
                $.ajax({
                    url: "http://localhost/School/api/search",
                    type: 'POST',
                    data: JSON.stringify(formData),
                    dataType: 'json',
                    encode: true
                }).done(function (data) {
                    console.log(data);
                }).fail(function (data) {
                    console.log(data);
                });
            }
            
              
            $.get('http://localhost/School/api/getcareers', function (data) {
                var html_code = '<option value="id">career</option>';
                $.each(data, function (i, career) {
                    var current_html = html_code;
                    current_html = current_html.replace("id", career['id']);
                    current_html = current_html.replace("career", career['name']);
                    $('#career').append(current_html);
                });
            });
             $.get('http://localhost/School/api/getsubjectsearch', function (data) {
                var html_code = '<option value="id">subject</option>';
                $.each(data, function (i, career) {
                    var current_html = html_code;
                    current_html = current_html.replace("id", career['id']);
                    current_html = current_html.replace("subject", career['name']);
                    $('#subject').append(current_html);
                });
            });
        </script>
    </body>
</html>