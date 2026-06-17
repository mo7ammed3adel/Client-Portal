<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Switch to the "مكتب طلبة" domestic Dakahlia model and the new pricing
     * (20 EGP for the first 2 km, then 10 EGP per extra km).
     */
    public function up(): void
    {
        $values = [
            'cost_per_km' => '10',
            'base_fee' => '20',
            'base_distance_km' => '2',
            'min_order_cost' => '0',
            'contact_address' => 'بلقاس - محافظة الدقهلية، جمهورية مصر العربية',
            'about_intro' => 'مكتب طلبة للشحن والتوصيل السريع داخل محافظة الدقهلية. نربط بين المرسِل والمستلِم بأسرع وأأمن طريقة داخل مراكز ومدن الدقهلية، باحترافية وشفافية كاملة في التسعير.',
            'about_vision' => 'أن نكون الخيار الأول للشحن والتوصيل الداخلي في محافظة الدقهلية، يثق بنا كل عميل يبحث عن السرعة والأمان والشفافية في السعر.',
            'about_mission' => 'تقديم خدمة توصيل سريعة وآمنة داخل الدقهلية بأسعار عادلة محسوبة بدقة حسب المسافة، مع تتبع لحظي لكل شحنة ودعم متواصل.',
            'about_terms' => "• يلتزم العميل بإدخال بيانات صحيحة للمرسِل والمستلِم وعنوان الاستلام والتسليم داخل محافظة الدقهلية.\n• يتم احتساب تكلفة الشحن تلقائيًا حسب المسافة: 20 جنيهًا لأول 2 كيلومتر، ثم 10 جنيهات لكل كيلومتر إضافي.\n• يتم تأكيد الطلب فقط بعد إتمام الدفع الإلكتروني بنجاح.\n• يلتزم مكتب طلبة بتوصيل الشحنة في أسرع وقت ممكن مع الحفاظ على سلامتها.\n• الشحنات الممنوعة أو المخالفة للقانون غير مقبولة، ويتحمل المرسِل مسؤوليتها كاملة.",
        ];

        foreach ($values as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    public function down(): void
    {
        // Intentionally left blank.
    }
};
