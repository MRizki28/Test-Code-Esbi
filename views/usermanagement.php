<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/index.css">
</head>

<body>

    <div class="container">
        <div class="mt-5">
            <h3 class="mb-3">User Management</h3>
        </div>
        <div>
            <table class="table table-bordered" id="table">
                <thead>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal Edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form mt-4">
                        <form action="" id="formEdit">
                            <input type="hidden" name="id" id="eid">
                            <div class="form-group form-show-validation">
                                <label for="name">Name</label>
                                <input type="text" class="form-control  " required name="name" id="ename">
                            </div>
                            <div class="form-group form-show-validation">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" required name="email" id="eemail">
                            </div>
                            <div class="button-footer d-flex justify-content-between mt-4">
                                <div id="button-reset" class="display-none">
                                    <button class="btn btn-success text-white mr-3 d-flex justify-content-start" id="reset-password-btn">Reset
                                        Password</button>
                                </div>
                                <div class="d-flex justify-content-end align-items-end" style="width: 100%;">
                                    <button type="button" class="btn btn-danger text-white mr-3" data-bs-dismiss="modal" aria-label="Close">Batal</button>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function getAllData() {
                $("#table tbody").empty();
                $.ajax({
                    type: "GET",
                    url: "/user",
                    dataType: "JSON",
                    success: function(response) {
                        let tableBody = "";
                        $.each(response, function(index, value) {
                            tableBody += "<tr>"
                            tableBody += "<td>" + (index + 1) + "</td>"
                            tableBody += "<td>" + value.name + "</td>"
                            tableBody += "<td>" + value.email + "</td>"
                            tableBody +=
                                "<td style='padding: 0 10px !important;'  class='text-left text-center '>" +
                                "<button class='btn btn-primary edit-modal mr-1' data-bs-toggle='modal' data-bs-target='#editModal' data-id='" +
                                value.id + "'>Edit<i class='fas fa-edit'></i></button>" +
                                "<button type='submit' class='delete-confirm btn btn-danger' data-id='" +
                                value.id +
                                "' name='rejected'>Delete<i class='fas fa-trash-alt'></i></button>" +
                                "</td>";
                            tableBody += "</tr>"
                        });
                        $('#table tbody').append(tableBody);
                    }
                });
            }

            getAllData();

            $(document).on('click', '.edit-modal', function() {
                const id = $(this).data('id');
                $('#reset-password-btn').data('id', id);
                console.log(id);
                $.ajax({
                    type: "GET",
                    url: "get/" + id,
                    dataType: "json",
                    success: function(response) {
                        console.log('disini', response)
                        const userData = response[0];
                        $('#eid').val(userData.id);
                        $('#ename').val(userData.name);
                        $('#eemail').val(userData.email);
                    }
                });
            });

            $("#formEdit").submit(function(e) {
                e.preventDefault();
                let id = $('#eid').val();
                console.log("Form submitted for editing, id:", id);
                let formData = new FormData(this);
                let submitButton = $(this).find(':submit');
                submitButton.attr('disabled', true);

                $.ajax({
                    type: "POST",
                    url: "update/" + id,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        submitButton.attr('disabled', false);
                        alert('success update');
                        $('#editModal').modal('hide');
                        getAllData();
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        alert('failed');
                    }
                });
            });

            $(document).on('click', '#reset-password-btn', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const value = $(this).attr('id');
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                console.log(id)
                let data = {
                    _token: csrfToken,
                };
                $('#reset-password-btn').prop(
                    'disabled', true);

                $.ajax({
                    type: "POST",
                    url: "resetpassword/" + id,
                    data: data,
                    dataType: "JSON",
                    success: function(response) {
                        $('#reset-password-btn').prop(
                            'disabled', true);
                        alert('success reset password')
                        $('#editModal').modal('hide');
                    },
                    error: function(error) {
                        alert('failed')
                        console.log(error)
                    }
                });
            });

            $(document).on('click', '.delete-confirm', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: "delete/" + id,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        alert('Success delete')
                        getAllData();
                    }
                });
            });
        });
    </script>
</body>

</html>