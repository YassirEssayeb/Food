<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\Message;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    /** @test */
    public function dashboard_shows_stats()
    {
        Reservation::factory()->count(3)->create();
        MenuItem::factory()->count(5)->create();
        Message::factory()->create(['is_read' => false]);

        $this->actingAs($this->admin);

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Total Reservations');
        $response->assertSee('Menu Items');
        $response->assertSee('Unread Messages');
    }

    /** @test */
    public function menu_index_lists_all_items()
    {
        MenuItem::factory()->count(3)->create();

        $this->actingAs($this->admin);

        $response = $this->get('/admin/menu-items');

        $response->assertStatus(200);
    }

    /** @test */
    public function menu_create_page_is_accessible()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/menu-items/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function menu_item_can_be_created()
    {
        $this->actingAs($this->admin);

        $data = [
            'name' => 'New Test Item',
            'description' => 'Delicious test item',
            'price' => 14.99,
            'category' => 'Burgers',
            'is_special' => true,
        ];

        $response = $this->post('/admin/menu-items', $data);

        $response->assertRedirect(route('menu-items.index'));
        $this->assertDatabaseHas('menu_items', [
            'name' => 'New Test Item',
            'price' => 14.99,
            'is_special' => 1,
        ]);
    }

    /** @test */
    public function menu_item_requires_name_price_and_category()
    {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/menu-items', []);

        $response->assertSessionHasErrors(['name', 'price', 'category']);
    }

    /** @test */
    public function menu_item_can_be_updated()
    {
        $item = MenuItem::factory()->create(['name' => 'Original Name']);

        $this->actingAs($this->admin);

        $response = $this->put("/admin/menu-items/{$item->id}", [
            'name' => 'Updated Name',
            'description' => 'Updated description',
            'price' => 19.99,
            'category' => 'Sides',
            'is_special' => false,
        ]);

        $response->assertRedirect(route('menu-items.index'));
        $this->assertDatabaseHas('menu_items', [
            'id' => $item->id,
            'name' => 'Updated Name',
            'price' => 19.99,
        ]);
        $this->assertDatabaseMissing('menu_items', [
            'id' => $item->id,
            'name' => 'Original Name',
        ]);
    }

    /** @test */
    public function menu_item_can_be_deleted()
    {
        $item = MenuItem::factory()->create();

        $this->actingAs($this->admin);

        $response = $this->delete("/admin/menu-items/{$item->id}");

        $response->assertRedirect(route('menu-items.index'));
        $this->assertModelMissing($item);
    }

    /** @test */
    public function edit_page_shows_current_item()
    {
        $item = MenuItem::factory()->create(['name' => 'Edit Me']);

        $this->actingAs($this->admin);

        $response = $this->get("/admin/menu-items/{$item->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Me');
        $response->assertSee('Edit Menu Item');
    }

    /** @test */
    public function reservations_page_lists_all()
    {
        Reservation::factory()->count(3)->create();

        $this->actingAs($this->admin);

        $response = $this->get('/admin/reservations');

        $response->assertStatus(200);
    }

    /** @test */
    public function reservation_status_can_be_updated_to_confirmed()
    {
        $reservation = Reservation::factory()->create(['status' => 'pending']);

        $this->actingAs($this->admin);

        $response = $this->post("/admin/reservations/{$reservation->id}/status", [
            'status' => 'confirmed',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed',
        ]);
    }

    /** @test */
    public function reservation_status_can_be_updated_to_cancelled()
    {
        $reservation = Reservation::factory()->create(['status' => 'pending']);

        $this->actingAs($this->admin);

        $response = $this->post("/admin/reservations/{$reservation->id}/status", [
            'status' => 'cancelled',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'cancelled',
        ]);
    }

    /** @test */
    public function messages_page_lists_all()
    {
        Message::factory()->count(3)->create();

        $this->actingAs($this->admin);

        $response = $this->get('/admin/messages');

        $response->assertStatus(200);
    }

    /** @test */
    public function message_can_be_marked_as_read()
    {
        $message = Message::factory()->create(['is_read' => false]);

        $this->actingAs($this->admin);

        $response = $this->post("/admin/messages/{$message->id}/read");

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'is_read' => true,
        ]);
    }

    /** @test */
    public function menu_item_can_be_created_with_image_upload()
    {
        if (!function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension not available.');
        }

        Storage::fake('public');

        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->image('burger.jpg', 400, 300);

        $response = $this->post('/admin/menu-items', [
            'name' => 'With Image',
            'price' => 9.99,
            'category' => 'Burgers',
            'image' => $file,
        ]);

        $response->assertRedirect(route('menu-items.index'));
    }

    /** @test */
    public function menu_item_rejects_invalid_image()
    {
        $this->actingAs($this->admin);

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $response = $this->post('/admin/menu-items', [
            'name' => 'Bad Image',
            'price' => 9.99,
            'category' => 'Burgers',
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
    }

    /** @test */
    public function empty_states_are_handled()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/admin/reservations');
        $response->assertSee('No reservations found.');

        $response = $this->get('/admin/messages');
        $response->assertSee('No messages found.');
    }
}
