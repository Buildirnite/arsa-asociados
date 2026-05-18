<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    // El middleware muestra la página de login (200) en lugar de redirigir (302)
    // cuando el acceso no está autenticado.
    public function test_admin_unauthenticated_access_shows_login_page(): void
    {
        $this->get('/admin')->assertOk();
    }

    public function test_admin_login_with_wrong_password_shows_error(): void
    {
        $this->post('/admin', ['password' => 'contraseña-incorrecta'])
             ->assertOk()
             ->assertSee('Contraseña incorrecta');
    }

    public function test_admin_posts_returns_200_when_authenticated(): void
    {
        $this->withSession(['admin_authenticated' => true])
             ->get('/admin/posts')
             ->assertOk();
    }

    public function test_admin_mensajes_returns_200_when_authenticated(): void
    {
        $this->withSession(['admin_authenticated' => true])
             ->get('/admin/mensajes')
             ->assertOk();
    }

    public function test_admin_login_with_correct_password_redirects_to_posts(): void
    {
        $password = config('app.admin_password');

        $this->post('/admin', ['password' => $password])
             ->assertRedirect(route('admin.posts.index'));
    }
}
