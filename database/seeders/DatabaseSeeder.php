<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Delivery;
use App\Models\FarmerProfile;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // -----------------------------------------------------------------
        // Users
        // -----------------------------------------------------------------

        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // --- Farmers (active) ---
        $farmer = User::create([
            'name' => 'Juan dela Cruz',
            'email' => 'farmer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'phone' => '09171234567',
            'address' => 'Barangay San Isidro, Tandag City',
            'status' => 'active',
        ]);
        FarmerProfile::create([
            'user_id' => $farmer->id,
            'farm_name' => 'Dela Cruz Farm',
            'farm_location' => 'Tandag City, Surigao del Sur',
            'bio' => 'Growing rice, corn, and vegetables for over 15 years.',
        ]);

        $farmer2 = User::create([
            'name' => 'Rosa Villanueva',
            'email' => 'rosa.farmer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'phone' => '09172223344',
            'address' => 'Barangay Mabua, Bislig City',
            'status' => 'active',
        ]);
        FarmerProfile::create([
            'user_id' => $farmer2->id,
            'farm_name' => 'Villanueva Orchards',
            'farm_location' => 'Bislig City, Surigao del Sur',
            'bio' => 'Family-run orchard specializing in tropical fruit.',
        ]);

        $farmer3 = User::create([
            'name' => 'Ernesto Bagon',
            'email' => 'ernesto.farmer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'phone' => '09173334455',
            'address' => 'Barangay Lawigan, Tandag City',
            'status' => 'active',
        ]);
        FarmerProfile::create([
            'user_id' => $farmer3->id,
            'farm_name' => 'Bagon Root Crop Farm',
            'farm_location' => 'Tandag City, Surigao del Sur',
            'bio' => 'Root crops and leafy greens grown without synthetic pesticides.',
        ]);

        // --- Suppliers (active) ---
        $supplier = User::create([
            'name' => 'AgriSupply Co.',
            'email' => 'supplier@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '09181234567',
            'address' => 'Butuan City, Agusan del Norte',
            'status' => 'active',
        ]);
        SupplierProfile::create([
            'user_id' => $supplier->id,
            'company_name' => 'AgriSupply Co.',
            'business_permit_no' => 'BP-2026-001',
            'bio' => 'Supplier of seeds, fertilizers, and farm tools.',
        ]);

        $supplier2 = User::create([
            'name' => 'GreenGrow Agri Trading',
            'email' => 'greengrow.supplier@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '09182223344',
            'address' => 'Surigao City, Surigao del Norte',
            'status' => 'active',
        ]);
        SupplierProfile::create([
            'user_id' => $supplier2->id,
            'company_name' => 'GreenGrow Agri Trading',
            'business_permit_no' => 'BP-2026-014',
            'bio' => 'Crop protection products and farm machinery rental.',
        ]);

        // --- Pending accounts (for the admin approval flow) ---
        $pendingFarmer = User::create([
            'name' => 'Maria Santos',
            'email' => 'pending.farmer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'phone' => '09174445566',
            'address' => 'Barangay Buenavista, Cantilan',
            'status' => 'pending',
        ]);
        FarmerProfile::create(['user_id' => $pendingFarmer->id, 'farm_name' => 'Santos Vegetable Farm']);

        $pendingSupplier = User::create([
            'name' => 'Northmin Farm Depot',
            'email' => 'pending.supplier@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'supplier',
            'phone' => '09185556677',
            'address' => 'Cabadbaran City, Agusan del Norte',
            'status' => 'pending',
        ]);
        SupplierProfile::create(['user_id' => $pendingSupplier->id, 'company_name' => 'Northmin Farm Depot']);

        // --- Buyers ---
        $buyer = User::create([
            'name' => 'Pedro Reyes',
            'email' => 'buyer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '09191234567',
            'address' => 'Poblacion, Tandag City, Surigao del Sur',
            'status' => 'active',
        ]);

        $buyer2 = User::create([
            'name' => 'Liza Aranas',
            'email' => 'liza.buyer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '09192223344',
            'address' => 'Barangay Mabini, Bislig City',
            'status' => 'active',
        ]);

        $buyer3 = User::create([
            'name' => 'Carlo Mendez',
            'email' => 'carlo.buyer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '09193334455',
            'address' => 'Barangay Songkoy, Cantilan, Surigao del Sur',
            'status' => 'active',
        ]);

        // -----------------------------------------------------------------
        // Categories
        // -----------------------------------------------------------------
        $rice = Category::create(['name' => 'Rice & Grains', 'type' => 'produce']);
        $veg = Category::create(['name' => 'Vegetables', 'type' => 'produce']);
        $fruit = Category::create(['name' => 'Fruits', 'type' => 'produce']);
        $root = Category::create(['name' => 'Root Crops', 'type' => 'produce']);
        $seeds = Category::create(['name' => 'Seeds', 'type' => 'input']);
        $fert = Category::create(['name' => 'Fertilizers', 'type' => 'input']);
        $tools = Category::create(['name' => 'Farm Tools', 'type' => 'input']);
        $pest = Category::create(['name' => 'Pesticides', 'type' => 'input']);

        // -----------------------------------------------------------------
        // Products - each gets a thematically-relevant placeholder photo
        // (loremflickr, keyed by a fixed "lock" id so it stays the same
        // photo on every reload).
        // -----------------------------------------------------------------
        $img = fn (string $keywords, int $lock) => "https://loremflickr.com/640/480/{$keywords}?lock={$lock}";

        $products = [
            // Farmer 1 - Dela Cruz Farm
            ['user' => $farmer, 'cat' => $rice, 'name' => 'Premium Jasmine Rice', 'desc' => 'Freshly harvested, well-milled jasmine rice.', 'price' => 55, 'unit' => 'kg', 'stock' => 500, 'status' => 'approved', 'img' => $img('rice,grain', 1)],
            ['user' => $farmer, 'cat' => $veg, 'name' => 'Fresh Tomatoes', 'desc' => 'Vine-ripened tomatoes, harvested weekly.', 'price' => 60, 'unit' => 'kg', 'stock' => 150, 'status' => 'approved', 'img' => $img('tomato', 2)],
            ['user' => $farmer, 'cat' => $veg, 'name' => 'Eggplant', 'desc' => 'Firm, glossy eggplants picked at peak ripeness.', 'price' => 45, 'unit' => 'kg', 'stock' => 120, 'status' => 'approved', 'img' => $img('eggplant', 3)],
            ['user' => $farmer, 'cat' => $rice, 'name' => 'Organic Brown Rice', 'desc' => 'Unpolished, naturally grown brown rice.', 'price' => 68, 'unit' => 'kg', 'stock' => 300, 'status' => 'approved', 'img' => $img('brownrice,rice', 4)],
            ['user' => $farmer, 'cat' => $veg, 'name' => 'String Beans', 'desc' => 'Crisp, freshly picked string beans.', 'price' => 50, 'unit' => 'kg', 'stock' => 90, 'status' => 'pending', 'img' => $img('greenbeans', 5)],

            // Farmer 2 - Villanueva Orchards
            ['user' => $farmer2, 'cat' => $fruit, 'name' => 'Cavendish Bananas', 'desc' => 'Sweet, export-quality bananas.', 'price' => 45, 'unit' => 'kg', 'stock' => 200, 'status' => 'approved', 'img' => $img('banana', 6)],
            ['user' => $farmer2, 'cat' => $fruit, 'name' => 'Carabao Mangoes', 'desc' => 'Sweet, golden mangoes - a Philippine favorite.', 'price' => 120, 'unit' => 'kg', 'stock' => 80, 'status' => 'approved', 'img' => $img('mango', 7)],
            ['user' => $farmer2, 'cat' => $fruit, 'name' => 'Pineapples', 'desc' => 'Juicy, hand-picked pineapples.', 'price' => 40, 'unit' => 'piece', 'stock' => 100, 'status' => 'approved', 'img' => $img('pineapple', 8)],
            ['user' => $farmer2, 'cat' => $fruit, 'name' => 'Rambutan', 'desc' => 'In-season rambutan, sweet and fragrant.', 'price' => 90, 'unit' => 'kg', 'stock' => 60, 'status' => 'pending', 'img' => $img('rambutan,fruit', 9)],
            ['user' => $farmer2, 'cat' => $fruit, 'name' => 'Young Coconuts (Buko)', 'desc' => 'Fresh buko for drinking or cooking.', 'price' => 35, 'unit' => 'piece', 'stock' => 150, 'status' => 'approved', 'img' => $img('coconut', 10)],

            // Farmer 3 - Bagon Root Crop Farm
            ['user' => $farmer3, 'cat' => $root, 'name' => 'Sweet Potato (Camote)', 'desc' => 'Naturally grown sweet potatoes.', 'price' => 38, 'unit' => 'kg', 'stock' => 200, 'status' => 'approved', 'img' => $img('sweetpotato', 11)],
            ['user' => $farmer3, 'cat' => $root, 'name' => 'Cassava', 'desc' => 'Freshly dug cassava roots.', 'price' => 30, 'unit' => 'kg', 'stock' => 180, 'status' => 'approved', 'img' => $img('cassava', 12)],
            ['user' => $farmer3, 'cat' => $veg, 'name' => 'Kangkong (Water Spinach)', 'desc' => 'Crisp leafy greens, harvested daily.', 'price' => 25, 'unit' => 'bundle', 'stock' => 0, 'status' => 'out_of_stock', 'img' => $img('kangkong,spinach', 13)],
            ['user' => $farmer3, 'cat' => $root, 'name' => 'Purple Yam (Ube)', 'desc' => 'Vibrant purple ube, great for desserts.', 'price' => 70, 'unit' => 'kg', 'stock' => 70, 'status' => 'approved', 'img' => $img('ube,yam', 14)],
            ['user' => $farmer3, 'cat' => $veg, 'name' => 'Bitter Gourd (Ampalaya)', 'desc' => 'Fresh ampalaya, great for pinakbet.', 'price' => 55, 'unit' => 'kg', 'stock' => 45, 'status' => 'rejected', 'img' => $img('bittergourd,vegetable', 15)],

            // Supplier 1 - AgriSupply Co.
            ['user' => $supplier, 'cat' => $seeds, 'name' => 'Hybrid Corn Seeds (1kg pack)', 'desc' => 'High-yield hybrid corn seed variety.', 'price' => 350, 'unit' => 'pack', 'stock' => 80, 'status' => 'approved', 'img' => $img('cornseeds,corn', 16)],
            ['user' => $supplier, 'cat' => $fert, 'name' => 'Organic Fertilizer (50kg sack)', 'desc' => 'All-natural organic fertilizer blend.', 'price' => 850, 'unit' => 'sack', 'stock' => 60, 'status' => 'approved', 'img' => $img('fertilizer,farm', 17)],
            ['user' => $supplier, 'cat' => $tools, 'name' => 'Stainless Bolo Knife', 'desc' => 'Durable farm bolo with hardwood handle.', 'price' => 480, 'unit' => 'piece', 'stock' => 40, 'status' => 'approved', 'img' => $img('machete,tool', 18)],
            ['user' => $supplier, 'cat' => $seeds, 'name' => 'Tomato Seedlings Starter Kit', 'desc' => 'Ready-to-plant tomato seedlings, 20 pcs.', 'price' => 220, 'unit' => 'pack', 'stock' => 100, 'status' => 'approved', 'img' => $img('seedling,plant', 19)],

            // Supplier 2 - GreenGrow Agri Trading
            ['user' => $supplier2, 'cat' => $pest, 'name' => 'Organic Pest Control Spray (1L)', 'desc' => 'Neem-based organic pesticide, safe for edible crops.', 'price' => 320, 'unit' => 'bottle', 'stock' => 75, 'status' => 'approved', 'img' => $img('pesticide,spray', 20)],
            ['user' => $supplier2, 'cat' => $tools, 'name' => 'Manual Knapsack Sprayer (16L)', 'desc' => 'Heavy-duty hand-pump sprayer for pesticide and foliar feed.', 'price' => 1350, 'unit' => 'unit', 'stock' => 25, 'status' => 'approved', 'img' => $img('sprayer,farmtool', 21)],
            ['user' => $supplier2, 'cat' => $fert, 'name' => 'Complete Fertilizer 14-14-14 (50kg)', 'desc' => 'Balanced NPK fertilizer for all-around crop nutrition.', 'price' => 1450, 'unit' => 'sack', 'stock' => 50, 'status' => 'approved', 'img' => $img('fertilizerbag,farm', 22)],
            ['user' => $supplier2, 'cat' => $tools, 'name' => 'Garden Hand Tool Set', 'desc' => 'Trowel, cultivator, and pruner 3-piece set.', 'price' => 380, 'unit' => 'set', 'stock' => 55, 'status' => 'pending', 'img' => $img('gardentools', 23)],
        ];

        $createdProducts = [];
        foreach ($products as $p) {
            $createdProducts[] = Product::create([
                'user_id' => $p['user']->id,
                'category_id' => $p['cat']->id,
                'name' => $p['name'],
                'description' => $p['desc'],
                'price' => $p['price'],
                'unit' => $p['unit'],
                'stock_quantity' => $p['stock'],
                'status' => $p['status'],
                'image' => $p['img'],
            ]);
        }

        // -----------------------------------------------------------------
        // Sample orders - gives the buyer/seller/admin dashboards and
        // order/tracking pages something real to show out of the box.
        // -----------------------------------------------------------------
        $approvedProducts = collect($createdProducts)->filter(fn ($p) => $p->status === 'approved')->values();

        $sampleOrders = [
            ['buyer' => $buyer, 'items' => [0, 1], 'status' => 'delivered', 'payment' => ['method' => 'gcash', 'status' => 'paid'], 'delivery' => ['status' => 'delivered', 'courier' => 'J&T Express', 'location' => 'Tandag City Hub', 'eta' => now()->subDays(2)]],
            ['buyer' => $buyer, 'items' => [2], 'status' => 'out_for_delivery', 'payment' => ['method' => 'cod', 'status' => 'pending'], 'delivery' => ['status' => 'in_transit', 'courier' => 'LBC Express', 'location' => 'Bislig City Sorting Facility', 'eta' => now()->addDay()]],
            ['buyer' => $buyer2, 'items' => [3, 4], 'status' => 'processing', 'payment' => ['method' => 'bank_transfer', 'status' => 'paid'], 'delivery' => ['status' => 'preparing', 'courier' => null, 'location' => null, 'eta' => now()->addDays(3)]],
            ['buyer' => $buyer3, 'items' => [5], 'status' => 'confirmed', 'payment' => ['method' => 'gcash', 'status' => 'paid'], 'delivery' => ['status' => 'preparing', 'courier' => null, 'location' => null, 'eta' => now()->addDays(4)]],
            ['buyer' => $buyer2, 'items' => [1, 6], 'status' => 'pending', 'payment' => ['method' => 'cod', 'status' => 'pending'], 'delivery' => ['status' => 'preparing', 'courier' => null, 'location' => null, 'eta' => now()->addDays(5)]],
        ];

        foreach ($sampleOrders as $s) {
            $items = collect($s['items'])->map(fn ($i) => $approvedProducts[$i] ?? $approvedProducts[0]);
            $total = $items->sum(fn ($p) => $p->price * 2);

            $order = Order::create([
                'order_number' => 'AC-'.strtoupper(Str::random(8)),
                'buyer_id' => $s['buyer']->id,
                'total_amount' => $total,
                'status' => $s['status'],
                'delivery_address' => $s['buyer']->address,
            ]);

            foreach ($items as $product) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'seller_id' => $product->user_id,
                    'quantity' => 2,
                    'price' => $product->price,
                    'subtotal' => $product->price * 2,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $s['payment']['method'],
                'amount' => $total,
                'status' => $s['payment']['status'],
                'paid_at' => $s['payment']['status'] === 'paid' ? now()->subDay() : null,
            ]);

            Delivery::create([
                'order_id' => $order->id,
                'tracking_number' => 'TRK-'.strtoupper(Str::random(10)),
                'status' => $s['delivery']['status'],
                'courier_name' => $s['delivery']['courier'],
                'current_location' => $s['delivery']['location'],
                'estimated_arrival' => $s['delivery']['eta'],
            ]);
        }

        $this->command->info('Seeded: 1 admin, 3 farmers, 2 suppliers, 1 pending farmer, 1 pending supplier, 3 buyers, 8 categories, '.count($products).' products, '.count($sampleOrders).' sample orders.');
    }
}
