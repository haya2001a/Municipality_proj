<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تم إنشاء الحساب</title>
</head>
<body>
    <h2>مرحباً {{ $user->name }}</h2>

    <p>تم إنشاء حسابك في <strong>بلدية السموع</strong> بنجاح.</p>

    <p><strong>اسم المستخدم (الهوية):</strong> {{ $user->national_id }}</p>
    <p><strong>كلمة المرور:</strong> {{ $user->national_id  }}</p>

    <p>نرجو منك تغيير كلمة المرور بعد تسجيل الدخول لأول مرة.</p>

    <p>مع تحياتنا،  
    <br>بلدية السموع</p>
</body>
</html>
