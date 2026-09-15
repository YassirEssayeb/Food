<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
    }

    /** @test */
    public function login_page_is_accessible()
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('LUXE ADMIN');
        $response->assertSee('Sign In');
    }

    /** @test */
    public function admin_dashboard_redirects_to_login_when_unauthenticated()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_menu_items_redirects_to_login_when_unauthenticated()
    {
        $response = $this->get('/admin/menu-items');

        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_reservations_redirects_to_login_when_unauthenticated()
    {
        $response = $this->get('/admin/reservations');

        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_messages_redirects_to_login_when_unauthenticated()
    {
        $response = $this->get('/admin/messages');

        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function login_with_valid_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    /** @test */
    public function login_with_invalid_credentials()
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function login_with_invalid_email()
    {
        $response = $this->post('/admin/login', [
            'email' => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_with_empty_credentials()
    {
        $response = $this->post('/admin/login', []);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function authenticated_user_can_access_dashboard()
    {
        $this->actingAs(User::first());

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('LUXE ADMIN');
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $this->actingAs(User::first());

        $response = $this->post('/admin/logout');

        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    /** @test */
    public function authenticated_user_can_access_login_page()
    {
        $this->actingAs(User::first());

        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function login_page_has_csrf_token()
    {
        $response = $this->get('/admin/login');

        $response->assertSee('_token');
    }
}
