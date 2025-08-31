<?php

return [

    'accepted' => 'يجب قبول :attribute.',
    'active_url' => 'حقل :attribute ليس رابطًا صالحًا.',
    'after' => 'يجب أن يكون تاريخ :attribute بعد :date.',
    'alpha' => 'حقل :attribute يجب أن يحتوي على حروف فقط.',
    'alpha_dash' => 'حقل :attribute يجب أن يحتوي على حروف، أرقام وشرطات فقط.',
    'alpha_num' => 'حقل :attribute يجب أن يحتوي على حروف وأرقام فقط.',
    'array' => 'حقل :attribute يجب أن يكون مصفوفة.',
    'before' => 'يجب أن يكون تاريخ :attribute قبل :date.',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف :attribute بين :min و :max.',
        'array' => 'يجب أن يحتوي :attribute بين :min و :max عناصر.',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون true أو false.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'date' => 'حقل :attribute ليس تاريخًا صالحًا.',
    'email' => 'حقل :attribute يجب أن يكون بريد إلكتروني صالح.',
    'exists' => 'القيمة المختارة ل :attribute غير صالحة.',
    'filled' => 'حقل :attribute مطلوب.',
    'gt' => [
        'numeric' => 'يجب أن تكون قيمة :attribute أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف :attribute أكبر من :value.',
        'array' => 'يجب أن يحتوي :attribute على أكثر من :value عناصر.',
    ],
    'gte' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر من :value.',
        'file' => 'يجب أن يكون حجم الملف :attribute مساوي أو أكبر من :value كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف :attribute مساوي أو أكبر من :value.',
        'array' => 'يجب أن يحتوي :attribute على :value عناصر أو أكثر.',
    ],
    'image' => 'حقل :attribute يجب أن يكون صورة.',
    'in' => 'القيمة المختارة ل :attribute غير صالحة.',
    'integer' => 'حقل :attribute يجب أن يكون رقمًا صحيحًا.',
    'max' => [
        'numeric' => 'لا يجب أن تكون قيمة :attribute أكبر من :max.',
        'file' => 'لا يجب أن يكون حجم الملف :attribute أكبر من :max كيلوبايت.',
        'string' => 'لا يجب أن يكون عدد حروف :attribute أكبر من :max.',
        'array' => 'لا يجب أن يحتوي :attribute على أكثر من :max عناصر.',
    ],
    'min' => [
        'numeric' => 'يجب أن تكون قيمة :attribute على الأقل :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف :attribute على الأقل :min.',
        'array' => 'يجب أن يحتوي :attribute على الأقل :min عناصر.',
    ],

    'not_in' => 'القيمة المختارة ل :attribute غير صالحة.',
    'numeric' => 'حقل :attribute يجب أن يكون رقماً.',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كان :other في :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other.',
    'string' => 'حقل :attribute يجب أن يكون نصًا.',
    'unique' => 'قيمة :attribute مستخدمة من قبل.',
    'url' => 'صيغة رابط :attribute غير صالحة.',

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف',
        'gender' => 'الجنس',
        'national_id' => 'الرقم الوطني',
        'password' => 'كلمة المرور',
        'new_password' => 'كلمة المرور الجديدة',
    ],

];
