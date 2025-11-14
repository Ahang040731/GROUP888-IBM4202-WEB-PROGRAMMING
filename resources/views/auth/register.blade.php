<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Library System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            overflow: hidden;
        }

        /* Animated Background */
        .auth-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 20px 0;
        }

        /* Animated stars */
        .stars {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }

        /* Mountain silhouettes */
        .mountains {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 40%;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.3) 100%);
            pointer-events: none;
        }

        .mountain-back {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(94, 52, 126, 0.6);
            clip-path: polygon(
                0% 100%, 
                20% 50%, 
                40% 80%, 
                60% 60%, 
                80% 40%, 
                100% 70%, 
                100% 100%
            );
        }

        .mountain-front {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 80%;
            background-color: rgba(70, 40, 100, 0.8);
            clip-path: polygon(
                0% 100%, 
                15% 60%, 
                30% 90%, 
                50% 55%, 
                70% 85%, 
                85% 50%, 
                100% 80%, 
                100% 100%
            );
        }

        /* Trees */
        .trees {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 30%;
            pointer-events: none;
        }

        .tree {
            position: absolute;
            bottom: 0;
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-bottom: 60px solid rgba(50, 30, 80, 0.9);
            animation: sway 4s ease-in-out infinite;
        }

        @keyframes sway {
            0%, 100% { transform: rotate(-1deg); }
            50% { transform: rotate(1deg); }
        }

        /* Register Card */
        .register-card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 40px;
            width: 90%;
            max-width: 480px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out;
            margin: auto;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
        display: flex;
        flex-direction: column;
        align-items: center;    /* centers horizontally */
        /* optional: justify-content: center;  // if you want vertical centering too */
        }
        .register-header img {
        display: block;
        width: 180px;             /* adjust size as needed */
        height: auto;
        margin-bottom: 12px;     /* keep your spacing */
        }

        .register-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .register-subtitle {
            color: #64748b;
            font-size: 0.95rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            color: #475569;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.2rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            margin-top: 24px;
            margin-bottom: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.5);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            color: #64748b;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
            color: #764ba2;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Success/Error Alert */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { width: 33%; background: #ef4444; }
        .strength-medium { width: 66%; background: #f59e0b; }
        .strength-strong { width: 100%; background: #22c55e; }
    </style>
</head>
<body>
    <div class="auth-container" x-data="registerPage()">
        <!-- Animated Background Elements -->
        <div class="stars">
            <!-- Stars will be generated by JavaScript -->
        </div>
        
        <div class="mountains">
            <div class="mountain-back"></div>
            <div class="mountain-front"></div>
        </div>
        
        <div class="trees">
            <!-- Trees will be generated by JavaScript -->
        </div>

        <!-- Register Card -->
        <div class="register-card">
            <div class="register-header">
                <div style="font-size: 3rem; margin-bottom: 12px;"> <img src="{{ asset('images/Books(1).gif') }}"></div>
                <h1 class="register-title">Register</h1>
                <p class="register-subtitle">Create your Library System account</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-error">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" @submit="handleSubmit">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <span class="input-icon">📧</span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <div class="error-message">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-input" 
                            placeholder="Create a password"
                            required
                            x-model="password"
                            @input="checkPasswordStrength"
                        >
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar" :class="strengthClass"></div>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔐</span>
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="form-input" 
                            placeholder="Confirm your password"
                            required
                        >
                    </div>
                    @error('password_confirmation')
                        <div class="error-message">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" :disabled="loading">
                    <span x-show="!loading">Create Account</span>
                    <span x-show="loading" style="display: none;">
                        <span class="spinner"></span>
                    </span>
                </button>

                <!-- Login Link -->
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Generate stars
        function generateStars() {
            const starsContainer = document.querySelector('.stars');
            const starCount = 100;
            
            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 3 + 's';
                starsContainer.appendChild(star);
            }
        }

        // Generate trees
        function generateTrees() {
            const treesContainer = document.querySelector('.trees');
            const treeCount = 20;
            
            for (let i = 0; i < treeCount; i++) {
                const tree = document.createElement('div');
                tree.className = 'tree';
                tree.style.left = (Math.random() * 100) + '%';
                tree.style.animationDelay = Math.random() * 4 + 's';
                
                // Vary tree sizes
                const scale = 0.5 + Math.random() * 1;
                tree.style.transform = `scale(${scale})`;
                tree.style.opacity = 0.3 + Math.random() * 0.4;
                
                treesContainer.appendChild(tree);
            }
        }

        // Alpine.js component
        function registerPage() {
            return {
                loading: false,
                password: '',
                strengthClass: '',
                
                handleSubmit(e) {
                    this.loading = true;
                },
                
                checkPasswordStrength() {
                    const password = this.password;
                    let strength = 0;
                    
                    if (password.length >= 8) strength++;
                    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                    if (/\d/.test(password)) strength++;
                    if (/[@$!%*?&#]/.test(password)) strength++;
                    
                    if (strength <= 1) {
                        this.strengthClass = 'strength-weak';
                    } else if (strength <= 3) {
                        this.strengthClass = 'strength-medium';
                    } else {
                        this.strengthClass = 'strength-strong';
                    }
                }
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            generateStars();
            generateTrees();
        });
    </script>
</body>
</html>