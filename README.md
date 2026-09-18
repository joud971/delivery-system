# الخواجة | Al Khawaja Delivery

نظام إدارة شركة توصيل مبني بـ Laravel 13، ومصمم بواجهة عربية RTL لإدارة الطلبات والسائقين والعملاء والحسابات والتقارير.

## المزايا
- تسجيل دخول باسم المستخدم وكلمة المرور مع حماية من محاولات الدخول المتكررة.
- لوحة تحكم فعلية بإحصائيات مبنية على قاعدة البيانات.
- إدارة الطلبات مع بحث وفلترة وإسناد للسائقين وسجل حالات.
- إدارة العملاء والسائقين والمناطق.
- حسابات مالية مبنية على أجرة التوصيل فقط، مع عدد الطلبات اليومية والمقبوض والمستحقات والمصروفات والربح التقديري.
- تقارير وتصدير CSV.
- مركز إشعارات وسجل عمليات.
- Roles مستقلة: Admin / Manager / Employee / Driver مع مسارات وصلاحيات مختلفة لكل دور.
- Admin وManager: وصول كامل لكل أقسام النظام والعمليات.
- Employee: وصول تشغيلي إلى إدارة الطلبات وإرسال الطلبات فقط.
- Driver: بوابة سائق خاصة لرؤية الطلبات، الإشعارات، قبول الطلب، بدء التوصيل، وإتمام التسليم.
- REST API عبر Sanctum لتطبيق السائق مستقبلًا.
- GPS وتسجيل دوام السائقين في الـbackend.
- واجهة Responsive وRTL.

## المتطلبات
- PHP 8.3+
- Composer 2+
- Node.js 20+ وNPM
- MySQL 8+ أو SQLite

## التشغيل

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

افتح `http://127.0.0.1:8000`.

## حسابات التجربة

| الدور | اسم المستخدم | كلمة المرور |
|---|---|---|
| Admin | `admin` | `password` |
| Manager | `manager` | `password` |
| Employee | `employee` | `password` |
| Driver | `driver` | `password` |

غيّر كلمات المرور قبل استخدام المشروع في بيئة حقيقية.

## API للسائق

- `POST /api/v1/driver/login`
- `GET /api/v1/driver/orders`
- `PATCH /api/v1/driver/orders/{order}/status`
- `POST /api/v1/driver/work-sessions/start`
- `POST /api/v1/driver/work-sessions/{session}/end`
- `POST /api/v1/driver/location`

## GitHub

لا ترفع:
- `.env`
- `vendor/`
- `node_modules/`
- `database/database.sqlite`

## البنية

Laravel 13 + Blade + Tailwind CSS + Alpine.js + MySQL/SQLite + Sanctum + Spatie Permission.
