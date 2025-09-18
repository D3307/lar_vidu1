@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="login-container" style="background: #fff9fb; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 2rem;">
    <div class="login-card" style="background: white; border-radius: 12px; box-shadow: 0 8px 20px rgba(122, 47, 59, 0.1); width: 100%; max-width: 450px; padding: 2.5rem;">
        <div class="text-center mb-4">
            <h2 style="color: #7a2f3b; font-weight: 700; font-size: 1.8rem; margin-bottom: 0.5rem;">ĐĂNG NHẬP</h2>
            <p style="color: #6b6b6b;">Vui lòng nhập thông tin tài khoản</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; color: #7a2f3b; font-weight: 500;">Email</label>
                <input type="email" name="email" id="email" placeholder="Nhập email của bạn" 
                       style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #eec6d6; border-radius: 8px; transition: all 0.3s;"
                       required>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem; position: relative;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: #7a2f3b; font-weight: 500;">Mật khẩu</label>
                <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" 
                    style="width: 100%; padding: 0.8rem 2.5rem 0.8rem 1rem; border: 1px solid #eec6d6; border-radius: 8px; transition: all 0.3s;"
                    required>
                <!-- Icon con mắt -->
                <span onclick="togglePassword()" 
                    style="position: absolute; right: 10px; top: 65%; transform: translateY(-50%); cursor: pointer; color: #eec6d6; transition: color 0.3s;"
                    onmouseover="this.style.color='#ff3b67'" 
                    onmouseout="this.style.color='#ff3b67'">
                    <i id="togglePasswordIcon" class="fas fa-eye"></i>
                </span>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <input type="checkbox" id="remember" name="remember" style="margin-right: 0.5rem; accent-color: #ff3b67">
                    <label for="remember" style="color: #6b6b6b;">Ghi nhớ đăng nhập</label>
                </div>
                <a href="#" style="color: #7a2f3b; text-decoration: none;">Quên mật khẩu?</a>
            </div>
            
            <button type="submit" 
                    style="width: 100%; padding: 1rem; background: linear-gradient(90deg, #9d3651 0%, #7a2f3b 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(122, 47, 59, 0.2);">
                ĐĂNG NHẬP
            </button>
        </form>

        <div class="text-center mt-4" style="color: #6b6b6b;">
            Bạn chưa có tài khoản? 
            <a href="{{ route('register') }}" style="color: #7a2f3b; font-weight: 600; text-decoration: none;">Đăng ký ngay</a>
        </div>
        
        <div class="social-login mt-4" style="text-align: center;">
            <p style="color: #6b6b6b; margin-bottom: 1rem;">Hoặc đăng nhập bằng</p>
            <div style="display: flex; justify-content: center; gap: 1rem;">
                <a href="#" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #f5f5f5; border-radius: 50%; color: #7a2f3b; text-decoration: none;">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #f5f5f5; border-radius: 50%; color: #7a2f3b; text-decoration: none;">
                    <i class="fab fa-google"></i>
                </a>
            </div>
        </div>
    </div>
</div>


<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("togglePasswordIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
@endsection