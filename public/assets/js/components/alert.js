// Componente de alerta para mostrar mensajes de error o éxito

class Alert {
    constructor(containerId = 'alert-container') {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.id = containerId;
            document.body.appendChild(this.container);
        }
    }

    show(message, type = 'error', duration = 5000) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                ${this.getIconPath(type)}
            </svg>
            ${message}
        `;

        this.container.innerHTML = '';
        this.container.appendChild(alert);

        if (duration > 0) {
            setTimeout(() => {
                this.hide(alert);
            }, duration);
        }

        return alert;
    }

    hide(alert) {
        alert.classList.add('fade-out');
        setTimeout(() => {
            if (alert.parentNode === this.container) {
                this.container.removeChild(alert);
            }
        }, 300);
    }

    getIconPath(type) {
        switch (type) {
            case 'error':
                return '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>';
            case 'success':
                return '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>';
            default:
                return '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>';
        }
    }
}

// Exportar la clase Alert para su uso en otros archivos
export default Alert;