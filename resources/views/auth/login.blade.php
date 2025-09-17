<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" lang="ar" dir="rtl" id="login-form">
        @csrf

        <!-- National ID -->
        <div class="relative">
            <x-input-label for="national_id" :value="__('رقم الهوية')" />
            <x-text-input id="national_id" class="block mt-1 w-full" type="text" name="national_id" :value="old('national_id')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('national_id')" class="mt-2" />

            <!-- Dropdown لعرض أرقام الهوية -->
            <ul id="id-dropdown" class="hidden absolute bg-white border mt-1 w-full z-50 max-h-40 overflow-auto rounded shadow-lg"></ul>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('كلمة المرور')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300" name="remember">
                <span class="mr-2 text-sm text-gray-600">{{ __('تذكر كلمة المرور') }}</span>
            </label>
        </div>

        @if (Route::has('password.request'))
    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
        {{ __('نسيت كلمة المرور؟') }}
    </a>
@endif
        <!-- Submit Button -->
        <div class="flex items-center justify-center mt-4">
            <x-primary-button class="ms-3">
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nationalIdInput = document.getElementById('national_id');
            const passwordInput = document.getElementById('password');
            const rememberCheckbox = document.getElementById('remember_me');
            const dropdown = document.getElementById('id-dropdown');
            const form = document.getElementById('login-form');

            // جلب بيانات المستخدمين من Local Storage
            let users = JSON.parse(localStorage.getItem('users') || '{}');

            // دالة لإظهار Dropdown (أرقام الهوية فقط)
            function showDropdown() {
                dropdown.innerHTML = '';
                const ids = Object.keys(users);

                if(ids.length > 0){
                    ids.forEach(id => {
                        const li = document.createElement('li');
                        li.textContent = id; // عرض رقم الهوية فقط
                        li.className = 'p-2 cursor-pointer hover:bg-gray-200';
                        li.addEventListener('click', function () {
                            nationalIdInput.value = id;
                            passwordInput.value = users[id]; // وضع الباسورد المخزن
                            dropdown.classList.add('hidden');
                        });
                        dropdown.appendChild(li);
                    });
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.classList.add('hidden');
                }
            }

            // عند التركيز على رقم الهوية → عرض القائمة
            nationalIdInput.addEventListener('focus', function () {
                showDropdown();
            });

            // عند الكتابة → إخفاء القائمة مؤقتًا
            nationalIdInput.addEventListener('input', function () {
                dropdown.classList.add('hidden');
            });

            // عند الضغط خارج الرقم → اخفاء dropdown
            document.addEventListener('click', function(e){
                if(!nationalIdInput.contains(e.target) && !dropdown.contains(e.target)){
                    dropdown.classList.add('hidden');
                }
            });

            // عند تسجيل الدخول
            form.addEventListener('submit', function () {
                const id = nationalIdInput.value.trim();
                const pass = passwordInput.value;

                // فقط إذا تم تفعيل Remember
                if(rememberCheckbox.checked && id && pass){
                    users[id] = pass; // لكل هوية باسورد واحد فقط
                    localStorage.setItem('users', JSON.stringify(users));
                }
            });
        });
    </script>
</x-guest-layout>
