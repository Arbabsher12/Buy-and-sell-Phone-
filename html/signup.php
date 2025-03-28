<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4A00E0, #FF0080);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .signup-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        .input-group .form-control {
            padding-left: 10px;
            padding-right: 40px;
        }
        .input-group-text {
            background: none;
            border: border: 2px inset #EBE9ED;;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
    
            
        }
        .toggle-password i {
            color: #666;
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
    <div class="signup-box">
        <h2>Sign Up</h2>
        
        <?php include '../php/signup_error.php'; ?> <!-- Include error display -->    
          
    
        <form action="../php/register.php" method="POST">
        
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control password" placeholder="Password" required>
                <span class="toggle-password"><i class="fas fa-eye"></i></span>
            </div>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password_confirmation" class="form-control password" placeholder="Confirm Password" required>
                <span class="toggle-password"><i class="fas fa-eye"></i></span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            <p class="mt-3">Or Sign Up Using</p>
            <div class="social-icons d-flex justify-content-center gap-3">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/signup.js"> </script>
</body>
</html>
