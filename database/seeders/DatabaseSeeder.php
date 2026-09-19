<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FarmerProfile;
use App\Models\Product;
use App\Models\SupplierProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Demo farmer (active + approved)
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

        // Demo supplier (active + approved)
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

        // Demo pending farmer (for testing admin approval flow)
        $pendingFarmer = User::create([
            'name' => 'Maria Santos',
            'email' => 'pending.farmer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'farmer',
            'status' => 'pending',
        ]);
        FarmerProfile::create(['user_id' => $pendingFarmer->id, 'farm_name' => 'Santos Vegetable Farm']);

        // Demo buyer
        $buyer = User::create([
            'name' => 'Pedro Reyes',
            'email' => 'buyer@agriconnect.test',
            'password' => Hash::make('password'),
            'role' => 'buyer',
            'phone' => '09191234567',
            'address' => 'Poblacion, Tandag City, Surigao del Sur',
            'status' => 'active',
        ]);

        // Categories
        $rice = Category::create(['name' => 'Rice & Grains', 'type' => 'produce']);
        $veg = Category::create(['name' => 'Vegetables', 'type' => 'produce']);
        $fruit = Category::create(['name' => 'Fruits', 'type' => 'produce']);
        $seeds = Category::create(['name' => 'Seeds', 'type' => 'input']);
        $fert = Category::create(['name' => 'Fertilizers', 'type' => 'input']);
        Category::create(['name' => 'Farm Tools', 'type' => 'input']);

        // Products
        Product::create([
            'user_id' => $farmer->id, 'category_id' => $rice->id,
            'name' => 'Premium Jasmine Rice', 'description' => 'Freshly harvested, well-milled jasmine rice.',
            'price' => 55.00, 'unit' => 'kg', 'stock_quantity' => 500, 'status' => 'approved',
        ]);
        Product::create([
            'user_id' => $farmer->id, 'category_id' => $veg->id,
            'name' => 'Fresh Tomatoes', 'description' => 'Vine-ripened tomatoes, harvested weekly.',
            'price' => 60.00, 'unit' => 'kg', 'stock_quantity' => 150, 'status' => 'approved',
        ]);
        Product::create([
            'user_id' => $farmer->id, 'category_id' => $fruit->id,
            'name' => 'Cavendish Bananas', 'description' => 'Sweet, export-quality bananas.',
            'price' => 45.00, 'unit' => 'kg', 'stock_quantity' => 200, 'status' => 'pending',
        ]);
        Product::create([
            'user_id' => $supplier->id, 'category_id' => $seeds->id,
            'name' => 'Hybrid Corn Seeds (1kg pack)', 'description' => 'High-yield hybrid corn seed variety.',
            'price' => 350.00, 'unit' => 'pack', 'stock_quantity' => 80, 'status' => 'approved',
        ]);
        Product::create([
            'user_id' => $supplier->id, 'category_id' => $fert->id,
            'name' => 'Organic Fertilizer (50kg sack)', 'description' => 'All-natural organic fertilizer blend.',
            'price' => 850.00, 'unit' => 'sack', 'stock_quantity' => 60, 'status' => 'approved',
        ]);

        $this->command->info('Seeded: 1 admin, 1 farmer (active), 1 supplier, 1 pending farmer, 1 buyer, 6 categories, 5 products.');
    }
}
