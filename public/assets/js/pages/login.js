// Importar las utilidades y componentes necesarios
import { validateEmail, validatePassword, togglePasswordVisibility } from '../utils/validation.js';
import Alert from '../components/alert.js';

// Inicializar el componente de alerta
const alert = new Alert('alert-container');

// Obtener referencias a los elementos del DOM
const loginForm = document.getElementById('login-form');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const togglePasswordBtn = document.getElementById('toggle-password');

// Manejar la visibilidad de la contraseña
if (togglePasswordBtn) {
    togglePasswordBtn.addEventListener('click', () => {
        togglePasswordVisibility('password', 'toggle-password');
    });
}

// Manejar el envío del formulario
if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const email = emailInput.value.trim();
        const password = passwordInput.value;

        // Validar campos
        if (!email) {
            alert.show('Por favor ingrese su correo electrónico');
            emailInput.focus();
            return;
        }

        if (!validateEmail(email)) {
            alert.show('Por favor ingrese un correo electrónico válido');
            emailInput.focus();
            return;
        }

        if (!password) {
            alert.show('Por favor ingrese su contraseña');
            passwordInput.focus();
            return;
        }

        if (!validatePassword(password)) {
            alert.show('La contraseña debe tener al menos 6 caracteres');
            passwordInput.focus();
            return;
        }

        try {
            // Aquí se realizará la petición al servidor
            loginForm.submit();
        } catch (error) {
            alert.show('Error al iniciar sesión. Por favor intente nuevamente.');
        }
    });
}