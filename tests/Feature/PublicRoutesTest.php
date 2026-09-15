<?php

namespace Tests\Feature;

use App\Models\FoodReview;
use App\Models\MenuItem;
use App\Models\Message;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        MenuItem::factory()->count(10)->create();
    }

    /** @test */
    public function home_page_returns_success()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('LUXE BURGER');
        $response->assertSee('Burgers');
    }

    /** @test */
    public function menu_page_returns_success()
    {
        $response = $this->get('/menu');

        $response->assertStatus(200);
        $response->assertSee('OUR MENU');
    }

    /** @test */
    public function menu_page_displays_categories()
    {
        MenuItem::factory()->category('Burgers')->create(['name' => 'TestBurger']);
        MenuItem::factory()->category('Sides')->create(['name' => 'TestSide']);

        $response = $this->get('/menu');

        $response->assertSee('TestBurger');
        $response->assertSee('TestSide');
    }

    /** @test */
    public function reservation_page_returns_success()
    {
        $response = $this->get('/reservation');

        $response->assertStatus(200);
        $response->assertSee('GRAB A TABLE');
    }

    /** @test */
    public function reservation_can_be_stored()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'date' => now()->addDays(3)->format('Y-m-d'),
            'time' => '19:00',
            'party_size' => 4,
            'notes' => 'Window seat please',
        ];

        $response = $this->post('/reservation', $data);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservations', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'party_size' => 4,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function reservation_requires_valid_data()
    {
        $response = $this->post('/reservation', []);

        $response->assertSessionHasErrors(['name', 'email', 'phone', 'date', 'time', 'party_size']);
    }

    /** @test */
    public function reservation_rejects_past_date()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'date' => now()->subDays(1)->format('Y-m-d'),
            'time' => '19:00',
            'party_size' => 4,
        ];

        $response = $this->post('/reservation', $data);

        $response->assertSessionHasErrors(['date']);
    }

    /** @test */
    public function contact_page_returns_success()
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
        $response->assertSee('CONTACT US');
    }

    /** @test */
    public function contact_message_can_be_stored()
    {
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Test Subject',
            'message' => 'This is a test message.',
        ];

        $response = $this->post('/contact', $data);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Test Subject',
        ]);
    }

    /** @test */
    public function contact_message_requires_name_email_and_message()
    {
        $response = $this->post('/contact', []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
    }

    /** @test */
    public function order_can_be_placed_via_ajax()
    {
        $data = [
            'menu_item_name' => 'Test Burger',
            'price' => 12.99,
            'quantity' => 2,
            'customer_name' => 'Bob Smith',
            'customer_email' => 'bob@example.com',
            'customer_phone' => '+1234567890',
            'delivery_address' => '123 Main St, City',
        ];

        $response = $this->postJson('/order', $data);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('orders', [
            'menu_item_name' => 'Test Burger',
            'customer_name' => 'Bob Smith',
            'total' => 25.98,
        ]);
    }

    /** @test */
    public function order_requires_valid_data()
    {
        $response = $this->postJson('/order', []);

        $response->assertStatus(422);
    }

    /** @test */
    public function non_ajax_order_is_rejected()
    {
        $data = [
            'menu_item_name' => 'Test',
            'price' => 10,
            'quantity' => 1,
            'customer_name' => 'Bob',
            'customer_email' => 'bob@test.com',
            'customer_phone' => '123',
            'delivery_address' => 'Addr',
        ];

        $response = $this->post('/order', $data);

        $response->assertJson(['success' => false]);
    }

    /** @test */
    public function review_can_be_submitted_via_ajax()
    {
        $data = [
            'menu_item_name' => 'TestBurger',
            'user_name' => 'Alice',
            'comment' => 'Amazing burger!',
            'rating' => 5,
        ];

        $response = $this->postJson('/review', $data);

        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('food_reviews', [
            'menu_item_name' => 'TestBurger',
            'user_name' => 'Alice',
            'rating' => 5,
        ]);
    }

    /** @test */
    public function home_page_shows_specials()
    {
        MenuItem::factory()->special()->create(['name' => 'Weekly Special']);
        MenuItem::factory()->special()->create(['name' => 'Daily Deal']);
        MenuItem::factory()->create(['name' => 'Regular Item', 'is_special' => false]);

        $response = $this->get('/');

        $response->assertSee('Weekly Special');
        $response->assertSee('Daily Deal');
    }

    /** @test */
    public function home_page_shows_recent_reviews()
    {
        FoodReview::factory()->create([
            'user_name' => 'Reviewer1',
            'comment' => 'Great food!',
        ]);
        FoodReview::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertSee('Reviewer1');
        $response->assertSee('Great food!');
    }

    /** @test */
    public function menu_page_shows_empty_state()
    {
        MenuItem::query()->delete();

        $response = $this->get('/menu');

        $response->assertStatus(200);
    }

    /** @test */
    public function home_page_shows_empty_specials_state()
    {
        MenuItem::query()->update(['is_special' => false]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
