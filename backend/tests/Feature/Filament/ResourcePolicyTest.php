<?php

use App\Filament\Pages\ManageSiteSettings;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Inquiry;
use App\Models\Office;
use App\Models\Page;
use App\Models\Product;
use App\Models\Solution;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\HeroSlidePolicy;
use App\Policies\InquiryPolicy;
use App\Policies\OfficePolicy;
use App\Policies\PagePolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\SolutionPolicy;
use App\Policies\UserPolicy;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(RolePermissionSeeder::class);
});

test('content manage permission governs category policy', function () {
    $policy = new CategoryPolicy;
    $editor = User::factory()->create();
    $editor->assignRole('editor'); // has content.manage

    $stranger = User::factory()->create(); // no role

    $category = Category::factory()->create();

    expect($policy->viewAny($editor))->toBeTrue()
        ->and($policy->create($editor))->toBeTrue()
        ->and($policy->update($editor, $category))->toBeTrue()
        ->and($policy->delete($editor, $category))->toBeTrue()
        ->and($policy->viewAny($stranger))->toBeFalse()
        ->and($policy->create($stranger))->toBeFalse()
        ->and($policy->update($stranger, $category))->toBeFalse()
        ->and($policy->delete($stranger, $category))->toBeFalse();
});

test('content manage permission governs product and solution policy', function () {
    $productPolicy = new ProductPolicy;
    $solutionPolicy = new SolutionPolicy;

    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $stranger = User::factory()->create();

    $product = Product::factory()->create();
    $solution = Solution::factory()->create();

    expect($productPolicy->viewAny($editor))->toBeTrue()
        ->and($productPolicy->create($editor))->toBeTrue()
        ->and($productPolicy->update($editor, $product))->toBeTrue()
        ->and($productPolicy->delete($editor, $product))->toBeTrue()
        ->and($productPolicy->viewAny($stranger))->toBeFalse()
        ->and($solutionPolicy->viewAny($editor))->toBeTrue()
        ->and($solutionPolicy->create($editor))->toBeTrue()
        ->and($solutionPolicy->update($editor, $solution))->toBeTrue()
        ->and($solutionPolicy->delete($editor, $solution))->toBeTrue()
        ->and($solutionPolicy->viewAny($stranger))->toBeFalse();
});

test('content manage permission governs hero slide, page, and office policies', function () {
    $heroPolicy = new HeroSlidePolicy;
    $pagePolicy = new PagePolicy;
    $officePolicy = new OfficePolicy;

    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $stranger = User::factory()->create();

    $slide = HeroSlide::factory()->create();
    $page = Page::factory()->create();
    $office = Office::factory()->create();

    expect($heroPolicy->viewAny($editor))->toBeTrue()
        ->and($heroPolicy->update($editor, $slide))->toBeTrue()
        ->and($heroPolicy->viewAny($stranger))->toBeFalse()
        ->and($pagePolicy->viewAny($editor))->toBeTrue()
        ->and($pagePolicy->update($editor, $page))->toBeTrue()
        ->and($pagePolicy->viewAny($stranger))->toBeFalse()
        ->and($officePolicy->viewAny($editor))->toBeTrue()
        ->and($officePolicy->update($editor, $office))->toBeTrue()
        ->and($officePolicy->viewAny($stranger))->toBeFalse();
});

test('inquiry policy enforces granular permissions and forbids manual creation', function () {
    $policy = new InquiryPolicy;

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $editor = User::factory()->create();
    $editor->assignRole('editor'); // has inquiries.view and inquiries.update, but NOT inquiries.delete

    $inquiry = Inquiry::factory()->create();

    expect($policy->viewAny($editor))->toBeTrue()
        ->and($policy->view($editor, $inquiry))->toBeTrue()
        ->and($policy->update($editor, $inquiry))->toBeTrue()
        ->and($policy->delete($editor, $inquiry))->toBeFalse() // editor cannot delete
        ->and($policy->create($editor))->toBeFalse() // inquiries cannot be created manually
        ->and($policy->create($admin))->toBeFalse()
        ->and($policy->delete($admin, $inquiry))->toBeTrue(); // admin can delete
});

test('user and role policies require users manage and roles manage permissions', function () {
    $userPolicy = new UserPolicy;
    $rolePolicy = new RolePolicy;

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $editor = User::factory()->create();
    $editor->assignRole('editor'); // no users.manage or roles.manage

    $targetUser = User::factory()->create();
    $targetRole = Role::create(['name' => 'guest_role']);

    expect($userPolicy->viewAny($admin))->toBeTrue()
        ->and($userPolicy->create($admin))->toBeTrue()
        ->and($userPolicy->viewAny($editor))->toBeFalse()
        ->and($userPolicy->create($editor))->toBeFalse()
        ->and($userPolicy->update($editor, $targetUser))->toBeFalse()
        ->and($rolePolicy->viewAny($admin))->toBeTrue()
        ->and($rolePolicy->create($admin))->toBeTrue()
        ->and($rolePolicy->viewAny($editor))->toBeFalse()
        ->and($rolePolicy->create($editor))->toBeFalse()
        ->and($rolePolicy->update($editor, $targetRole))->toBeFalse();
});

test('manage site settings page requires settings manage permission', function () {
    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $editor = User::factory()->create();
    $editor->assignRole('editor');

    $this->actingAs($admin);
    expect(ManageSiteSettings::canAccess())->toBeTrue();

    $this->actingAs($editor);
    expect(ManageSiteSettings::canAccess())->toBeFalse();
});
