<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login & Register - Modern Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body { font-family:'Inter',sans-serif; }
.form-container{position:absolute;top:0;height:100%;transition:all .6s ease-in-out;}
.sign-in-container{left:0;width:50%;z-index:2;}
.sign-up-container{left:0;width:50%;opacity:0;z-index:1;}
.overlay-container{position:absolute;top:0;left:50%;width:50%;height:100%;overflow:hidden;transition:transform .6s ease-in-out;z-index:100;}
.overlay{background:linear-gradient(to right,#2463eb,#5b86e5);background-size:cover;color:#fff;position:relative;left:-100%;height:100%;width:200%;transform:translateX(0);transition:transform .6s ease-in-out;}
.overlay-panel{position:absolute;display:flex;align-items:center;justify-content:center;flex-direction:column;padding:0 40px;text-align:center;top:0;height:100%;width:50%;transition:transform .6s ease-in-out;}
.overlay-left{transform:translateX(-20%);} .overlay-right{right:0;}
#main-container.right-panel-active .sign-in-container{transform:translateX(100%);}
#main-container.right-panel-active .overlay-container{transform:translateX(-100%);}
#main-container.right-panel-active .sign-up-container{transform:translateX(100%);opacity:1;z-index:5;animation:show .6s;}
#main-container.right-panel-active .overlay{transform:translateX(50%);}
#main-container.right-panel-active .overlay-left{transform:translateX(0);}
#main-container.right-panel-active .overlay-right{transform:translateX(20%);}
.floating-label-container{position:relative;margin-bottom:1.5rem;}
.floating-input{width:100%;padding:1rem;background:#fff;border-radius:.5rem;border:1px solid #cbd5e1;outline:none;transition:all .2s;}
.floating-input:focus{border-color:#3b82f6;box-shadow:0 0 0 2px rgba(59,130,246,.3);}
.floating-label{position:absolute;left:1rem;top:.8rem;color:#64748b;pointer-events:none;transition:all .2s;padding:0 .25rem;}
.floating-input:focus + .floating-label,
.floating-input:not(:placeholder-shown)+.floating-label{transform:translateY(-1.7rem) scale(.85);color:#2563eb;background:#fff;}
@keyframes show{0%,49.99%{opacity:0;z-index:1;}50%,100%{opacity:1;z-index:5;}}
@keyframes fade-in-up{from{opacity:0;transform:translateY(15px);}to{opacity:1;transform:translateY(0);}}
.animated{opacity:0;animation:fade-in-up .5s ease-out forwards;}
/* Popup animation */
@keyframes popup{from{transform:scale(.9);opacity:0;}to{transform:scale(1);opacity:1;}}
.animate-popup{animation:popup .3s ease-out forwards;}
</style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-200 text-slate-800 flex justify-center items-center min-h-screen p-4">

<div id="main-container" class="relative overflow-hidden rounded-3xl shadow-2xl bg-white w-full max-w-4xl min-h-[560px] animated">

    {{-- ✅ Error Popup (Global) --}}
    @if ($errors->any())
    <div id="errorPopup" class="fixed inset-0 flex items-center justify-center z-[200] bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl px-10 py-8 text-center max-w-md w-full border border-red-200 animate-popup">
            <div class="text-red-500 mb-4 text-5xl"><i class="fas fa-triangle-exclamation"></i></div>
            <h2 class="text-xl font-semibold text-red-600 mb-3">Terjadi Kesalahan</h2>
            <ul class="text-gray-600 mb-6 list-disc list-inside text-left">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button id="closePopup" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">OK</button>
        </div>
    </div>
    <script>
        document.getElementById('closePopup').addEventListener('click',()=> {
            const popup=document.getElementById('errorPopup');
            popup.style.opacity='0';
            popup.style.transition='opacity .3s ease';
            setTimeout(()=>popup.remove(),300);
        });
    </script>
    @endif

    <!-- Form Pendaftaran -->
    <div class="form-container sign-up-container">
        <form method="POST" action="{{ route('register') }}" class="bg-white flex items-center justify-center flex-col px-12 h-full text-center">
            @csrf
            <div class="w-full">
                <h1 class="text-3xl font-extrabold text-blue-600 mb-6 animated" style="animation-delay: .2s;">🚀 Buat Akun</h1>
                <div class="floating-label-container w-full animated" style="animation-delay: .3s;">
                    <input type="text" name="name" placeholder=" " class="floating-input" value="{{ old('name') }}" required/>
                    <label class="floating-label">Nama Lengkap</label>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="floating-label-container w-full animated" style="animation-delay: .4s;">
                    <input type="email" name="email" placeholder=" " class="floating-input" value="{{ old('email') }}" required/>
                    <label class="floating-label">Email</label>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="floating-label-container w-full animated" style="animation-delay: .5s;">
                    <input type="password" name="password" placeholder=" " class="floating-input" required/>
                    <label class="floating-label">Password</label>
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="floating-label-container w-full animated" style="animation-delay: .6s;">
                    <input type="password" name="password_confirmation" placeholder=" " class="floating-input" required/>
                    <label class="floating-label">Konfirmasi Password</label>
                </div>
                <button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none animated" style="animation-delay:.7s;">Daftar</button>
            </div>
        </form>
    </div>

    <!-- Form Login -->
    <div class="form-container sign-in-container">
        <form method="POST" action="{{ route('login') }}" class="bg-white flex items-center justify-center flex-col px-12 h-full text-center">
            @csrf
            <div class="w-full">
                <h1 class="text-3xl font-extrabold text-blue-600 mb-6 animated" style="animation-delay:.2s;">👋 Selamat Datang!</h1>
                <div class="floating-label-container w-full animated" style="animation-delay:.3s;">
                    <input type="email" name="email" placeholder=" " class="floating-input" value="{{ old('email') }}" required/>
                    <label class="floating-label">Email</label>
                </div>
                <div class="floating-label-container w-full animated" style="animation-delay:.4s;">
                    <input type="password" name="password" placeholder=" " class="floating-input" required/>
                    <label class="floating-label">Password</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-sm text-slate-500 hover:underline mb-4 animated" style="animation-delay:.5s;">Lupa password?</a>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none animated" style="animation-delay:.6s;">Masuk</button>
            </div>
        </form>
    </div>

    <!-- Overlay Container -->
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <div class="animated">
                    <h1 class="text-4xl font-extrabold mb-4">Selamat Datang Kembali!</h1>
                    <p class="text-lg font-light mb-6">Untuk tetap terhubung dengan kami, silakan masuk dengan akun Anda</p>
                    <button id="signIn" class="ghost-button border border-white text-white font-semibold py-3 px-12 rounded-full transition-all duration-300 transform hover:scale-105">Masuk</button>
                </div>
            </div>
            <div class="overlay-panel overlay-right">
                <div class="animated" style="animation-delay:.1s;">
                    <h1 class="text-4xl font-extrabold mb-4">Belum Punya Akun?</h1>
                    <p class="text-lg font-light mb-6">Daftar sekarang dan mulailah perjalanan luar biasa bersama kami</p>
                    <button id="signUp" class="ghost-button border border-white text-white font-semibold py-3 px-12 rounded-full transition-all duration-300 transform hover:scale-105">Daftar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){
    const signUpButton=document.getElementById('signUp');
    const signInButton=document.getElementById('signIn');
    const container=document.getElementById('main-container');
    const triggerAnimations=(panelSelector)=>{
        const elements=document.querySelectorAll(`${panelSelector} .animated`);
        elements.forEach(el=>{el.style.animation='none';el.offsetHeight;el.style.animation='';});
    };
    signUpButton.addEventListener('click',()=>{container.classList.add('right-panel-active');triggerAnimations('.sign-up-container');});
    signInButton.addEventListener('click',()=>{container.classList.remove('right-panel-active');triggerAnimations('.sign-in-container');});
    triggerAnimations('.sign-in-container');
});
</script>
</body>
</html>

