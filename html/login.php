<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(135deg, #4A00E0, #FF0080);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .input-group-text {
            background: none;
            border: none;
        }
        .login-btn {
            background: linear-gradient(90deg, #3A00E5, #FF0080);
            color: white;
            font-weight: bold;
        }
        .login-btn:hover {
            opacity: 0.8;
        }
        .social-icons a {
            text-decoration: none;
            font-size: 18px;
            color: white;
            padding: 10px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .social-icons a:nth-child(1) { background: #3b5998; }
        .social-icons a:nth-child(2) { background: #1DA1F2; }
        .social-icons a:nth-child(3) { background: #DB4437; }
        .social-icons a:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="login-box">
            <h2>Login</h2>
            <?php include '../php/signup_error.php'; ?>
            <form action="../php/signin.php" method="POST">
            
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Type your username" required>
                </div>
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Type your password" required>
                </div>
                <div class="text-end mb-3">
                    <a href="#" class="text-muted">Forgot password?</a>
                </div>
                <button type="submit" class="btn login-btn w-100">LOGIN</button>
            </form>
            <p class="mt-3">Or Sign Up Using</p>
            <div class="social-icons d-flex justify-content-center gap-3">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
            </div>
            <p class="mt-3">Or Sign Up Using</p>
            <a href="home.html" class="fw-bold text-decoration-none" style="color:#3A00E5;">SIGN UP</a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
