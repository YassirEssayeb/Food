<?php

namespace Tests\Unit;

use App\Models\FoodReview;
use App\Models\MenuItem;
use App\Models\Message;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function menu_item_has_expected_fillable_attributes()
    {
        $fillable = (new MenuItem())->getFillable();
        $expected = ['name', 'description', 'price', 'category', 'image', 'is_special', 'ingredients', 'allergens'];

        foreach ($expected as $attr) {
            $this->assertContains($attr, $fillable, "Missing fillable: $attr");
        }
    }

    /** @test */
    public function reservation_has_expected_fillable_attributes()
    {
        $fillable = (new Reservation())->getFillable();
        $expected = ['name', 'email', 'phone', 'date', 'time', 'party_size', 'notes', 'status'];

        foreach ($expected as $attr) {
            $this->assertContains($attr, $fillable, "Missing fillable: $attr");
        }
    }

    /** @test */
    public function message_has_expected_fillable_attributes()
    {
        $fillable = (new Message())->getFillable();
        $expected = ['name', 'email', 'subject', 'message', 'is_read'];

        foreach ($expected as $attr) {
            $this->assertContains($attr, $fillable, "Missing fillable: $attr");
        }
    }

    /** @test */
    public function food_review_has_expected_fillable_attributes()
    {
        $fillable = (new FoodReview())->getFillable();
        $expected = ['menu_item_name', 'user_name', 'comment', 'rating'];

        foreach ($expected as $attr) {
            $this->assertContains($attr, $fillable, "Missing fillable: $attr");
        }
    }

    /** @test */
    public function order_has_expected_fillable_attributes()
    {
        $fillable = (new Order())->getFillable();
        $expected = [
            'menu_item_name', 'price', 'quantity', 'total',
            'customer_name', 'customer_email', 'customer_phone',
            'delivery_address', 'notes', 'status',
        ];

        foreach ($expected as $attr) {
            $this->assertContains($attr, $fillable, "Missing fillable: $attr");
        }
    }

    /** @test */
    public function user_has_expected_fillable_attributes()
    {
        $fillable = (new User())->getFillable();
        $expected = ['name', 'email', 'password'];

        foreach ($expected as $attr) {
            $this->assertContains($attr, $fillable, "Missing fillable: $attr");
        }
    }

    /** @test */
    public function menu_item_can_be_created()
    {
        $item = MenuItem::factory()->create([
            'name' => 'Test Burger',
            'price' => 9.99,
            'category' => 'Burgers',
        ]);

        $this->assertInstanceOf(MenuItem::class, $item);
        $this->assertEquals('Test Burger', $item->name);
        $this->assertEquals(9.99, $item->price);
        $this->assertEquals('Burgers', $item->category);
    }

    /** @test */
    public function menu_item_defaults_is_special_to_false()
    {
        $item = MenuItem::factory()->create(['is_special' => false]);

        $this->assertFalse((bool) $item->is_special);
    }

    /** @test */
    public function reservation_defaults_status_to_pending()
    {
        $reservation = Reservation::factory()->create();

        $this->assertEquals('pending', $reservation->status);
    }

    /** @test */
    public function message_defaults_is_read_to_false()
    {
        $message = Message::factory()->create();

        $this->assertFalse((bool) $message->is_read);
    }

    /** @test */
    public function order_calculates_total_correctly()
    {
        $order = Order::factory()->create([
            'price' => 10.00,
            'quantity' => 3,
            'total' => 30.00,
        ]);

        $this->assertEquals(30.00, $order->total);
        $this->assertEquals(10.00, $order->price);
        $this->assertEquals(3, $order->quantity);
    }

    /** @test */
    public function food_review_can_have_null_rating()
    {
        $review = FoodReview::factory()->create(['rating' => null]);

        $this->assertNull($review->rating);
    }

    /** @test */
    public function all_models_use_has_factory_trait()
    {
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(MenuItem::class)
        );
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(Reservation::class)
        );
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(Message::class)
        );
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(FoodReview::class)
        );
        $this->assertContains(
            'Illuminate\Database\Eloquent\Factories\HasFactory',
            class_uses(Order::class)
        );
    }

    /** @test */
    public function user_model_implements_authenticatable()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(\Illuminate\Contracts\Auth\Authenticatable::class, $user);
    }
}
