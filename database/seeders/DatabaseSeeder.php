<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $items = [
            // ═══════════════════════════════════════════
            // BURGERS
            // ═══════════════════════════════════════════
            [
                'name' => 'The Monster Boss',
                'description' => 'Our signature triple-patty wagyu burger with melted cheddar, smoked bacon, caramelized onions, and our secret Boss Sauce.',
                'price' => 12.99,
                'category' => 'Burgers',
                'image' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Triple Wagyu Beef, Aged Cheddar, Crispy Bacon, Brioche Bun, Caramelized Onions, Boss Sauce, Pickles.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],
            [
                'name' => 'Smoky BBQ Ranch Burger',
                'description' => 'Smoked beef patty glazed with house-made BBQ sauce, cheddar, onion rings, and ranch dressing.',
                'price' => 11.50,
                'category' => 'Burgers',
                'image' => 'https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Smoked Beef Patty, BBQ Sauce, Cheddar, Crispy Onion Rings, Ranch Dressing, Lettuce, Tomato.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],
            [
                'name' => 'Spicy Zinger Chicken',
                'description' => 'Double-breaded spicy chicken breast, jalapeño slaw, and sriracha mayo on a toasted sesame bun.',
                'price' => 9.50,
                'category' => 'Burgers',
                'image' => 'https://images.unsplash.com/photo-1561758033-7e924f619b47?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Crispy Spicy Chicken, Sesame Bun, Jalapeño Slaw, Sriracha Mayo, Fresh Lettuce.',
                'allergens' => 'Gluten, Eggs',
            ],
            [
                'name' => 'Mushroom Swiss Burger',
                'description' => 'Juicy beef patty topped with sautéed wild mushrooms, melted Swiss cheese, and truffle aioli.',
                'price' => 10.99,
                'category' => 'Burgers',
                'image' => 'https://images.unsplash.com/photo-1551782450-a2132b4ba21d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Beef Patty, Swiss Cheese, Wild Mushrooms, Truffle Aioli, Arugula, Brioche Bun.',
                'allergens' => 'Dairy, Gluten',
            ],
            [
                'name' => 'Hawaiian Teriyaki Burger',
                'description' => 'Grilled beef patty glazed with teriyaki sauce, grilled pineapple, crispy bacon, and sriracha mayo.',
                'price' => 10.50,
                'category' => 'Burgers',
                'image' => 'https://images.unsplash.com/photo-1572802419224-296b0aeee0d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Beef Patty, Teriyaki Glaze, Grilled Pineapple, Smoked Bacon, Sriracha Mayo, Lettuce.',
                'allergens' => 'Gluten, Soy, Eggs',
            ],
            [
                'name' => 'Classic Cheeseburger',
                'description' => 'Simple and perfect — a juicy beef patty with American cheese, pickles, onions, and our special sauce.',
                'price' => 8.99,
                'category' => 'Burgers',
                'image' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Beef Patty, American Cheese, Pickles, White Onion, Special Sauce, Sesame Bun.',
                'allergens' => 'Dairy, Gluten',
            ],

            // ═══════════════════════════════════════════
            // CHICKEN & WRAPS
            // ═══════════════════════════════════════════
            [
                'name' => 'Crispy Chicken Wrap',
                'description' => 'Crispy fried chicken strips tossed in buffalo sauce, wrapped with lettuce, tomato, and ranch.',
                'price' => 8.50,
                'category' => 'Chicken & Wraps',
                'image' => 'https://images.unsplash.com/photo-1626700051175-6818013e1d4f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Crispy Chicken Strips, Buffalo Sauce, Flour Tortilla, Lettuce, Tomato, Ranch Dressing.',
                'allergens' => 'Gluten, Dairy, Eggs',
            ],
            [
                'name' => 'Grilled Chicken Caesar Wrap',
                'description' => 'Grilled chicken breast with crisp romaine, parmesan, croutons, and creamy Caesar dressing in a warm tortilla.',
                'price' => 8.99,
                'category' => 'Chicken & Wraps',
                'image' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Grilled Chicken, Romaine Lettuce, Parmesan, Croutons, Caesar Dressing, Flour Tortilla.',
                'allergens' => 'Gluten, Dairy, Eggs',
            ],
            [
                'name' => 'Buffalo Chicken Wrap',
                'description' => 'Spicy buffalo fried chicken with cool ranch, shredded lettuce, and diced tomatoes in a flour wrap.',
                'price' => 8.50,
                'category' => 'Chicken & Wraps',
                'image' => 'https://images.unsplash.com/photo-1562059390-a761a084768e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Buffalo Fried Chicken, Ranch Dressing, Shredded Lettuce, Diced Tomatoes, Flour Tortilla.',
                'allergens' => 'Gluten, Dairy, Eggs',
            ],

            // ═══════════════════════════════════════════
            // SIDES
            // ═══════════════════════════════════════════
            [
                'name' => 'Loaded Cheesy Fries',
                'description' => 'Golden crispy fries smothered in melted 4-cheese blend, topped with bacon bits and chives.',
                'price' => 6.50,
                'category' => 'Sides',
                'image' => 'https://images.unsplash.com/photo-1585109649139-366815a0d713?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Premium Russet Potatoes, 4-Cheese Blend, Smoked Bacon, Fresh Chives, House Ranch.',
                'allergens' => 'Dairy',
            ],
            [
                'name' => 'Crispy Onion Rings',
                'description' => 'Hand-battered jumbo onion rings, fried to golden perfection and served with smoky BBQ dip.',
                'price' => 4.99,
                'category' => 'Sides',
                'image' => 'https://images.unsplash.com/photo-1639024471283-03518883512d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Sweet Onions, Beer Batter, Panko Crumbs, Smoky BBQ Sauce.',
                'allergens' => 'Gluten',
            ],
            [
                'name' => 'Truffle Parmesan Fries',
                'description' => 'Crispy shoestring fries tossed in truffle oil, parmesan, and fresh parsley.',
                'price' => 5.99,
                'category' => 'Sides',
                'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Shoestring Potatoes, Truffle Oil, Parmesan, Fresh Parsley, Sea Salt.',
                'allergens' => 'Dairy',
            ],
            [
                'name' => 'Mac & Cheese Bites',
                'description' => 'Creamy mac and cheese breaded and fried until golden, served with marinara dipping sauce.',
                'price' => 5.50,
                'category' => 'Sides',
                'image' => 'https://images.unsplash.com/photo-1551183053-bf91a1d81141?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Elbow Pasta, Cheddar Blend, Panko Breadcrumbs, Marinara Sauce.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],
            [
                'name' => 'Sweet Potato Fries',
                'description' => 'Crispy seasoned sweet potato fries served with chipotle aioli dipping sauce.',
                'price' => 4.99,
                'category' => 'Sides',
                'image' => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Sweet Potatoes, Seasoned Salt, Chipotle Aioli.',
                'allergens' => 'Eggs',
            ],

            // ═══════════════════════════════════════════
            // SALADS
            // ═══════════════════════════════════════════
            [
                'name' => 'Grilled Chicken Caesar Salad',
                'description' => 'Grilled chicken breast on a bed of crisp romaine, shaved parmesan, croutons, and house Caesar.',
                'price' => 9.99,
                'category' => 'Salads',
                'image' => 'https://images.unsplash.com/photo-1550304943-4f24f54ddde9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Grilled Chicken, Romaine Lettuce, Parmesan, Croutons, Caesar Dressing.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],
            [
                'name' => 'Southwest Avocado Salad',
                'description' => 'Fresh mixed greens with avocado, black beans, corn, cherry tomatoes, and cilantro lime dressing.',
                'price' => 8.99,
                'category' => 'Salads',
                'image' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Mixed Greens, Avocado, Black Beans, Roasted Corn, Cherry Tomatoes, Cilantro Lime Dressing.',
                'allergens' => 'None',
            ],

            // ═══════════════════════════════════════════
            // PASTA
            // ═══════════════════════════════════════════
            [
                'name' => 'Creamy Alfredo Pasta',
                'description' => 'Fettuccine tossed in a rich parmesan cream sauce with garlic and fresh herbs.',
                'price' => 10.99,
                'category' => 'Pasta',
                'image' => 'https://images.unsplash.com/photo-1645112411341-6c4fd023714a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Fettuccine, Heavy Cream, Parmesan, Garlic, Butter, Fresh Parsley.',
                'allergens' => 'Dairy, Gluten',
            ],
            [
                'name' => 'Spicy Arrabbiata Pasta',
                'description' => 'Penne pasta in a fiery tomato sauce with chili flakes, garlic, and fresh basil.',
                'price' => 9.99,
                'category' => 'Pasta',
                'image' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Penne, San Marzano Tomatoes, Chili Flakes, Garlic, Olive Oil, Fresh Basil.',
                'allergens' => 'Gluten',
            ],
            [
                'name' => 'Chicken Pesto Pasta',
                'description' => 'Grilled chicken with penne in a fresh basil pesto cream sauce, finished with pine nuts.',
                'price' => 11.99,
                'category' => 'Pasta',
                'image' => 'https://images.unsplash.com/photo-1473093295043-cdd812d0e601?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Grilled Chicken, Penne, Basil Pesto, Heavy Cream, Pine Nuts, Parmesan.',
                'allergens' => 'Dairy, Gluten, Nuts',
            ],

            // ═══════════════════════════════════════════
            // DESSERTS
            // ═══════════════════════════════════════════
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm dark chocolate cake with a molten center, served with vanilla ice cream.',
                'price' => 6.99,
                'category' => 'Desserts',
                'image' => 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Dark Chocolate, Butter, Eggs, Flour, Vanilla Ice Cream.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],
            [
                'name' => 'New York Cheesecake',
                'description' => 'Creamy classic cheesecake on a graham cracker crust, topped with berry compote.',
                'price' => 6.50,
                'category' => 'Desserts',
                'image' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Cream Cheese, Graham Cracker Crust, Sugar, Vanilla, Mixed Berry Compote.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],
            [
                'name' => 'Warm Brownie Sundae',
                'description' => 'Fudgy chocolate brownie topped with vanilla ice cream, hot fudge, and whipped cream.',
                'price' => 7.50,
                'category' => 'Desserts',
                'image' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Chocolate Brownie, Vanilla Ice Cream, Hot Fudge, Whipped Cream, Cherry.',
                'allergens' => 'Dairy, Gluten, Eggs',
            ],

            // ═══════════════════════════════════════════
            // DRINKS
            // ═══════════════════════════════════════════
            [
                'name' => 'Ultimate Oreo Shake',
                'description' => 'Thick and creamy vanilla bean shake blended with real Oreo chunks and topped with whipped cream.',
                'price' => 5.99,
                'category' => 'Drinks',
                'image' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => true,
                'ingredients' => 'Vanilla Bean Ice Cream, Fresh Milk, Real Oreo Cookies, Whipped Cream, Chocolate Drizzle.',
                'allergens' => 'Dairy, Gluten',
            ],
            [
                'name' => 'Classic Cold Brew',
                'description' => '12-hour steeped cold brew coffee, served over ice for a smooth, bold energy boost.',
                'price' => 3.50,
                'category' => 'Drinks',
                'image' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Premium Arabica Beans, Filtered Water, Ice.',
                'allergens' => 'None',
            ],
            [
                'name' => 'Strawberry Banana Smoothie',
                'description' => 'Fresh strawberries and ripe bananas blended with yogurt and honey for a refreshing treat.',
                'price' => 4.99,
                'category' => 'Drinks',
                'image' => 'https://images.unsplash.com/photo-1505252585461-04db1eb84625?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Fresh Strawberries, Ripe Bananas, Greek Yogurt, Honey, Ice.',
                'allergens' => 'Dairy',
            ],
            [
                'name' => 'Sparkling Lemonade',
                'description' => 'Fresh-squeezed lemonade topped with sparkling water and a hint of mint.',
                'price' => 2.99,
                'category' => 'Drinks',
                'image' => 'https://images.unsplash.com/photo-1621263764928-df1444c5e859?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Fresh Lemons, Sparkling Water, Mint, Sugar, Ice.',
                'allergens' => 'None',
            ],
            [
                'name' => 'Chocolate Milkshake',
                'description' => 'Rich and creamy chocolate milkshake topped with whipped cream and chocolate shavings.',
                'price' => 5.49,
                'category' => 'Drinks',
                'image' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                'is_special' => false,
                'ingredients' => 'Chocolate Ice Cream, Whole Milk, Chocolate Syrup, Whipped Cream, Chocolate Shavings.',
                'allergens' => 'Dairy',
            ],
        ];

        foreach ($items as $item) {
            MenuItem::create($item);
        }
    }
}
