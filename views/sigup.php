<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/index.css">
</head>

<body style="background-image: url(../assets/bg.jpg)">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="container bg-white p-4 shadow">
            <div class="row p-5">
                <div class="col-md-6">
                    <img src="../assets/registration.jpg" alt="skincare">
                </div>
                <div class="col-md-6 mt-5">
                    <h1 class="text-center" style="color: #ff9a9c;">Sign Up</h1>
                    <form action="" id="formRegister" class="mt-5">
                        <div class="form-holder mb-4">
                            <input type="text" placeholder="Name" name="name" class="form-control" style="height: 60px; border-radius: 23.5px; color: grey; background: #f7f7f7;">
                        </div>
                        <div class="form-holder mb-3">
                            <input type="email" placeholder="Email" name="email" class="form-control" style="height: 60px; border-radius: 23.5px; color: grey; background: #f7f7f7;">
                        </div>
                        <div class="form-holder mb-3">
                            <input type="password" placeholder="Password" name="password" class="form-control" style="height: 60px; border-radius: 23.5px; color: grey; background: #f7f7f7;">
                        </div>
                        <div class="d-flex align-items-center ml-5" style="margin-left: 30px;">
                            <button class="btn-sigup" type="submit">Sign up</button>
                            <p class="p-0 m-0 " style="color: grey;">Already Have account? <a href="#">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $("#formRegister").submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let submitButton = $(this).find(':submit');
                submitButton.attr('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "register",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response)
                        submitButton.attr('disabled', false);
                        if (response.message == "Semua kolom harus diisi") {
                            alert('Input tidak boleh kosong')
                        } else {
                            alert('success login');
                            window.location.href = '/usermanagement'
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        submitButton.attr('disabled', false);
                        alert('Failed')
                    }
                });
            });
        });
    </script>
</body>

</html>