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
        // Pricing
        'cost_per_km' => '10',
        'base_fee' => '0',
        'min_order_cost' => '0',

        // Contact details
        'contact_phone' => '16999',
        'contact_email' => 'support@talba.eg',
        'contact_whatsapp' => '+201000000000',
        'contact_address' => 'القاهرة، جمهورية مصر العربية',
        'contact_hours' => 'يوميًا من 9 صباحًا حتى 11 مساءً',

        // About content
        'about_intro' => 'طلبة منصة شحن وتوصيل مصرية تربط بين المرسل والمستقبل بأسرع وأأمن طريقة. نوصّل شحناتك داخل المدن وبينها باحترافية وشفافية كاملة في التسعير.',
        'about_vision' => 'أن نصبح المنصة الأولى للتوصيل والشحن في مصر والمنطقة، يثق بها كل عميل يبحث عن السرعة والأمان والشفافية.',
        'about_mission' => 'تقديم خدمة توصيل موثوقة وسريعة بأسعار عادلة محسوبة بدقة حسب المسافة، مع تتبع لحظي لكل شحنة ودعم متواصل.',
        'about_terms' => "• يلتزم العميل بإدخال بيانات صحيحة للمرسل والمستقبل وعنوان الاستلام والتسليم.\n• يتم احتساب تكلفة الشحن تلقائيًا حسب المسافة بين نقطتي الاستلام والتسليم.\n• يتم تأكيد الطلب فقط بعد إتمام الدفع الإلكتروني بنجاح.\n• تلتزم طلبة بتوصيل الشحنة في أسرع وقت ممكن مع الحفاظ على سلامتها.\n• الشحنات الممنوعة أو المخالفة للقانون غير مقبولة ويتحمل المرسل مسؤوليتها كاملة.",
        'about_phone' => '16999',
        'about_email' => 'info@talba.eg',
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
