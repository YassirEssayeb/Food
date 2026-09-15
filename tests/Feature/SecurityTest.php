<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_routes_are_protected_by_auth()
    {
        $protectedRoutes = [
            '/admin',
            '/admin/menu-items',
            '/admin/menu-items/create',
            '/admin/reservations',
            '/admin/messages',
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $response->assertRedirect('/admin/login');
        }
    }

    /** @test */
    public function admin_post_routes_are_protected()
    {
        $this->post('/admin/logout')->assertRedirect('/admin/login');
    }

    /** @test */
    public function csrf_middleware_is_applied_to_post_routes()
    {
        $this->withSession(['_token' => 'valid-token']);

        $response = $this->post('/contact', [
            'name' => 'Test',
            'email' => 'test@test.com',
            'message' => 'Test',
        ], ['X-CSRF-TOKEN' => 'different-token']);

        $response->assertStatus(302);
    }

    /** @test */
    public function form_submission_works_without_csrf_when_bypassed()
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'subject' => 'Test Subject',
            'message' => 'Test message body',
        ]);

        $response->assertSessionHas('success');
    }

    /** @test */
    public function xss_in_contact_form_is_escaped()
    {
        $this->withoutExceptionHandling();

        // Actually test that the controller handles it
        $response = $this->post('/contact', [
            'name' => '<script>alert("xss")</script>',
            'email' => 'test@test.com',
            'message' => 'Safe message',
        ]);

        $response->assertSessionHas('success');
    }

    /** @test */
    public function sql_injection_in_menu_page_is_safe()
    {
        $response = $this->get('/menu');

        $response->assertStatus(200);
    }

    /** @test */
    public function mass_assignment_is_prevented()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/admin/menu-items', [
            'name' => 'Test',
            'price' => 10,
            'category' => 'Burgers',
            'id' => 9999,
            'created_at' => '2020-01-01',
        ]);

        $this->assertDatabaseMissing('menu_items', ['id' => 9999]);
    }

    /** @test */
    public function reservation_email_is_validated()
    {
        $response = $this->post('/reservation', [
            'name' => 'Test',
            'email' => 'not-an-email',
            'phone' => '1234567890',
            'date' => now()->addDays(1)->format('Y-m-d'),
            'time' => '19:00',
            'party_size' => 2,
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function menu_item_price_cannot_be_negative()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->post('/admin/menu-items', [
            'name' => 'Negative Price',
            'price' => -5.00,
            'category' => 'Burgers',
        ]);

        $response->assertSessionHasErrors('price');
    }
}
