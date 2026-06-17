<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    private const CACHE_KEY = 'app_settings';

    /**
     * Default values for every editable setting. These act as a fallback when a
     * row has not been created yet and document the full set of editable keys.
     *
     * @var array<string, string>
     */
    public const DEFAULTS = [
        // Pricing — 20 EGP covers the first 2 km, then 10 EGP per extra km.
        'cost_per_km' => '10',
        'base_fee' => '20',
        'base_distance_km' => '2',
        'min_order_cost' => '0',

        // Contact details
        'contact_phone' => '01068851272',
        'contact_email' => 'melsaprot2001@gmail.com',
        'contact_whatsapp' => '01068851272',
        'contact_address' => 'بلقاس - محافظة الدقهلية، جمهورية مصر العربية',
        'contact_hours' => 'يوميًا من 9 صباحًا حتى 11 مساءً',

        // About content
        'about_intro' => 'مكتب طلبة للشحن والتوصيل السريع داخل محافظة الدقهلية. نربط بين المرسِل والمستلِم بأسرع وأأمن طريقة داخل مراكز ومدن الدقهلية، باحترافية وشفافية كاملة في التسعير.',
        'about_vision' => 'أن نكون الخيار الأول للشحن والتوصيل الداخلي في محافظة الدقهلية، يثق بنا كل عميل يبحث عن السرعة والأمان والشفافية في السعر.',
        'about_mission' => 'تقديم خدمة توصيل سريعة وآمنة داخل الدقهلية بأسعار عادلة محسوبة بدقة حسب المسافة، مع تتبع لحظي لكل شحنة ودعم متواصل.',
        'about_terms' => "• يلتزم العميل بإدخال بيانات صحيحة للمرسِل والمستلِم وعنوان الاستلام والتسليم داخل محافظة الدقهلية.\n• يتم احتساب تكلفة الشحن تلقائيًا حسب المسافة: 20 جنيهًا لأول 2 كيلومتر، ثم 10 جنيهات لكل كيلومتر إضافي.\n• يتم تأكيد الطلب فقط بعد إتمام الدفع الإلكتروني بنجاح.\n• يلتزم مكتب طلبة بتوصيل الشحنة في أسرع وقت ممكن مع الحفاظ على سلامتها.\n• الشحنات الممنوعة أو المخالفة للقانون غير مقبولة، ويتحمل المرسِل مسؤوليتها كاملة.",
        'about_phone' => '01068851272',
        'about_email' => 'melsaprot2001@gmail.com',
    ];

    /**
     * Get a setting value, falling back to the documented default.
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        $all = static::all_cached();

        return $all[$key] ?? $default ?? (self::DEFAULTS[$key] ?? null);
    }

    public static function getFloat(string $key): float
    {
        return (float) static::get($key, self::DEFAULTS[$key] ?? '0');
    }

    /**
     * Persist a setting value and bust the cache.
     */
    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @return array<string, string>
     */
    public static function all_cached(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, static function (): array {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    /**
     * Merge stored values over the defaults so views always get a full set.
     *
     * @return array<string, string>
     */
    public static function allWithDefaults(): array
    {
        return array_merge(self::DEFAULTS, array_filter(
            static::all_cached(),
            static fn ($value) => $value !== null
        ));
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }
}
