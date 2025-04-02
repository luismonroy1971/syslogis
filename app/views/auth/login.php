<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SysLogis</title>
    <link rel="stylesheet" href="<?php echo $this->asset('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('assets/css/components/form.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('assets/css/components/alert.css'); ?>">
    <link rel="stylesheet" href="<?php echo $this->asset('assets/css/auth.css'); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-left">
                <div class="logo-container">
                    <i class="fas fa-hospital-user fa-3x"></i>
                </div>
                <h1>Bienvenido de nuevo</h1>
                <p>Sistema de Gestión de Inventario de Prótesis</p>
            </div>
            <div class="auth-right">

            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <?php echo $this->escape($error); ?>
                </div>
            <?php endif; ?>

            <h2>Iniciar Sesión</h2>
            <p class="auth-subtitle">Ingresa tus credenciales para acceder al sistema</p>

            <form class="auth-form" method="POST" action="<?php echo $this->url('auth/login'); ?>" id="loginForm">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" required 
                               class="form-control" placeholder="Ingrese su correo electrónico">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-group">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" required 
                               class="form-control" placeholder="Ingrese su contraseña">
                        <span class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="form-group remember-me">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember">
                        <span class="checkmark"></span>
                        Recordar sesión
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                    </button>
                </div>
            </form>

            <div class="auth-footer">
                <p>&copy; 2023 Sistema de Gestión. Todos los derechos reservados.</p>
            </div>
        </div>
        </div>
    </div>

    <script src="<?php echo $this->asset('assets/js/utils/validation.js'); ?>"></script>
    <script src="<?php echo $this->asset('assets/js/components/alert.js'); ?>"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            
            if (!email.value.trim() || !password.value.trim()) {
                e.preventDefault();
                showAlert('Por favor ingrese su email y contraseña', 'error');
            }
        });
    </script>
</body>
</html>