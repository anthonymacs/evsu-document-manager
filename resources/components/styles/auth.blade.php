<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        min-height: 100vh;
        font-family: 'Inter', Arial, sans-serif;
        background-image:
            linear-gradient(rgba(0, 0, 0, 0.55),
                rgba(0, 0, 0, 0.55)),
            url("/images/evsu.jpg");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-container,
    .auth-container {
        background: white;
        width: 100%;
        max-width: 440px;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.35);
        overflow: hidden;
    }

    .login-header,
    .auth-header {
        background: #6b0f1a;
        color: white;
        padding: 32px 24px;
        text-align: center;
    }

    .login-header h1,
    .auth-header h1 {
        font-size: 1.7rem;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .login-header p,
    .auth-header p {
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .form-content {
        padding: 32px 28px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    input[type="email"],
    input[type="password"],
    input[type="text"] {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
        outline: none;
        border-color: #6b0f1a;
        box-shadow: 0 0 0 3px rgba(107, 15, 26, 0.15);
    }

    input[type="email"].error,
    input[type="password"].error,
    input[type="text"].error {
        border-color: #dc2626;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .remember-me input[type="checkbox"] {
        width: auto;
        cursor: pointer;
        accent-color: #6b0f1a;
    }

    .remember-me label {
        margin: 0;
        cursor: pointer;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .login-btn,
    .auth-btn {
        width: 100%;
        padding: 13px;
        background: #6b0f1a;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.25s ease;
    }

    .login-btn:hover:not(:disabled),
    .auth-btn:hover:not(:disabled) {
        background: #540c15;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(107, 15, 26, 0.3);
    }

    .login-btn:disabled,
    .auth-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .auth-link {
        text-align: center;
        margin-top: 16px;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .auth-link a {
        color: #6b0f1a;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .auth-link a:hover {
        color: #540c15;
        text-decoration: underline;
    }

    .footer,
    .auth-footer {
        text-align: center;
        padding: 18px;
        font-size: 0.8rem;
        color: #6b7280;
        border-top: 1px solid #f3f4f6;
    }

    /* Loading spinner */
    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Responsive */
    @media (max-width: 480px) {

        .login-container,
        .auth-container {
            border-radius: 0;
            box-shadow: none;
        }

        .login-header h1,
        .auth-header h1 {
            font-size: 1.4rem;
        }

        .form-content {
            padding: 24px 20px;
        }
    }



    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .password-input-wrapper input {
        padding-right: 2.5rem;
        /* Space for the eye icon */
        width: 100%;
    }

    .password-toggle-btn {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        /* gray-400 */
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .password-toggle-btn:hover {
        color: #6b7280;
        /* gray-500 */
    }

    .password-toggle-btn:focus {
        outline: none;
    }

    /* Hide x-cloak elements until Alpine is loaded */
    [x-cloak] {
        display: none !important;
    }

    .auth-header {
        margin-bottom: 2rem;
    }

    .auth-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .auth-header-text {
        flex: 1;
    }

    .auth-header h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 0.5rem 0;
        line-height: 1.2;
    }

    .auth-header p {
        font-size: 1rem;
        color: #6b7280;
        margin: 0;
    }

    .auth-header-logo {
        flex-shrink: 0;
    }

    .header-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    /* Responsive Design */
    @media (max-width: 640px) {
        .auth-header-content {
            flex-direction: column;
            text-align: center;
        }

        .auth-header h1 {
            font-size: 1.5rem;
        }

        .auth-header p {
            font-size: 0.875rem;
        }

        .header-logo {
            width: 60px;
            height: 60px;
        }
    }

   .auth-header {
    margin-bottom: 2rem;
}

.auth-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.auth-header-logo {
    flex-shrink: 0;
}

.auth-header {
    margin-bottom: 2rem;
}

.auth-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.auth-header-logo {
    flex-shrink: 0;
}

.header-logo {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #f3f4f6;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.auth-header-text {
    flex: 1;
    text-align: left;
}

.auth-header h1 {
    font-size: 1.875rem;
    font-weight: 700;
    color: #f1f1f2;
    margin: 0 0 0.5rem 0;
    line-height: 1.2;
}

.auth-header p {
    font-size: 1rem;
    color: #e3e7ef;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 640px) {
    .auth-header-content {
        flex-direction: column;
        text-align: center;
    }

    .auth-header-text {
        text-align: center;
    }

    .auth-header h1 {
        font-size: 1.5rem;
    }

    .auth-header p {
        font-size: 0.875rem;
    }

    .header-logo {
        width: 60px;
        height: 60px;
    }
}

.sidebar-logo {
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.sidebar-logo:hover {
    border-color: rgba(255, 255, 255, 0.6);
    transform: scale(1.05);
}

</style>