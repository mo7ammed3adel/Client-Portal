<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Point all public contact details at the business's real email/phone.
     */
    public function up(): void
    {
        $values = [
            'contact_email' => 'melsaprot2001@gmail.com',
            'contact_phone' => '01068851272',
            'contact_whatsapp' => '01068851272',
            'about_email' => 'melsaprot2001@gmail.com',
            'about_phone' => '01068851272',
        ];

        foreach ($values as $key => $value) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    public function down(): void
    {
        // Intentionally left blank — contact details should not be reverted.
    }
};
