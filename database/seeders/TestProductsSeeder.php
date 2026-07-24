<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Webkul\Product\Repositories\ProductRepository;

class TestProductsSeeder extends Seeder
{
    /**
     * Run the test products seeder.
     */
    public function run(): void
    {
        $productRepo = app(ProductRepository::class);

        /**
         * `db:seed` globally unguards models, which would make Eloquent try to
         * write attribute values (name, price, ...) as real columns. Re-enable
         * mass-assignment guarding so only real columns are filled and the
         * attribute value repository handles the rest (same as tinker).
         */
        Model::reguard();

        /**
         * Clean up any previously imported test products so the seeder can be
         * re-run safely (idempotent).
         */
        foreach (DB::table('products')->where('sku', 'like', 'TB-%')->pluck('id') as $id) {
            try {
                $productRepo->delete($id);
            } catch (\Throwable $e) {
                // ignore relation cleanup errors
            }
        }

        /**
         * Create a "Tech Goods" sub-category under the root category (id = 1)
         * so the imported products are browsable on the storefront.
         */
        $catId = 2;

        if (! DB::table('categories')->where('id', $catId)->exists()) {
            DB::table('categories')->insert([
                'id'         => $catId,
                'parent_id'  => 1,
                'position'   => 1,
                'status'     => 1,
                'display_mode' => 'products_and_description',
                '_lft'       => 1,
                '_rgt'       => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('category_translations')->insert([
                [
                    'category_id' => $catId,
                    'locale'      => 'en',
                    'name'        => 'Tech Goods',
                    'slug'        => 'tech-goods',
                    'description' => 'Technology products for testing.',
                ],
                [
                    'category_id' => $catId,
                    'locale'      => 'zh_CN',
                    'name'        => '科技好物',
                    'slug'        => 'tech-goods',
                    'description' => '用于测试的科技类商品。',
                ],
            ]);

            DB::table('channel_categories')->insert([
                'category_id' => $catId,
                'channel_id'  => 1,
            ]);

            $this->command?->info('Created "Tech Goods" category (id = '.$catId.').');
        }

        $products = [
            ['sku' => 'TB-001', 'name' => '量子降噪蓝牙耳机',   'price' => 299.00,  'short' => '主动降噪，Hi-Res 高保真音质。', 'desc' => '采用第三代主动降噪技术，支持 Hi-Res 无损音质与 30 小时续航，带来沉浸式听觉体验。'],
            ['sku' => 'TB-002', 'name' => '智能手表 Pro',       'price' => 899.00,  'short' => 'AMOLED 屏，健康监测全功能。', 'desc' => '1.43 英寸 AMOLED 高清屏，支持心率、血氧、睡眠监测与多种运动模式，5ATM 防水。'],
            ['sku' => 'TB-003', 'name' => '便携固态硬盘 1TB',    'price' => 459.00,  'short' => '读取 1050MB/s，轻巧便携。', 'desc' => '采用 NVMe 协议，顺序读取高达 1050MB/s，金属机身仅 35g，随时随地高速传输。'],
            ['sku' => 'TB-004', 'name' => '机械键盘 青轴',      'price' => 329.00,  'short' => '热插拔轴体，RGB 背光。',     'desc' => '支持全键热插拔，原厂青轴手感清脆，1680 万色 RGB 背光，铝合金上盖。'],
            ['sku' => 'TB-005', 'name' => '4K 高清网络摄像头',   'price' => 199.00,  'short' => '索尼传感器，自动补光。',     'desc' => '搭载索尼 IMX 传感器，支持 4K/30fps 与自动光线校正，会议直播更清晰。'],
            ['sku' => 'TB-006', 'name' => '无线充电器 15W',      'price' => 129.00,  'short' => '磁吸快充，安全温控。',       'desc' => '支持 15W 磁吸无线快充，内置智能温控芯片，过充过压多重保护。'],
            ['sku' => 'TB-007', 'name' => 'USB-C 多功能扩展坞',  'price' => 259.00,  'short' => '七合一，HDMI+PD 充电。',    'desc' => '七合一接口，支持 4K HDMI 输出与 100W PD 供电，铝合金散热外壳。'],
            ['sku' => 'TB-008', 'name' => '电竞鼠标',           'price' => 159.00,  'short' => '26000 DPI，轻量化设计。',   'desc' => '原相旗舰引擎，26000 DPI，59g 轻量化机身，欧姆龙微动经久耐用。'],
            ['sku' => 'TB-009', 'name' => '智能音箱 Mini',       'price' => 349.00,  'short' => '360° 环绕，语音助手。',     'desc' => '360° 环绕声场，内置离线语音助手，支持多设备组网与智能家居控制。'],
            ['sku' => 'TB-010', 'name' => '便携投影仪 1080P',    'price' => 1299.00, 'short' => '自动对焦，内置电池。',       'desc' => '1080P 物理分辨率，全自动对焦与梯形校正，内置大容量电池可户外观影。'],
        ];

        foreach ($products as $p) {
            if (DB::table('products')->where('sku', $p['sku'])->exists()) {
                $this->command?->info('Skip existing product: '.$p['sku']);

                continue;
            }

            $product = $productRepo->create([
                'type'                => 'simple',
                'attribute_family_id' => 1,
                'sku'                 => $p['sku'],
            ]);

            /**
             * Note: `locale` / `channel` are NOT product columns. The attribute
             * value repository falls back to the default channel/locale when they
             * are omitted, so we leave them out of the update payload.
             */
            $productRepo->update([
                'name'               => $p['name'],
                'url_key'            => strtolower($p['sku']),
                'price'              => $p['price'],
                'status'             => 1,
                'new'                => 1,
                'featured'           => 1,
                'visible_individually' => 1,
                'description'        => $p['desc'],
                'short_description'  => $p['short'],
                'weight'             => 0.5,
                'channels'   => [1],
                'categories' => [$catId],
                'inventories' => ['1' => 100],
            ], $product->id);

            $this->command?->info('Created product: '.$p['sku'].' - '.$p['name']);
        }

        $this->command?->info('Test products seeding done. Run: php artisan indexer:index --type=flat --type=price --type=inventory --mode=full');
    }
}
