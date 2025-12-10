<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Purchase Order</title>

    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #4e73df 0%, #3a55b4 100%);
            height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .btn-login {
            border-radius: 30px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            background-color: #4e73df;
            border: none;
        }

        .btn-login:hover {
            background-color: #3a55b4;
        }

        h1 {
            font-weight: 700;
            letter-spacing: 1px;
            color: #4e73df;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-8">

                <div class="login-card">
                    
                    <div class="text-center mb-4">
                        <i class="bi bi-shield-lock-fill" style="font-size: 3rem; color:#4e73df;"></i>
                        <h1 class="mt-2">LOGIN</h1>
                    </div>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger"><?= session('error') ?></div>
                    <?php endif ?>

                    <form action="<?= url_to('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <!-- USERNAME / EMAIL -->
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-person-fill text-secondary"></i>
                            </span>
                            <input type="text" class="form-control"
                                   name="login" placeholder="Username atau Email"
                                   value="<?= old('login'); ?>" required>
                        </div>

                        <!-- PASSWORD -->
                        <div class="input-group mb-4">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-lock-fill text-secondary"></i>
                            </span>

                            <input type="password" name="password" 
                                   class="form-control" id="passwordInput"
                                   placeholder="Password" required>

                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye-slash" id="iconPassword"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-login">
                            Login
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </div>

    <script src="<?= base_url('vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

    <script>
        // Show / Hide Password
        $("#togglePassword").click(function () {
            let input = $("#passwordInput");
            let icon  = $("#iconPassword");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("bi-eye-slash").addClass("bi-eye");
            } else {
                input.attr("type", "password");
                icon.removeClass("bi-eye").addClass("bi-eye-slash");
            }
        });
    </script>

</body>
</html>
