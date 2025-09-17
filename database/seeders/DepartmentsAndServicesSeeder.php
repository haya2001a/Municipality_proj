<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Database\Seeder;

class DepartmentsAndServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // قسم الكهرباء
        $electricity = Department::create([
            'name' => 'قسم الكهرباء',
            'description' => 'جميع خدمات الكهرباء (اشتراكات، نقل، فحص، شبكات)',
            'phone' => '02-2222222',
            'location' => 'مبنى البلدية - الطابق الأول',
            'working_hours' => json_encode(['الأحد-الخميس' => '8:00-14:00']),
        ]);

        // خدمات الكهرباء
        $services = [
            [
                'name' => 'طلب إنارة',
                'description' => 'تقديم طلب إنارة جديدة',
                'processing_time' => 3,
                'required_documents' => [],
                'notes' => 'المسار: مركز خدمات الجمهور → قسم الكهرباء → مركز خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'طلب اشتراك 1 فاز جديد',
                'description' => 'اشتراك كهرباء منزلي 1 فاز',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → الأقسام الهندسية → قسم الكهرباء → الدائرة المالية → وحدة خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'طلب اشتراك 3 فاز جديد',
                'description' => 'اشتراك كهرباء 3 فاز',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → الأقسام الهندسية → قسم الكهرباء → الدائرة المالية',
            ],
            [
                'name' => 'نقل اشتراك كهرباء',
                'description' => 'نقل اشتراك كهرباء من موقع لآخر',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → الأقسام الهندسية → قسم الكهرباء → الدائرة المالية → وحدة خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'تفعيل اشتراك كهرباء',
                'description' => 'إعادة تفعيل اشتراك كهرباء قائم',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: الأقسام الهندسية → مركز خدمات الجمهور → قسم الكهرباء → الدائرة المالية → وحدة خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'تحويل اشتراك كهرباء',
                'description' => 'تحويل ملكية اشتراك كهرباء',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → الأقسام الهندسية → قسم الكهرباء → الدائرة المالية → وحدة خدمات الجمهور',
            ],
            [
                'name' => 'رفع أمبيرات',
                'description' => 'زيادة قدرة الاشتراك الكهربائي',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → الأقسام الهندسية → الدائرة المالية → قسم الكهرباء → وحدة خدمات الجمهور',
            ],
            [
                'name' => 'طلب ربط نظام شمسي',
                'description' => 'ربط نظام شمسي بالاشتراك',
                'processing_time' => 6,
                'required_documents' => ['صورة هوية', 'رخصة بناء (إن وجدت)', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → الأقسام الهندسية → قسم الكهرباء → الدائرة المالية → وحدة خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'نقل أعمدة',
                'description' => 'طلب نقل أعمدة كهرباء',
                'processing_time' => 7,
                'required_documents' => [],
                'notes' => 'المسار: مركز خدمات الجمهور → قسم الكهرباء → مركز خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'نقل شبكات',
                'description' => 'طلب نقل شبكات كهرباء',
                'processing_time' => 7,
                'required_documents' => [],
                'notes' => 'المسار: مركز خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'فحص عداد',
                'description' => 'طلب فحص عداد كهرباء',
                'processing_time' => 3,
                'required_documents' => [],
                'notes' => 'المسار: قسم الكهرباء → مركز خدمات الجمهور → مركز خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'وصلة مؤقتة',
                'description' => 'طلب توصيل وصلة كهرباء مؤقتة',
                'processing_time' => 3,
                'required_documents' => [],
                'notes' => 'المسار: مركز خدمات الجمهور → قسم الكهرباء',
            ],
            [
                'name' => 'التنازل عن اشتراك كهرباء',
                'description' => 'التنازل عن اشتراك كهرباء',
                'processing_time' => 5,
                'required_documents' => ['صورة هوية', 'براءة ذمة'],
                'notes' => 'المسار: مركز خدمات الجمهور → قسم الكهرباء → الدائرة المالية',
            ],
            [
                'name' => 'إيقاف اشتراك كهرباء',
                'description' => 'طلب إيقاف مؤقت أو دائم للاشتراك',
                'processing_time' => 5,
                'required_documents' => ['صورة هوية'],
                'notes' => 'المسار: مركز خدمات الجمهور → قسم الكهرباء → الدائرة المالية → وحدة خدمات الجمهور',
            ],
        ];

        foreach ($services as $srv) {
            Service::create([
                'name' => $srv['name'],
                'department_id' => $electricity->id,
                'description' => $srv['description'],
                'price' => 0,
                'processing_time' => $srv['processing_time'],
                'required_documents' => json_encode($srv['required_documents']),
                'notes' => $srv['notes'],
                'status' => 'فعّالة',
            ]);
        }

        // قسم المياه
        $water = Department::create([
            'name' => 'قسم المياه',
            'description' => 'جميع خدمات المياه (اشتراكات، تفعيل، إيقاف، نقل)',
            'phone' => '02-3333333',
            'location' => 'مبنى البلدية - الطابق الثاني',
            'working_hours' => json_encode(['الأحد-الخميس' => '8:00-14:00']),

        ]);

        // خدمات المياه
        $waterServices = [
            [
                'name' => 'اشتراك مياه جديد',
                'description' => 'طلب اشتراك مياه جديد',
                'processing_time' => 14,
                'required_documents' => ['صورة هوية شخصية'],
                'notes' => 'المسار: مركز خدمات الجمهور → دائرة الهندسة → دائرة الخدمات والصحة (قسم المياه) → الدائرة المالية → مركز خدمات الجمهور → قسم المياه',
            ],
            [
                'name' => 'تفعيل اشتراك مياه',
                'description' => 'إعادة تفعيل اشتراك مياه',
                'processing_time' => 14,
                'required_documents' => ['صورة هوية شخصية'],
                'notes' => 'المسار: مركز خدمات الجمهور → دائرة الهندسة → دائرة الخدمات والصحة (قسم المياه) → الدائرة المالية → مركز خدمات الجمهور → قسم المياه',
            ],
            [
                'name' => 'إيقاف اشتراك مياه',
                'description' => 'طلب إيقاف اشتراك مياه',
                'processing_time' => 7,
                'required_documents' => ['صورة هوية شخصية'],
                'notes' => 'المسار: مركز خدمات الجمهور → دائرة الخدمات والصحة (قسم المياه) → الدائرة المالية → مركز خدمات الجمهور → قسم المياه',
            ],
            [
                'name' => 'تنازل عن اشتراك مياه',
                'description' => 'التنازل عن اشتراك مياه',
                'processing_time' => 7,
                'required_documents' => ['صورة هوية شخصية'],
                'notes' => 'المسار: مركز خدمات الجمهور → دائرة الهندسة → دائرة الخدمات والصحة (قسم المياه) → الدائرة المالية → مركز خدمات الجمهور → قسم المياه',
            ],
            [
                'name' => 'نقل اشتراك مياه',
                'description' => 'نقل اشتراك مياه في نفس الموقع',
                'processing_time' => 7,
                'required_documents' => ['صورة هوية شخصية'],
                'notes' => 'المسار: مركز خدمات الجمهور → دائرة الهندسة → دائرة الخدمات والصحة (قسم المياه) → الدائرة المالية → مركز خدمات الجمهور → قسم المياه',
            ],
        ];

        foreach ($waterServices as $srv) {
            Service::create([
                'name' => $srv['name'],
                'department_id' => $water->id,
                'description' => $srv['description'],
                'price' => 0,
                'processing_time' => $srv['processing_time'],
                'required_documents' => json_encode($srv['required_documents']),
                'notes' => $srv['notes'],
                'status' => 'فعّالة',
            ]);
        }
    }
}
