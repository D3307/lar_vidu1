@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="register-container" style="background: #fff9fb; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 2rem;">
    <div class="register-card" style="background: white; border-radius: 12px; box-shadow: 0 8px 20px rgba(122, 47, 59, 0.1); width: 100%; max-width: 450px; padding: 2.5rem;">
        <div class="text-center mb-4">
            <h2 style="color: #7a2f3b; font-weight: 700; font-size: 1.8rem; margin-bottom: 0.5rem;">ĐĂNG KÝ TÀI KHOẢN</h2>
            <p style="color: #6b6b6b;">Tạo tài khoản để mua sắm dễ dàng</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background: #e6f7ee; color: #28a745; padding: 0.75rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" style="margin-top: 1.5rem;">
            @csrf
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; color: #7a2f3b; font-weight: 500;">Họ và tên</label>
                <input type="text" name="name" id="name" placeholder="Nhập họ và tên" 
                       style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #eec6d6; border-radius: 8px; transition: all 0.3s;"
                       required>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; color: #7a2f3b; font-weight: 500;">Email</label>
                <input type="email" name="email" id="email" placeholder="Nhập email của bạn" 
                       style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #eec6d6; border-radius: 8px; transition: all 0.3s;"
                       required>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem; position: relative;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: #7a2f3b; font-weight: 500;">Mật khẩu</label>
                <input type="password" name="password" id="password" placeholder="Tối thiểu 6 ký tự" 
                    style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #eec6d6; border-radius: 8px; transition: all 0.3s;"
                    required minlength="6">
                
                <!-- Icon con mắt -->
                <span onclick="togglePassword()" 
                    style="position: absolute; right: 15px; top: 70%; transform: translateY(-50%); cursor: pointer; color: #eec6d6; transition: color 0.3s;">
                    <i id="togglePasswordIcon" class="fas fa-eye"></i>
                </span>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem; position: relative;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: #7a2f3b; font-weight: 500;">Nhập lại mật khẩu</label>
                <input type="password" name="password" id="password" placeholder="Tối thiểu 6 ký tự" 
                    style="width: 100%; padding: 0.8rem 1rem; border: 1px solid #eec6d6; border-radius: 8px; transition: all 0.3s;"
                    required minlength="6">
                
                <!-- Icon con mắt -->
                <span onclick="togglePassword()" 
                    style="position: absolute; right: 15px; top: 70%; transform: translateY(-50%); cursor: pointer; color: #eec6d6; transition: color 0.3s;">
                    <i id="togglePasswordIcon" class="fas fa-eye"></i>
                </span>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <input type="checkbox" id="terms" name="terms" style="margin-right: 0.5rem;" required>
                <label for="terms" style="color: #6b6b6b;">Tôi đồng ý với <a href="#" style="color: #7a2f3b; text-decoration: none;">Điều khoản dịch vụ</a> và <a href="#" style="color: #7a2f3b; text-decoration: none;">Chính sách bảo mật</a></label>
            </div>
            
            <button type="submit" 
                    style="width: 100%; padding: 1rem; background: linear-gradient(90deg, #9d3651 0%, #7a2f3b 100%); color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(122, 47, 59, 0.2);">
                ĐĂNG KÝ
            </button>
        </form>

        <div class="text-center mt-4" style="color: #6b6b6b;">
            Bạn đã có tài khoản? 
            <a href="{{ route('login') }}" style="color: #7a2f3b; font-weight: 600; text-decoration: none;">Đăng nhập ngay</a>
        </div>
        
        <div class="divider" style="margin: 1.5rem 0; text-align: center; position: relative;">
            <span style="background: white; padding: 0 1rem; position: relative; z-index: 1; color: #6b6b6b;">HOẶC</span>
            <hr style="border: none; border-top: 1px solid #eec6d6; position: absolute; top: 50%; left: 0; right: 0; z-index: 0; margin: 0;">
        </div>
        
        <div class="social-login" style="text-align: center;">
            <p style="color: #6b6b6b; margin-bottom: 1rem;">Đăng ký bằng tài khoản mạng xã hội</p>
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