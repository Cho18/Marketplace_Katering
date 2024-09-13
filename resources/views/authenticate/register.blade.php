<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./css/style.css" rel="stylesheet">

    <style>
        /* Custom style to remove underline from the link */
        a.text-danger {
            text-decoration: none;
        }

        /* Optional: Add hover effect to underline when hovered */
        a.text-danger:hover {
            text-decoration: underline;
        }
    </style>

    <title> Register | Marketplace Katering </title>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="login-box-body">
                <p class="login-box-msg">
                    <small> Marketplace Katering </small>
                </p>
                <hr>
                @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session()->has('failed'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('failed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="/register" method="post">
                        @csrf <!-- This is required to prevent CSRF attacks -->
                        
                        <div class="form-group has-feedback">
                            <div class="form-group has-feedback">
                                <label class="control-label" for="name"> Name </label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group field-loginform-username required">
                                <label class="control-label" for="email"> Email </label>
                                <input type="text" name="email" id="email" class="form-control" aria-required="true" autofocus required>
                            </div>
                            
                            <div class="form-group field-loginform-password required mt-3">
                                <label class="control-label" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" aria-required="true" required />
                                    <span class="input-group-text">
                                        <i class="fas fa-eye-slash show-hide"></i>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group field-loginform-username required mt-3">
                                <label class="control-label" for="role_id"> Roles </label>
                                <select class="form-control text-gray-900" name="status" placeholder="jabatan">
                                    <option disabled selected> -- Pilih Roles -- </option>
                                    <option value="Customer">Customer</option>
                                    <option value="Merchant">Merchant</option>
                                </select>                        
                            </div>
                        </div>
                    
                        <div class="row mt-3">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-danger btn-block"> Register </button>
                            </div>
                        </div>
                    
                        <!-- Improved Sign up Section -->
                        <div class="text-center mt-3">
                            <p class="mb-0">Already have an account? 
                                <a href="/login" class="text-danger">Sign in</a>
                            </p>
                        </div>
                    </form>
                    
            </div>
        </div>
    </div>

    <!-- Script to toggle password visibility -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.querySelector(".show-hide");
            const passwordField = document.querySelector("#password");

            togglePassword.addEventListener("click", function () {
                // Toggle the type attribute
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);

                // Toggle the eye icon
                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash");
            });
        });
    </script>
</body>
</html>
