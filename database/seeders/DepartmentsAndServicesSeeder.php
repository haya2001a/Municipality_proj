<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsAndServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $departments = [
            [
                'name' => 'الكهرباء',
                'description' => 'خدمات الكهرباء مثل اشتراك جديد، نقل عداد، فصل تيار، إلخ',
                'phone' => '0591111111',
                'location' => 'مكتب البلدية الرئيسي',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'المياه',
                'description' => 'خدمات المياه مثل اشتراك، صيانة الشبكة، قراءة العداد، إلخ',
                'phone' => '0592222222',
                'location' => 'مبنى قسم المياه',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'الحرف والصناعات',
                'description' => 'ترخيص وتجديد وإلغاء رخص الحرف والصناعات',
                'phone' => '0593333333',
                'location' => 'مكتب الحرف',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'الرخص التجارية',
                'description' => 'رخصة محل، رخصة مطعم، رخصة صيدلية، إلخ',
                'phone' => '0594444444',
                'location' => 'مكتب الرخص التجارية',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'التراخيص والبناء',
                'description' => 'رخصة بناء، ترميم، هدم',
                'phone' => '0595555555',
                'location' => 'قسم البناء',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'النظافة والبيئة',
                'description' => 'جمع النفايات، تنظيف الشوارع',
                'phone' => '0596666666',
                'location' => 'مكتب البيئة',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'الطرق والمواصلات',
                'description' => 'إشارات المرور، حفر الشوارع',
                'phone' => '0597777777',
                'location' => 'قسم المواصلات',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
            [
                'name' => 'الخدمات الاجتماعية',
                'description' => 'مساعدات، برامج تأهيل',
                'phone' => '0598888888',
                'location' => 'مكتب الخدمات الاجتماعية',
                'working_hours' => json_encode(['السبت-الخميس' => '08:00-16:00'])
            ],
        ];

        foreach ($departments as $deptData) {
            // Create department if it does not exist
            $department = Department::firstOrCreate(
                ['name' => $deptData['name']],
                $deptData
            );

            // Create default services for each department
            switch ($department->name) {
                case 'الكهرباء':
                    $services = ['اشتراك جديد', 'نقل عداد', 'فصل تيار'];
                    break;
                case 'المياه':
                    $services = ['اشتراك مياه', 'صيانة شبكة', 'قراءة عداد'];
                    break;
                case 'الحرف والصناعات':
                    $services = ['ترخيص حرفة', 'تجديد رخصة', 'إلغاء رخصة'];
                    break;
                case 'الرخص التجارية':
                    $services = ['رخصة محل', 'رخصة مطعم', 'رخصة صيدلية'];
                    break;
                case 'التراخيص والبناء':
                    $services = ['رخصة بناء', 'ترميم', 'هدم'];
                    break;
                case 'النظافة والبيئة':
                    $services = ['جمع نفايات', 'تنظيف شوارع'];
                    break;
                case 'الطرق والمواصلات':
                    $services = ['إشارات مرور', 'حفر شوارع'];
                    break;
                case 'الخدمات الاجتماعية':
                    $services = ['مساعدات', 'برامج تأهيل'];
                    break;
                default:
                    $services = [];
            }

            foreach ($services as $serviceName) {
                // Create service if it does not exist
                Service::firstOrCreate(
                    ['name' => $serviceName, 'department_id' => $department->id],
                    [
                        'description' => $serviceName . ' خدمة', 
                        'price' => 0,
                        'processing_time_min' => null,
                        'processing_time_max' => null,
                        'required_documents' => json_encode([]),
                        'terms_conditions' => '',
                        'notes' => '',
                        'status' => 'فعّالة'
                    ]
                );
            }
        }
    }
}
