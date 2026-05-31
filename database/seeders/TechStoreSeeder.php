<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Database\Seeders\Data\TechStoreCatalog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TechStoreSeeder extends Seeder
{
    private const ORDER_COUNT = 850;

    private const CUSTOMER_COUNT = 120;

    /** @var array<string, int> */
    private array $categoryIds = [];

    /** @var array<string, int> */
    private array $attributeIds = [];

    /** @var array<string, array<string, int>> */
    private array $optionIds = [];

    /** @var list<int> */
    private array $customerIds = [];

    /** @var list<int> */
    private array $orderableProductIds = [];

    public function run(): void
    {
        DB::transaction(function () {
            $this->seedCategories();
            $this->seedAttributes();
            $this->seedCategoryAttributes();
            $this->seedProducts();
            $this->seedCustomers();
            $this->seedOrders();
        });
    }

    public static function truncateStoreData(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([
            'order_products',
            'orders',
            'customers',
            'product_attribute_option',
            'products',
            'product_category_attribute',
            'product_categories',
            'attribute_options',
            'attributes',
        ] as $table) {
            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }

    private function seedCategories(): void
    {
        foreach (TechStoreCatalog::categories() as $category) {
            $record = ProductCategory::query()->create($category);
            $this->categoryIds[$category['slug']] = $record->id;
        }
    }

    private function seedAttributes(): void
    {
        foreach (TechStoreCatalog::attributes() as $name => $options) {
            $attribute = Attribute::query()->create(['name' => $name]);
            $this->attributeIds[$name] = $attribute->id;
            $this->optionIds[$name] = [];

            foreach ($options as $optionName) {
                $option = AttributeOption::query()->create([
                    'attribute_id' => $attribute->id,
                    'name' => $optionName,
                ]);
                $this->optionIds[$name][$optionName] = $option->id;
            }
        }
    }

    private function seedCategoryAttributes(): void
    {
        foreach (TechStoreCatalog::categoryAttributes() as $categorySlug => $attributeNames) {
            $categoryId = $this->categoryIds[$categorySlug];

            foreach ($attributeNames as $attributeName) {
                DB::table('product_category_attribute')->insert([
                    'product_category_id' => $categoryId,
                    'attribute_id' => $this->attributeIds[$attributeName],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function seedProducts(): void
    {
        foreach (TechStoreCatalog::products() as $productData) {
            $product = Product::query()->create([
                'product_category_id' => $this->categoryIds[$productData['category']],
                'sku' => $productData['sku'],
                'name' => $productData['name'],
                'slug' => $productData['slug'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'is_active' => $productData['is_active'],
            ]);

            if ($productData['is_active'] && $productData['stock'] > 0) {
                $this->orderableProductIds[] = $product->id;
            }

            foreach ($productData['attributes'] as $attributeName => $optionName) {
                $optionId = $this->resolveOptionId($attributeName, $optionName);

                DB::table('product_attribute_option')->insert([
                    'product_id' => $product->id,
                    'attribute_option_id' => $optionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function resolveOptionId(string $attributeName, string $optionName): int
    {
        if (isset($this->optionIds[$attributeName][$optionName])) {
            return $this->optionIds[$attributeName][$optionName];
        }

        $option = AttributeOption::query()->create([
            'attribute_id' => $this->attributeIds[$attributeName],
            'name' => $optionName,
        ]);

        $this->optionIds[$attributeName][$optionName] = $option->id;

        return $option->id;
    }

    private function seedCustomers(): void
    {
        Customer::factory(self::CUSTOMER_COUNT)->create();
        $this->customerIds = Customer::query()->pluck('id')->all();
    }

    private function seedOrders(): void
    {
        $statuses = [
            'delivered' => 62,
            'shipped' => 12,
            'processing' => 8,
            'pending' => 5,
            'cancelled' => 8,
            'refunded' => 5,
        ];

        $paymentMethods = [
            'credit_card' => 45,
            'paypal' => 20,
            'apple_pay' => 15,
            'google_pay' => 12,
            'bank_transfer' => 8,
        ];

        $locations = [
            ['city' => 'New York', 'state' => 'NY', 'zip' => '10001', 'country' => 'US'],
            ['city' => 'Los Angeles', 'state' => 'CA', 'zip' => '90001', 'country' => 'US'],
            ['city' => 'Chicago', 'state' => 'IL', 'zip' => '60601', 'country' => 'US'],
            ['city' => 'Houston', 'state' => 'TX', 'zip' => '77001', 'country' => 'US'],
            ['city' => 'Phoenix', 'state' => 'AZ', 'zip' => '85001', 'country' => 'US'],
            ['city' => 'Philadelphia', 'state' => 'PA', 'zip' => '19101', 'country' => 'US'],
            ['city' => 'San Antonio', 'state' => 'TX', 'zip' => '78201', 'country' => 'US'],
            ['city' => 'San Diego', 'state' => 'CA', 'zip' => '92101', 'country' => 'US'],
            ['city' => 'Dallas', 'state' => 'TX', 'zip' => '75201', 'country' => 'US'],
            ['city' => 'Austin', 'state' => 'TX', 'zip' => '78701', 'country' => 'US'],
            ['city' => 'Seattle', 'state' => 'WA', 'zip' => '98101', 'country' => 'US'],
            ['city' => 'Denver', 'state' => 'CO', 'zip' => '80201', 'country' => 'US'],
            ['city' => 'Boston', 'state' => 'MA', 'zip' => '02101', 'country' => 'US'],
            ['city' => 'Miami', 'state' => 'FL', 'zip' => '33101', 'country' => 'US'],
            ['city' => 'Portland', 'state' => 'OR', 'zip' => '97201', 'country' => 'US'],
            ['city' => 'Atlanta', 'state' => 'GA', 'zip' => '30301', 'country' => 'US'],
            ['city' => 'Toronto', 'state' => 'ON', 'zip' => 'M5H 2N2', 'country' => 'CA'],
            ['city' => 'Vancouver', 'state' => 'BC', 'zip' => 'V6B 1A1', 'country' => 'CA'],
            ['city' => 'London', 'state' => null, 'zip' => 'EC1A 1BB', 'country' => 'GB'],
            ['city' => 'Berlin', 'state' => null, 'zip' => '10115', 'country' => 'DE'],
        ];

        $products = Product::query()
            ->whereIn('id', $this->orderableProductIds)
            ->get(['id', 'price'])
            ->keyBy('id');

        $startDate = now()->subMonths(18)->startOfDay();
        $endDate = now()->endOfDay();

        for ($i = 0; $i < self::ORDER_COUNT; $i++) {
            $createdAt = $this->randomOrderDate($startDate, $endDate);
            $location = fake()->randomElement($locations);
            $lineItemCount = fake()->numberBetween(1, 4);
            $selectedProducts = fake()->randomElements(
                $this->orderableProductIds,
                min($lineItemCount, count($this->orderableProductIds))
            );

            $productsTotal = 0.0;
            $lineItems = [];

            foreach ($selectedProducts as $productId) {
                $product = $products[$productId];
                $quantity = fake()->numberBetween(1, 3);
                $lineTotal = round((float) $product->price * $quantity, 2);
                $productsTotal += $lineTotal;

                $lineItems[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'total' => $lineTotal,
                ];
            }

            $shippingAmount = $productsTotal >= 75 ? 0.0 : fake()->randomElement([4.99, 7.99, 9.99, 12.99]);
            $totalAmount = round($productsTotal + $shippingAmount, 2);
            $status = $this->weightedRandom($statuses);
            $paymentMethod = $this->weightedRandom($paymentMethods);

            $order = Order::query()->create([
                'customer_id' => $this->pickCustomerId(),
                'products_total_amount' => $productsTotal,
                'shipping_amount' => $shippingAmount,
                'total_amount' => $totalAmount,
                'status' => $status,
                'payment_method' => $paymentMethod,
                'delivery_address' => fake()->streetAddress(),
                'city' => $location['city'],
                'state' => $location['state'],
                'zip' => $location['zip'],
                'country' => $location['country'],
                'customer_notes' => fake()->optional(0.12)->sentence(),
                'created_at' => $createdAt,
                'updated_at' => $createdAt->copy()->addHours(fake()->numberBetween(1, 72)),
            ]);

            foreach ($lineItems as $lineItem) {
                OrderProduct::query()->create([
                    'order_id' => $order->id,
                    ...$lineItem,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }

    private function pickCustomerId(): int
    {
        if (fake()->boolean(35) && count($this->customerIds) > 0) {
            return fake()->randomElement($this->customerIds);
        }

        $topCustomers = array_slice($this->customerIds, 0, min(25, count($this->customerIds)));

        return fake()->randomElement($topCustomers);
    }

    private function randomOrderDate(Carbon $startDate, Carbon $endDate): Carbon
    {
        if (fake()->boolean(22)) {
            $year = fake()->numberBetween($startDate->year, $endDate->year);

            return Carbon::create(
                $year,
                fake()->randomElement([11, 12]),
                fake()->numberBetween(1, 28),
                fake()->numberBetween(8, 20),
            );
        }

        return Carbon::instance(fake()->dateTimeBetween($startDate, $endDate));
    }

    /** @param array<string, int> $weights */
    private function weightedRandom(array $weights): string
    {
        $total = array_sum($weights);
        $roll = fake()->numberBetween(1, $total);
        $running = 0;

        foreach ($weights as $value => $weight) {
            $running += $weight;

            if ($roll <= $running) {
                return $value;
            }
        }

        return array_key_first($weights);
    }
}
