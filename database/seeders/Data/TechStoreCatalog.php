<?php

namespace Database\Seeders\Data;

class TechStoreCatalog
{
    public static function categories(): array
    {
        return [
            ['name' => 'Laptops', 'slug' => 'laptops', 'description' => 'Notebooks and ultrabooks for work, school, and gaming.'],
            ['name' => 'Smartphones', 'slug' => 'smartphones', 'description' => 'Android and iOS phones across every price tier.'],
            ['name' => 'Tablets', 'slug' => 'tablets', 'description' => 'Portable tablets for reading, drawing, and media.'],
            ['name' => 'Monitors', 'slug' => 'monitors', 'description' => 'Office, creative, and high-refresh gaming displays.'],
            ['name' => 'Audio', 'slug' => 'audio', 'description' => 'Headphones, earbuds, speakers, and soundbars.'],
            ['name' => 'Peripherals', 'slug' => 'peripherals', 'description' => 'Keyboards, mice, webcams, and desk accessories.'],
            ['name' => 'Networking', 'slug' => 'networking', 'description' => 'Routers, mesh systems, switches, and adapters.'],
            ['name' => 'Components', 'slug' => 'components', 'description' => 'SSDs, RAM kits, GPUs, and PC upgrade parts.'],
        ];
    }

    public static function attributes(): array
    {
        return [
            'Brand' => ['Apple', 'Samsung', 'Dell', 'HP', 'Lenovo', 'ASUS', 'Sony', 'Logitech', 'Anker', 'TP-Link', 'Corsair', 'MSI', 'Google', 'OnePlus', 'LG', 'Crucial', 'Western Digital'],
            'RAM' => ['4GB', '8GB', '16GB', '32GB', '64GB'],
            'Storage' => ['64GB', '128GB', '256GB', '512GB', '1TB', '2TB'],
            'Screen Size' => ['6.1"', '6.7"', '10.9"', '11"', '13"', '14"', '15.6"', '24"', '27"', '32"', '34"'],
            'Color' => ['Black', 'White', 'Silver', 'Space Gray', 'Blue', 'Midnight', 'Starlight'],
            'Connectivity' => ['Wi-Fi 5', 'Wi-Fi 6', 'Wi-Fi 6E', 'Bluetooth 5.0', 'Bluetooth 5.3', 'Ethernet', 'USB-C', 'Thunderbolt 4'],
            'Warranty' => ['1 Year', '2 Years', '3 Years'],
        ];
    }

    /** @return array<string, list<string>> */
    public static function categoryAttributes(): array
    {
        return [
            'laptops' => ['Brand', 'RAM', 'Storage', 'Screen Size', 'Color', 'Warranty'],
            'smartphones' => ['Brand', 'Storage', 'Screen Size', 'Color', 'Warranty'],
            'tablets' => ['Brand', 'Storage', 'Screen Size', 'Color', 'Warranty'],
            'monitors' => ['Brand', 'Screen Size', 'Color', 'Connectivity', 'Warranty'],
            'audio' => ['Brand', 'Color', 'Connectivity', 'Warranty'],
            'peripherals' => ['Brand', 'Color', 'Connectivity', 'Warranty'],
            'networking' => ['Brand', 'Connectivity', 'Warranty'],
            'components' => ['Brand', 'RAM', 'Storage', 'Warranty'],
        ];
    }

    /**
     * @return list<array{
     *   category: string,
     *   sku: string,
     *   name: string,
     *   slug: string,
     *   description: string,
     *   price: float,
     *   stock: int,
     *   is_active: bool,
     *   attributes: array<string, string>
     * }>
     */
    public static function products(): array
    {
        return [
            // Laptops
            ['category' => 'laptops', 'sku' => 'LAP-APL-MBP14-M3', 'name' => 'MacBook Pro 14" M3', 'slug' => 'macbook-pro-14-m3', 'description' => 'Apple Silicon laptop with Liquid Retina XDR display.', 'price' => 1999.00, 'stock' => 42, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '14"', 'Color' => 'Space Gray', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-APL-MBA15-M3', 'name' => 'MacBook Air 15" M3', 'slug' => 'macbook-air-15-m3', 'description' => 'Thin everyday laptop with all-day battery life.', 'price' => 1299.00, 'stock' => 58, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'RAM' => '16GB', 'Storage' => '256GB', 'Screen Size' => '15.6"', 'Color' => 'Midnight', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-DEL-XPS13-9340', 'name' => 'Dell XPS 13 9340', 'slug' => 'dell-xps-13-9340', 'description' => 'Compact premium ultrabook with InfinityEdge display.', 'price' => 1199.00, 'stock' => 31, 'is_active' => true, 'attributes' => ['Brand' => 'Dell', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '13"', 'Color' => 'Silver', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-DEL-INS15-5530', 'name' => 'Dell Inspiron 15 5530', 'slug' => 'dell-inspiron-15-5530', 'description' => 'Affordable 15-inch laptop for everyday productivity.', 'price' => 749.00, 'stock' => 67, 'is_active' => true, 'attributes' => ['Brand' => 'Dell', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '15.6"', 'Color' => 'Silver', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-HP-ENVY14', 'name' => 'HP Envy x360 14', 'slug' => 'hp-envy-x360-14', 'description' => 'Convertible 2-in-1 with touchscreen and stylus support.', 'price' => 899.00, 'stock' => 44, 'is_active' => true, 'attributes' => ['Brand' => 'HP', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '14"', 'Color' => 'Silver', 'Warranty' => '2 Years']],
            ['category' => 'laptops', 'sku' => 'LAP-HP-PAV15', 'name' => 'HP Pavilion 15', 'slug' => 'hp-pavilion-15', 'description' => 'Budget-friendly laptop for students and home office.', 'price' => 599.00, 'stock' => 82, 'is_active' => true, 'attributes' => ['Brand' => 'HP', 'RAM' => '8GB', 'Storage' => '256GB', 'Screen Size' => '15.6"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-LNV-T14-G4', 'name' => 'Lenovo ThinkPad T14 Gen 4', 'slug' => 'lenovo-thinkpad-t14-gen4', 'description' => 'Business laptop with legendary keyboard and durability.', 'price' => 1349.00, 'stock' => 29, 'is_active' => true, 'attributes' => ['Brand' => 'Lenovo', 'RAM' => '32GB', 'Storage' => '1TB', 'Screen Size' => '14"', 'Color' => 'Black', 'Warranty' => '3 Years']],
            ['category' => 'laptops', 'sku' => 'LAP-LNV-IDEAPAD5', 'name' => 'Lenovo IdeaPad Slim 5', 'slug' => 'lenovo-ideapad-slim-5', 'description' => 'Lightweight everyday notebook with fast charging.', 'price' => 679.00, 'stock' => 53, 'is_active' => true, 'attributes' => ['Brand' => 'Lenovo', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '15.6"', 'Color' => 'Blue', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-ASU-ZEN14', 'name' => 'ASUS Zenbook 14 OLED', 'slug' => 'asus-zenbook-14-oled', 'description' => 'Stunning OLED display in a compact aluminum chassis.', 'price' => 999.00, 'stock' => 36, 'is_active' => true, 'attributes' => ['Brand' => 'ASUS', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '14"', 'Color' => 'Blue', 'Warranty' => '2 Years']],
            ['category' => 'laptops', 'sku' => 'LAP-ASU-ROG-G16', 'name' => 'ASUS ROG Strix G16', 'slug' => 'asus-rog-strix-g16', 'description' => 'Gaming laptop with high-refresh display and RTX graphics.', 'price' => 1599.00, 'stock' => 24, 'is_active' => true, 'attributes' => ['Brand' => 'ASUS', 'RAM' => '32GB', 'Storage' => '1TB', 'Screen Size' => '15.6"', 'Color' => 'Black', 'Warranty' => '2 Years']],
            ['category' => 'laptops', 'sku' => 'LAP-MSI-KATANA15', 'name' => 'MSI Katana 15', 'slug' => 'msi-katana-15', 'description' => 'Entry-level gaming laptop with aggressive cooling.', 'price' => 1099.00, 'stock' => 38, 'is_active' => true, 'attributes' => ['Brand' => 'MSI', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '15.6"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'laptops', 'sku' => 'LAP-MSI-PRESTIGE14', 'name' => 'MSI Prestige 14 Evo', 'slug' => 'msi-prestige-14-evo', 'description' => 'Creator-focused ultrabook with color-accurate panel.', 'price' => 1149.00, 'stock' => 0, 'is_active' => false, 'attributes' => ['Brand' => 'MSI', 'RAM' => '16GB', 'Storage' => '512GB', 'Screen Size' => '14"', 'Color' => 'White', 'Warranty' => '1 Year']],

            // Smartphones
            ['category' => 'smartphones', 'sku' => 'PHN-APL-IP15PRO', 'name' => 'iPhone 15 Pro', 'slug' => 'iphone-15-pro', 'description' => 'Titanium design with A17 Pro chip and Pro camera system.', 'price' => 999.00, 'stock' => 95, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'Storage' => '256GB', 'Screen Size' => '6.1"', 'Color' => 'Space Gray', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-APL-IP15', 'name' => 'iPhone 15', 'slug' => 'iphone-15', 'description' => 'Dynamic Island and USB-C in a colorful aluminum frame.', 'price' => 799.00, 'stock' => 110, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'Storage' => '128GB', 'Screen Size' => '6.1"', 'Color' => 'Blue', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-SAM-S24U', 'name' => 'Samsung Galaxy S24 Ultra', 'slug' => 'samsung-galaxy-s24-ultra', 'description' => 'Flagship Android phone with S Pen and 200MP camera.', 'price' => 1299.00, 'stock' => 61, 'is_active' => true, 'attributes' => ['Brand' => 'Samsung', 'Storage' => '256GB', 'Screen Size' => '6.7"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-SAM-A54', 'name' => 'Samsung Galaxy A54', 'slug' => 'samsung-galaxy-a54', 'description' => 'Mid-range phone with smooth 120Hz AMOLED display.', 'price' => 449.00, 'stock' => 140, 'is_active' => true, 'attributes' => ['Brand' => 'Samsung', 'Storage' => '128GB', 'Screen Size' => '6.1"', 'Color' => 'White', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-GGL-P8', 'name' => 'Google Pixel 8', 'slug' => 'google-pixel-8', 'description' => 'Pure Android experience with best-in-class computational photography.', 'price' => 699.00, 'stock' => 73, 'is_active' => true, 'attributes' => ['Brand' => 'Google', 'Storage' => '128GB', 'Screen Size' => '6.1"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-GGL-P8PRO', 'name' => 'Google Pixel 8 Pro', 'slug' => 'google-pixel-8-pro', 'description' => 'Pro-level Pixel with telephoto lens and AI features.', 'price' => 999.00, 'stock' => 48, 'is_active' => true, 'attributes' => ['Brand' => 'Google', 'Storage' => '256GB', 'Screen Size' => '6.7"', 'Color' => 'Blue', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-ONE-12', 'name' => 'OnePlus 12', 'slug' => 'oneplus-12', 'description' => 'Fast-charging flagship with Hasselblad-tuned cameras.', 'price' => 799.00, 'stock' => 55, 'is_active' => true, 'attributes' => ['Brand' => 'OnePlus', 'Storage' => '256GB', 'Screen Size' => '6.7"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-ONE-NORD4', 'name' => 'OnePlus Nord 4', 'slug' => 'oneplus-nord-4', 'description' => 'Value flagship killer with metal unibody design.', 'price' => 499.00, 'stock' => 88, 'is_active' => true, 'attributes' => ['Brand' => 'OnePlus', 'Storage' => '128GB', 'Screen Size' => '6.1"', 'Color' => 'Silver', 'Warranty' => '1 Year']],
            ['category' => 'smartphones', 'sku' => 'PHN-SNY-XPERIA1VI', 'name' => 'Sony Xperia 1 VI', 'slug' => 'sony-xperia-1-vi', 'description' => 'Creator phone with pro video controls and Zeiss optics.', 'price' => 1399.00, 'stock' => 19, 'is_active' => true, 'attributes' => ['Brand' => 'Sony', 'Storage' => '256GB', 'Screen Size' => '6.1"', 'Color' => 'Black', 'Warranty' => '2 Years']],
            ['category' => 'smartphones', 'sku' => 'PHN-APL-IPSE3', 'name' => 'iPhone SE (3rd Gen)', 'slug' => 'iphone-se-3rd-gen', 'description' => 'Compact iPhone with Touch ID and A15 Bionic.', 'price' => 429.00, 'stock' => 0, 'is_active' => false, 'attributes' => ['Brand' => 'Apple', 'Storage' => '64GB', 'Screen Size' => '6.1"', 'Color' => 'White', 'Warranty' => '1 Year']],

            // Tablets
            ['category' => 'tablets', 'sku' => 'TAB-APL-IPADPRO11', 'name' => 'iPad Pro 11" M4', 'slug' => 'ipad-pro-11-m4', 'description' => 'Pro tablet with M4 chip and Apple Pencil Pro support.', 'price' => 999.00, 'stock' => 34, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'Storage' => '256GB', 'Screen Size' => '11"', 'Color' => 'Space Gray', 'Warranty' => '1 Year']],
            ['category' => 'tablets', 'sku' => 'TAB-APL-IPADAIR', 'name' => 'iPad Air M2', 'slug' => 'ipad-air-m2', 'description' => 'Versatile tablet for work and creativity.', 'price' => 599.00, 'stock' => 52, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'Storage' => '128GB', 'Screen Size' => '11"', 'Color' => 'Blue', 'Warranty' => '1 Year']],
            ['category' => 'tablets', 'sku' => 'TAB-SAM-TABS9', 'name' => 'Samsung Galaxy Tab S9', 'slug' => 'samsung-galaxy-tab-s9', 'description' => 'Premium Android tablet with S Pen included.', 'price' => 799.00, 'stock' => 41, 'is_active' => true, 'attributes' => ['Brand' => 'Samsung', 'Storage' => '128GB', 'Screen Size' => '11"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'tablets', 'sku' => 'TAB-LNV-TABP11', 'name' => 'Lenovo Tab P11 Plus', 'slug' => 'lenovo-tab-p11-plus', 'description' => 'Affordable entertainment tablet with quad speakers.', 'price' => 279.00, 'stock' => 76, 'is_active' => true, 'attributes' => ['Brand' => 'Lenovo', 'Storage' => '128GB', 'Screen Size' => '11"', 'Color' => 'Gray', 'Warranty' => '1 Year']],
            ['category' => 'tablets', 'sku' => 'TAB-AMZ-FIREHD10', 'name' => 'Amazon Fire HD 10', 'slug' => 'amazon-fire-hd-10', 'description' => 'Budget tablet for streaming and reading.', 'price' => 139.00, 'stock' => 120, 'is_active' => true, 'attributes' => ['Brand' => 'Amazon', 'Storage' => '32GB', 'Screen Size' => '10.9"', 'Color' => 'Black', 'Warranty' => '1 Year']],
            ['category' => 'tablets', 'sku' => 'TAB-MS-SURFACEGO4', 'name' => 'Microsoft Surface Go 4', 'slug' => 'microsoft-surface-go-4', 'description' => 'Compact Windows tablet for mobile productivity.', 'price' => 579.00, 'stock' => 22, 'is_active' => true, 'attributes' => ['Brand' => 'Microsoft', 'Storage' => '128GB', 'Screen Size' => '10.9"', 'Color' => 'Platinum', 'Warranty' => '1 Year']],

            // Monitors
            ['category' => 'monitors', 'sku' => 'MON-LG-27UP850', 'name' => 'LG UltraFine 27UP850-W', 'slug' => 'lg-ultrafine-27up850-w', 'description' => '4K USB-C monitor for Mac and creative workflows.', 'price' => 549.00, 'stock' => 45, 'is_active' => true, 'attributes' => ['Brand' => 'LG', 'Screen Size' => '27"', 'Color' => 'White', 'Connectivity' => 'USB-C', 'Warranty' => '3 Years']],
            ['category' => 'monitors', 'sku' => 'MON-DEL-U2723QE', 'name' => 'Dell UltraSharp U2723QE', 'slug' => 'dell-ultrasharp-u2723qe', 'description' => '27-inch 4K IPS Black monitor with hub functionality.', 'price' => 619.00, 'stock' => 38, 'is_active' => true, 'attributes' => ['Brand' => 'Dell', 'Screen Size' => '27"', 'Color' => 'Silver', 'Connectivity' => 'USB-C', 'Warranty' => '3 Years']],
            ['category' => 'monitors', 'sku' => 'MON-ASU-PA279CV', 'name' => 'ASUS ProArt PA279CV', 'slug' => 'asus-proart-pa279cv', 'description' => 'Color-accurate 4K display for photo and video editing.', 'price' => 449.00, 'stock' => 33, 'is_active' => true, 'attributes' => ['Brand' => 'ASUS', 'Screen Size' => '27"', 'Color' => 'Black', 'Connectivity' => 'USB-C', 'Warranty' => '3 Years']],
            ['category' => 'monitors', 'sku' => 'MON-SAM-ODYSSEYG7', 'name' => 'Samsung Odyssey G7 32"', 'slug' => 'samsung-odyssey-g7-32', 'description' => 'Curved QHD gaming monitor with 240Hz refresh rate.', 'price' => 699.00, 'stock' => 27, 'is_active' => true, 'attributes' => ['Brand' => 'Samsung', 'Screen Size' => '32"', 'Color' => 'Black', 'Connectivity' => 'HDMI 2.1', 'Warranty' => '1 Year']],
            ['category' => 'monitors', 'sku' => 'MON-BEN-PD2705U', 'name' => 'BenQ PD2705U', 'slug' => 'benq-pd2705u', 'description' => 'Designer monitor with KVM switch and USB-C.', 'price' => 599.00, 'stock' => 21, 'is_active' => true, 'attributes' => ['Brand' => 'BenQ', 'Screen Size' => '27"', 'Color' => 'Black', 'Connectivity' => 'USB-C', 'Warranty' => '3 Years']],
            ['category' => 'monitors', 'sku' => 'MON-APL-STUDIO', 'name' => 'Apple Studio Display', 'slug' => 'apple-studio-display', 'description' => '27-inch 5K Retina display with Center Stage camera.', 'price' => 1599.00, 'stock' => 15, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'Screen Size' => '27"', 'Color' => 'Silver', 'Connectivity' => 'Thunderbolt 4', 'Warranty' => '1 Year']],
            ['category' => 'monitors', 'sku' => 'MON-ASU-VG24VQ', 'name' => 'ASUS TUF VG24VQ', 'slug' => 'asus-tuf-vg24vq', 'description' => 'Budget curved gaming monitor with FreeSync.', 'price' => 179.00, 'stock' => 64, 'is_active' => true, 'attributes' => ['Brand' => 'ASUS', 'Screen Size' => '24"', 'Color' => 'Black', 'Connectivity' => 'DisplayPort', 'Warranty' => '3 Years']],
            ['category' => 'monitors', 'sku' => 'MON-LG-34WP85C', 'name' => 'LG UltraWide 34WP85C-B', 'slug' => 'lg-ultrawide-34wp85c-b', 'description' => '34-inch curved ultrawide for multitasking.', 'price' => 749.00, 'stock' => 18, 'is_active' => true, 'attributes' => ['Brand' => 'LG', 'Screen Size' => '34"', 'Color' => 'Black', 'Connectivity' => 'USB-C', 'Warranty' => '3 Years']],

            // Audio
            ['category' => 'audio', 'sku' => 'AUD-SNY-WH1000XM5', 'name' => 'Sony WH-1000XM5', 'slug' => 'sony-wh-1000xm5', 'description' => 'Industry-leading noise canceling over-ear headphones.', 'price' => 399.00, 'stock' => 87, 'is_active' => true, 'attributes' => ['Brand' => 'Sony', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.3', 'Warranty' => '1 Year']],
            ['category' => 'audio', 'sku' => 'AUD-APL-AIRPODSPRO2', 'name' => 'AirPods Pro (2nd Gen)', 'slug' => 'airpods-pro-2nd-gen', 'description' => 'Active noise cancellation with Adaptive Audio.', 'price' => 249.00, 'stock' => 156, 'is_active' => true, 'attributes' => ['Brand' => 'Apple', 'Color' => 'White', 'Connectivity' => 'Bluetooth 5.3', 'Warranty' => '1 Year']],
            ['category' => 'audio', 'sku' => 'AUD-SAM-BUDS3PRO', 'name' => 'Samsung Galaxy Buds3 Pro', 'slug' => 'samsung-galaxy-buds3-pro', 'description' => 'Premium earbuds with blade-style design and ANC.', 'price' => 249.00, 'stock' => 92, 'is_active' => true, 'attributes' => ['Brand' => 'Samsung', 'Color' => 'Silver', 'Connectivity' => 'Bluetooth 5.3', 'Warranty' => '1 Year']],
            ['category' => 'audio', 'sku' => 'AUD-BOSE-QC45', 'name' => 'Bose QuietComfort 45', 'slug' => 'bose-quietcomfort-45', 'description' => 'Comfortable ANC headphones for travel and focus.', 'price' => 329.00, 'stock' => 61, 'is_active' => true, 'attributes' => ['Brand' => 'Bose', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.1', 'Warranty' => '1 Year']],
            ['category' => 'audio', 'sku' => 'AUD-JBL-FLIP6', 'name' => 'JBL Flip 6', 'slug' => 'jbl-flip-6', 'description' => 'Portable waterproof Bluetooth speaker.', 'price' => 129.00, 'stock' => 134, 'is_active' => true, 'attributes' => ['Brand' => 'JBL', 'Color' => 'Blue', 'Connectivity' => 'Bluetooth 5.1', 'Warranty' => '1 Year']],
            ['category' => 'audio', 'sku' => 'AUD-SNY-HTA7000', 'name' => 'Sony HT-A7000 Soundbar', 'slug' => 'sony-ht-a7000-soundbar', 'description' => '7.1.2 channel Dolby Atmos soundbar system.', 'price' => 1299.00, 'stock' => 12, 'is_active' => true, 'attributes' => ['Brand' => 'Sony', 'Color' => 'Black', 'Connectivity' => 'HDMI eARC', 'Warranty' => '2 Years']],
            ['category' => 'audio', 'sku' => 'AUD-ANK-SOUNDCORE3', 'name' => 'Anker Soundcore Life Q30', 'slug' => 'anker-soundcore-life-q30', 'description' => 'Budget ANC headphones with 40-hour battery.', 'price' => 79.00, 'stock' => 201, 'is_active' => true, 'attributes' => ['Brand' => 'Anker', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '1 Year']],
            ['category' => 'audio', 'sku' => 'AUD-LOG-G733', 'name' => 'Logitech G733 Lightspeed', 'slug' => 'logitech-g733-lightspeed', 'description' => 'Wireless gaming headset with RGB lighting.', 'price' => 149.00, 'stock' => 78, 'is_active' => true, 'attributes' => ['Brand' => 'Logitech', 'Color' => 'White', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '2 Years']],
            ['category' => 'audio', 'sku' => 'AUD-SEN-HD560S', 'name' => 'Sennheiser HD 560S', 'slug' => 'sennheiser-hd-560s', 'description' => 'Open-back audiophile headphones for critical listening.', 'price' => 199.00, 'stock' => 45, 'is_active' => true, 'attributes' => ['Brand' => 'Sennheiser', 'Color' => 'Black', 'Connectivity' => 'Wired 3.5mm', 'Warranty' => '2 Years']],
            ['category' => 'audio', 'sku' => 'AUD-APL-HOMEPODMINI', 'name' => 'HomePod mini', 'slug' => 'homepod-mini', 'description' => 'Smart speaker with Siri and room-filling sound.', 'price' => 99.00, 'stock' => 0, 'is_active' => false, 'attributes' => ['Brand' => 'Apple', 'Color' => 'White', 'Connectivity' => 'Wi-Fi 6', 'Warranty' => '1 Year']],

            // Peripherals
            ['category' => 'peripherals', 'sku' => 'PER-LOG-MXMASTER3S', 'name' => 'Logitech MX Master 3S', 'slug' => 'logitech-mx-master-3s', 'description' => 'Premium wireless mouse for productivity power users.', 'price' => 99.00, 'stock' => 143, 'is_active' => true, 'attributes' => ['Brand' => 'Logitech', 'Color' => 'Graphite', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '1 Year']],
            ['category' => 'peripherals', 'sku' => 'PER-LOG-MXKEYS', 'name' => 'Logitech MX Keys', 'slug' => 'logitech-mx-keys', 'description' => 'Illuminated wireless keyboard for multi-device workflows.', 'price' => 119.00, 'stock' => 98, 'is_active' => true, 'attributes' => ['Brand' => 'Logitech', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '1 Year']],
            ['category' => 'peripherals', 'sku' => 'PER-KEY-K2V2', 'name' => 'Keychron K2 V2', 'slug' => 'keychron-k2-v2', 'description' => 'Compact mechanical keyboard with hot-swappable switches.', 'price' => 89.00, 'stock' => 112, 'is_active' => true, 'attributes' => ['Brand' => 'Keychron', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.1', 'Warranty' => '1 Year']],
            ['category' => 'peripherals', 'sku' => 'PER-RAZ-DEATHADDER', 'name' => 'Razer DeathAdder V3', 'slug' => 'razer-deathadder-v3', 'description' => 'Ultra-light esports gaming mouse.', 'price' => 69.00, 'stock' => 167, 'is_active' => true, 'attributes' => ['Brand' => 'Razer', 'Color' => 'Black', 'Connectivity' => 'USB', 'Warranty' => '2 Years']],
            ['category' => 'peripherals', 'sku' => 'PER-LOG-C920', 'name' => 'Logitech C920 HD Pro Webcam', 'slug' => 'logitech-c920-hd-pro', 'description' => '1080p webcam for streaming and video calls.', 'price' => 79.00, 'stock' => 89, 'is_active' => true, 'attributes' => ['Brand' => 'Logitech', 'Color' => 'Black', 'Connectivity' => 'USB', 'Warranty' => '2 Years']],
            ['category' => 'peripherals', 'sku' => 'PER-ELG-FACECAM', 'name' => 'Elgato Facecam', 'slug' => 'elgato-facecam', 'description' => 'Premium 1080p60 webcam for creators.', 'price' => 169.00, 'stock' => 54, 'is_active' => true, 'attributes' => ['Brand' => 'Elgato', 'Color' => 'Black', 'Connectivity' => 'USB-C', 'Warranty' => '2 Years']],
            ['category' => 'peripherals', 'sku' => 'PER-ANK-737-PD', 'name' => 'Anker 737 Power Bank', 'slug' => 'anker-737-power-bank', 'description' => '24,000mAh portable charger with 140W output.', 'price' => 149.00, 'stock' => 76, 'is_active' => true, 'attributes' => ['Brand' => 'Anker', 'Color' => 'Black', 'Connectivity' => 'USB-C', 'Warranty' => '2 Years']],
            ['category' => 'peripherals', 'sku' => 'PER-LOG-G502X', 'name' => 'Logitech G502 X Plus', 'slug' => 'logitech-g502-x-plus', 'description' => 'RGB wireless gaming mouse with LIGHTFORCE switches.', 'price' => 159.00, 'stock' => 63, 'is_active' => true, 'attributes' => ['Brand' => 'Logitech', 'Color' => 'White', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '2 Years']],
            ['category' => 'peripherals', 'sku' => 'PER-STE-DOCK', 'name' => 'CalDigit TS4 Thunderbolt Dock', 'slug' => 'caldigit-ts4-thunderbolt-dock', 'description' => '18-port Thunderbolt 4 dock for power users.', 'price' => 399.00, 'stock' => 28, 'is_active' => true, 'attributes' => ['Brand' => 'CalDigit', 'Color' => 'Silver', 'Connectivity' => 'Thunderbolt 4', 'Warranty' => '3 Years']],
            ['category' => 'peripherals', 'sku' => 'PER-HP-X4000', 'name' => 'HP Wireless Mouse X4000b', 'slug' => 'hp-wireless-mouse-x4000b', 'description' => 'Basic wireless mouse for office setups.', 'price' => 24.00, 'stock' => 210, 'is_active' => true, 'attributes' => ['Brand' => 'HP', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '1 Year']],
            ['category' => 'peripherals', 'sku' => 'PER-MS-ARC', 'name' => 'Microsoft Arc Mouse', 'slug' => 'microsoft-arc-mouse', 'description' => 'Slim, snap-flat travel mouse.', 'price' => 79.00, 'stock' => 47, 'is_active' => true, 'attributes' => ['Brand' => 'Microsoft', 'Color' => 'Black', 'Connectivity' => 'Bluetooth 5.0', 'Warranty' => '1 Year']],
            ['category' => 'peripherals', 'sku' => 'PER-OLD-MOUSE', 'name' => 'TechStore Basic Mouse (Discontinued)', 'slug' => 'techstore-basic-mouse-discontinued', 'description' => 'Legacy wired mouse — no longer sold.', 'price' => 9.99, 'stock' => 0, 'is_active' => false, 'attributes' => ['Brand' => 'TechStore', 'Color' => 'Black', 'Connectivity' => 'USB', 'Warranty' => '1 Year']],

            // Networking
            ['category' => 'networking', 'sku' => 'NET-TPL-AX6000', 'name' => 'TP-Link Archer AX6000', 'slug' => 'tp-link-archer-ax6000', 'description' => 'Wi-Fi 6 router with 8-stream performance.', 'price' => 299.00, 'stock' => 56, 'is_active' => true, 'attributes' => ['Brand' => 'TP-Link', 'Connectivity' => 'Wi-Fi 6', 'Warranty' => '2 Years']],
            ['category' => 'networking', 'sku' => 'NET-ASU-XT8', 'name' => 'ASUS ZenWiFi XT8 (2-Pack)', 'slug' => 'asus-zenwifi-xt8-2-pack', 'description' => 'Tri-band mesh Wi-Fi system for whole-home coverage.', 'price' => 449.00, 'stock' => 34, 'is_active' => true, 'attributes' => ['Brand' => 'ASUS', 'Connectivity' => 'Wi-Fi 6', 'Warranty' => '3 Years']],
            ['category' => 'networking', 'sku' => 'NET-UBQ-U6LR', 'name' => 'Ubiquiti UniFi U6 Long-Range AP', 'slug' => 'ubiquiti-unifi-u6-lr', 'description' => 'Enterprise-grade Wi-Fi 6 access point.', 'price' => 179.00, 'stock' => 41, 'is_active' => true, 'attributes' => ['Brand' => 'Ubiquiti', 'Connectivity' => 'Wi-Fi 6', 'Warranty' => '1 Year']],
            ['category' => 'networking', 'sku' => 'NET-NET-ORBI760', 'name' => 'Netgear Orbi RBKE963', 'slug' => 'netgear-orbi-rbke963', 'description' => 'Wi-Fi 6E quad-band mesh system for large homes.', 'price' => 1499.00, 'stock' => 9, 'is_active' => true, 'attributes' => ['Brand' => 'Netgear', 'Connectivity' => 'Wi-Fi 6E', 'Warranty' => '1 Year']],
            ['category' => 'networking', 'sku' => 'NET-TPL-SG108', 'name' => 'TP-Link TL-SG108', 'slug' => 'tp-link-tl-sg108', 'description' => '8-port gigabit unmanaged switch.', 'price' => 24.99, 'stock' => 188, 'is_active' => true, 'attributes' => ['Brand' => 'TP-Link', 'Connectivity' => 'Ethernet', 'Warranty' => 'Limited Lifetime']],
            ['category' => 'networking', 'sku' => 'NET-ANK-A7610', 'name' => 'Anker Powerline Adapter Kit', 'slug' => 'anker-powerline-adapter-kit', 'description' => 'Gigabit powerline networking starter kit.', 'price' => 59.00, 'stock' => 72, 'is_active' => true, 'attributes' => ['Brand' => 'Anker', 'Connectivity' => 'Powerline', 'Warranty' => '2 Years']],

            // Components
            ['category' => 'components', 'sku' => 'CMP-SAM-990PRO2TB', 'name' => 'Samsung 990 Pro 2TB NVMe SSD', 'slug' => 'samsung-990-pro-2tb', 'description' => 'PCIe 4.0 NVMe SSD with up to 7,450 MB/s read.', 'price' => 179.00, 'stock' => 124, 'is_active' => true, 'attributes' => ['Brand' => 'Samsung', 'Storage' => '2TB', 'Warranty' => '5 Years']],
            ['category' => 'components', 'sku' => 'CMP-WD-SN850X1TB', 'name' => 'WD Black SN850X 1TB', 'slug' => 'wd-black-sn850x-1tb', 'description' => 'High-performance gaming SSD with heatsink option.', 'price' => 109.00, 'stock' => 98, 'is_active' => true, 'attributes' => ['Brand' => 'Western Digital', 'Storage' => '1TB', 'Warranty' => '5 Years']],
            ['category' => 'components', 'sku' => 'CMP-CRU-32DDR5', 'name' => 'Crucial 32GB DDR5-5600 Kit', 'slug' => 'crucial-32gb-ddr5-5600-kit', 'description' => 'Dual-channel DDR5 memory kit for modern PCs.', 'price' => 89.00, 'stock' => 156, 'is_active' => true, 'attributes' => ['Brand' => 'Crucial', 'RAM' => '32GB', 'Warranty' => 'Limited Lifetime']],
            ['category' => 'components', 'sku' => 'CMP-COR-32DDR5', 'name' => 'Corsair Vengeance 32GB DDR5-6000', 'slug' => 'corsair-vengeance-32gb-ddr5-6000', 'description' => 'Low-latency DDR5 RAM with aluminum heat spreader.', 'price' => 119.00, 'stock' => 87, 'is_active' => true, 'attributes' => ['Brand' => 'Corsair', 'RAM' => '32GB', 'Warranty' => 'Limited Lifetime']],
            ['category' => 'components', 'sku' => 'CMP-NVD-4070SUPER', 'name' => 'NVIDIA GeForce RTX 4070 Super', 'slug' => 'nvidia-geforce-rtx-4070-super', 'description' => '1440p gaming GPU with DLSS 3 and ray tracing.', 'price' => 599.00, 'stock' => 32, 'is_active' => true, 'attributes' => ['Brand' => 'NVIDIA', 'RAM' => '12GB', 'Warranty' => '3 Years']],
            ['category' => 'components', 'sku' => 'CMP-AMD-7800X3D', 'name' => 'AMD Ryzen 7 7800X3D', 'slug' => 'amd-ryzen-7-7800x3d', 'description' => 'Best-in-class gaming CPU with 3D V-Cache.', 'price' => 449.00, 'stock' => 44, 'is_active' => true, 'attributes' => ['Brand' => 'AMD', 'Warranty' => '3 Years']],
            ['category' => 'components', 'sku' => 'CMP-INT-I714700K', 'name' => 'Intel Core i7-14700K', 'slug' => 'intel-core-i7-14700k', 'description' => 'Hybrid architecture CPU for gaming and content creation.', 'price' => 409.00, 'stock' => 51, 'is_active' => true, 'attributes' => ['Brand' => 'Intel', 'Warranty' => '3 Years']],
            ['category' => 'components', 'sku' => 'CMP-CRU-P3PLUS1TB', 'name' => 'Crucial P3 Plus 1TB', 'slug' => 'crucial-p3-plus-1tb', 'description' => 'Budget PCIe 4.0 NVMe drive for everyday upgrades.', 'price' => 69.00, 'stock' => 203, 'is_active' => true, 'attributes' => ['Brand' => 'Crucial', 'Storage' => '1TB', 'Warranty' => '5 Years']],
        ];
    }
}
