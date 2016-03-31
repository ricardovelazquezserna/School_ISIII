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
        <h1>New Student</h1>

        <form action="">
            <input type="text" id="name_add" placeholder="Name">
            <input type="text" id="lastname_add" placeholder="Lastname">
            <input type="text" id="email_add" placeholder="Email">
            <input type="text" id="number_add" placeholder="Cell Phone">
            <input type="text" id="address_add" placeholder="Address">
            <input type="text" id="postal_code" placeholder="Postal Code">
            <select id="campus_select_add">
                <option value="Campus Ensenada">Campus Ensenada</option>
                <option value="Campus Tijuana">Campus Tijuana</option>
                <option value="Campus Mexicali">Campus Mexicali</option>
            </select>
            <select id="career_select_add">               
            </select>
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



            <select id="subject"  data-toggle="tooltip" title="Ctrl + Click to miltiple select" class="form-control" required="" name="subject" multiple></select>
            <input type="button" value="Agregar" onclick="submit()">
        </form>


        <script>
            function submit() {

                var student_number = Math.floor((Math.random() * 10000) + 1);
                var formData = {
                    "name": $('#name_add').val(),
                    "last_name": $('#lastname_add').val(),
                    "semester": $('#semester').val(),
                    "campus": $('#campus_select_add').val(),
                    "address": $('#address_add').val(),
                    "postal_code": $('#postal_code').val(),
                    "email": $('#email_add').val(),
                    "cell_phone": $('#number_add').val(),
                    "student_number": student_number,
                    "career": $('#career_select_add').val()
                };
                console.log(formData);
             /*   $.ajax({
                    url: "http://localhost/School/api/newstudent",
                    type: 'POST',
                    data: JSON.stringify(formData),
                    dataType: 'json',
                    encode: true
                }).done(function (data) {

                    console.log(data);
                }).fail(function (data) {
                    console.log(data);
                });*/
            }
           
            $(document).ready(function () {
                $("#subject").hide();
            });
            $.get('http://localhost/School/api/getcareers', function (data) {
                var html_code = '<option value="id">career</option>';
                $.each(data, function (i, career) {
                    var current_html = html_code;
                    current_html = current_html.replace("id", career['id']);
                    current_html = current_html.replace("career", career['name']);
                    $('#career_select_add').append(current_html);
                });
            });
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
            $(document).ready(function () {
                $("#semester").focusout(function () {
                    var idc = $("#career_select_add").val();
                    var ns = $("#semester").val();
                    console.log(idc,ns);
                    $.get('http://localhost/School/api/getsubjects', {idc,ns}, function (data) {
                        var html_code = '<option value="id">subject</option>';
                        $.each(data, function (i, subject) {
                            var current_html = html_code;
                            current_html = current_html.replace("id", subject['id']);
                            current_html = current_html.replace("subject", subject['name']);
                            $('#subject').append(current_html);
                            console.log(data);
                        });
                        $("#subject").show();
                    });
                });
            });
            
            
            


        </script>

    </body>
</html>
