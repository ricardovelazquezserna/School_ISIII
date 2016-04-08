<!DOCTYPE html>
<html>
    <head>
        <title>Search</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>

        <h2>Search by:</h2>
        </select>
        <select id="name_student_select">
         <option value="" disabled selected>Select name</option>
       </select>
        <select id="student_number_select">
 <option value="" disabled selected>Select student number</option>
        </select>

        <select id="semester">
           <option value="" disabled selected>Select semester</option>
            <option value="1">1 Semestre</option>
            <option value="2">2 Semestre</option>
            <option value="3">3 Semestre</option>
            <option value="4">4 Semestre</option>
            <option value="5">5 Semestre</option>
            <option value="6">6 Semestre</option>
            <option value="7">7 Semestre</option>
            <option value="8">8 Semestre</option>
        </select>
        <select id="career">
            <option value="" disabled selected>Select career</option>
        </select>
        <select id="subject">
            <option value="" disabled selected>Select subject</option>
        </select>
          <input type="button" value="Search" onclick="search()">

          <table id="table_for_results" display>
            <tr>
               <th>Firstname</th>
               <th>Lastname</th>
               <th>Student number</th>
               <th>Semester </th>
               <th>Campus</th>
               <th>Career</th>
             </tr>

</table>



        <script>
                function search(){
                  var id = $('#name_student_select').val();
                  var number = $('#student_number_select').val();
                  var semester = $('#semester').val();
                  var career = $('#career').val();
                  var subject = $('#subject').val();
                  $.get('http://localhost/School/api/getsearch',{id,number,semester,career,subject}, function (data) {
                          var html_code = '<th><td>name lastname number semester campus career</td></th>';
                          $.each(data, function (i, student) {
                              var current_html = html_code;
                              current_html = current_html.replace("name", student['name']);
                              current_html = current_html.replace("lastname", student['last_name']);
                              $('#student_number_select').append(current_html);
                          });
                    });
                    console.log(data);
                      


            }

            $.get('http://localhost/School/api/getstudentnumber', function (data) {
                var html_code = '<option value="number">number</option>';
                $.each(data, function (i, number) {
                    var current_html = html_code;
                    current_html = current_html.replace("number", number['student_number']);
                    current_html = current_html.replace("number", number['student_number']);
                    $('#student_number_select').append(current_html);
                });
            });

            $.get('http://localhost/School/api/getnamestudents', function (data) {
                var html_code = '<option value="id">name</option>';
                $.each(data, function (i,name) {
                    var current_html = html_code;
                    current_html = current_html.replace("id", name['id']);
                    current_html = current_html.replace("name", name['name']);
                    $('#name_student_select').append(current_html);
                });
            });
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
                $.each(data, function (i, subject) {
                    var current_html = html_code;
                    current_html = current_html.replace("id", subject['id']);
                    current_html = current_html.replace("subject", subject['name']);
                    $('#subject').append(current_html);
                });
            });
        </script>
    </body>
</html>
