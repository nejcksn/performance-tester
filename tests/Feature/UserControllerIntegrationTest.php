<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_index_with_roles_filter()
    {
        // Создаём пользователей с разными ролями
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $superAdminRole = Role::create(['name' => 'super_admin']); // Создаем super_admin

        $admin = User::factory()->create();
        $admin->assignRole($adminRole);

        $user = User::factory()->create();
        $user->assignRole($userRole);

        // Авторизуем супер-админа
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole($superAdminRole); // Присваиваем роль super_admin
        $this->actingAs($superAdmin);

        // Получаем пользователей с фильтром по роли
        $response = $this->get('/admin/users?role=admin');

        $response->assertStatus(200);
        $response->assertSee($admin->name);
        $response->assertDontSee($user->name); // Проверяем, что user не отображается
    }

    /** @test */
    public function test_search_functionality()
    {
        // Создаём пользователей
        $user1 = User::factory()->create(['name' => 'John Doe']);
        $user2 = User::factory()->create(['name' => 'Jane Smith']);

        // Выполняем поиск
        $response = $this->getJson('/admin/users/search?q=John');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'John Doe']);
        $response->assertJsonMissing(['name' => 'Jane Smith']);
    }

    /** @test */
    public function test_assign_role_to_user()
    {
        // Создаём роль и пользователя
        $adminRole = Role::create(['name' => 'admin']);
        $user = User::factory()->create();

        // Авторизуем супер-админа
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super_admin');
        $this->actingAs($superAdmin);

        // Присваиваем роль
        $response = $this->postJson('/admin/users/assign-role', [
            'user_id' => $user->id,
            'role' => 'admin',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Проверяем, что роль была присвоена
        $this->assertTrue($user->hasRole('admin'));
    }

    /** @test */
    public function test_assign_role_permission_denied_for_non_super_admin()
    {
        // Создаём роль и пользователя
        $adminRole = Role::create(['name' => 'admin']);
        $user = User::factory()->create();

        // Авторизуем обычного пользователя
        $this->actingAs(User::factory()->create());

        // Пробуем присвоить роль
        $response = $this->postJson('/admin/users/assign-role', [
            'user_id' => $user->id,
            'role' => 'admin',
        ]);

        $response->assertStatus(403);
        $response->assertJson(['success' => false, 'message' => 'You do not have permission to assign this role.']);
    }

    /** @test */
    public function test_remove_role_from_user()
    {
        // Создаём роль и пользователя
        $adminRole = Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $user->assignRole($adminRole);

        // Создаём супер-админа и авторизуем его
        $superAdminRole = Role::create(['name' => 'super_admin']); // Создаем роль super_admin
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole($superAdminRole); // Присваиваем роль super_admin
        $this->actingAs($superAdmin);

        // Удаляем роль
        $response = $this->deleteJson('/admin/users/' . $user->id . '/remove-role/admin');

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Проверяем, что роль была удалена
        $this->assertFalse($user->hasRole('admin'));
    }

    /** @test */
    public function test_destroy_user()
    {
        // Создаём роль super_admin и пользователя
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $user = User::factory()->create();

        // Создаём супер-админа и присваиваем ему роль super_admin
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole($superAdminRole);
        $this->actingAs($superAdmin);

        // Удаляем пользователя
        $response = $this->delete('/admin/users/' . $user->id);

        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success', "User {$user->name} {$user->surname} has been deleted!");

        // Проверяем, что пользователь был удалён
        $this->assertDeleted($user);
    }
}
