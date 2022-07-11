<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- script -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <style>
        .container-2 {
            width: 80%;
            height: 100vh;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2em;
        }

        .email-form {
            width: 100%;
            border: 1px solid rgb(206, 212, 218);
            border-radius: 20px;
            padding: 2em;
        }

        .email-add {
            width: 100%;
        }
    </style>

</head>

<body>

    <!-- Button trigger modal -->


    <!-- Modal -->

    <div class="container container-2">
        <div class="justify-content-center mt-5 email-add">
            <div class="center ">
                <h1> <strong>Bulk Mailing</strong> </h1>
                <p>Sends Email to multiple person</p> <br>
                <p>To add more email address click here</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Add
                </button>
            </div>
        </div>


        <div class="email-form">
            <form id="email-frm">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="Name" class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" id="Name" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="dob" class="form-label">Message</label>
                    <textarea name="message" class="form-control" id="message" rows="4"></textarea>
                </div>
                <button class="btn btn-success mt-3" id="send-btn">
                    Send Email
                </button>
            </form>
        </div>

        <table class="table table-striped table-2">
            <thead>
                <th>Name</th>
                <th>Email</th>
            </thead>
            <tbody id="table-body">

            </tbody>
        </table>

        <!-- send mail section ends -->

        <!-- Modal Section start -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add new email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" id="name" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label for="">Email Address</label>
                                <input type="email" id="emails" class="form-control" name="emails">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="save-btn">Add email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Section end -->


    </div>

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script>
        $(window).on('load', function() {
            getItem();
        })

        function getItem() {
            $.ajax({
                url: "/get-item",
                type: "get",
                dataType: "json",
                success: function(data) {
                    let email = data['email'];
                    let tbody = document.getElementById('table-body');
                    for (let i = 0; i < email.length; i++) {
                        var email_id = email[i]['id'];
                        let template = `<tr>
                                            <td>${email[i]['name']}</td>
                                            <td>${email[i]['emails']}</td>
                                            </tr>`;
                        tbody.innerHTML += template;
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }


        $('#frm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/mail_submit",
                type: 'post',
                data: $('#frm').serialize(),
                success: function(data) {
                    console.log('Email Added');
                    let tbody = document.getElementById('table-body');
                    tbody.innerHTML = "";
                    getItem();
                    $('#exampleModal').modal('hide');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        $('#email-frm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/send_email",
                type: 'post',
                data: $('#email-frm').serialize(),
                success: function(data) {
                    console.log('Successfully Send');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        // $('#send-btn').on('click', function(e) {
        //     e.preventDefault();
        //     $.ajax({
        //         url: "/send_email",
        //         type: "get",
        //         dataType: "json",
        //     });
        // })
    </script>
</body>


</html>