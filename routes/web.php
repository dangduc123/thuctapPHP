<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\RevenueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/user', [UserController::class, 'index'])->name('user.index');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [LogoutController::class, 'logout'])->name('admin.logout');

Route::get('/user/login', [AdminAuthController::class, 'showLoginUserForm'])->name('user.login');
Route::post('/user/login', [AdminAuthController::class, 'login_user']);
Route::post('/user/logout', [LogoutController::class, 'logout2'])->name('user.logout');








Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'register']);

Route::get('/user/register', [RegisterController::class, 'showRegisterUserForm'])->name('user.register');
Route::post('/user/register', [RegisterController::class, 'register_user']);

// Route::get('/admin/product', [ProductController::class, 'showProductForm'])->name('admin.product');
// Route::post('/admin/product', [ProductController::class, 'product']);

Route::get('/admin/product', [ProductController::class, 'index'])->name('product');

// Route::get('/admin/invoice', [InvoiceController::class, 'showInvoiceForm'])->name('admin.invoice');
// Route::post('/admin/invoice', [InvoiceController::class, 'invoice']);

Route::get('/admin/invoice', [InvoiceController::class, 'index'])->name('invoice');


// Route::get('/admin/ingredient', [IngredientController::class, 'showIngredientForm'])->name('admin.ingredient');
// Route::post('/admin/ingredient', [IngredientController::class, 'ingredient']);
Route::get('/admin/ingredient', [IngredientController::class, 'index'])->name('admin.ingredient');

Route::get('/admin/ingredient/add_ingredient', [IngredientController::class, 'createForm'])->name('admin.add_ingredient');
Route::post('/admin/ingredient/store', [IngredientController::class, 'store'])->name('admin.ingredient.store');


Route::get('/admin/product/create', [ProductController::class, 'createForm'])->name('admin.create');
Route::post('/admin/product/store', [ProductController::class, 'store'])->name('admin.product.store');


Route::get('/admin/admin_list', [AdminController::class, 'showAdminForm'])->name('admin.admin_list');
Route::post('/admin/admin_list', [AdminController::class, 'admin_list']);

// Route::get('/user/user_list', [UserController::class, 'showUserForm'])->name('user.user_list');
// Route::post('/user/user_list', [UserController::class, 'user_list']);

Route::get('/user/user_list', [UserController::class, 'index1'])->name('user.user_list');


Route::get('/user/introduce', [UserController::class, 'showIntroduce'])->name('user.introduce');
Route::post('/user/introduce', [UserController::class, 'introduce']);

Route::get('/user/menu', [UserController::class, 'showMenu'])->name('user.menu');
Route::post('/user/menu', [UserController::class, 'menu']);

Route::get('/user/cart', [UserController::class, 'showCart'])->name('user.cart');
Route::post('/user/cart', [UserController::class, 'cart']);

Route::get('/user/contact', [UserController::class, 'showContact'])->name('user.contact');
Route::post('/user/contact', [UserController::class, 'contact']);


Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{id}/update', [AdminController::class, 'update'])->name('admin.update');

Route::get('/user/{id}/edit_user', [UserController::class, 'edit'])->name('user.edit_user');
Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update');


Route::get('/admin/delete_admin/{id}', [AdminController::class, 'delete'])->name('admin.delete_admin');
Route::get('/admin/delete_ingredient/{id}', [IngredientController::class, 'delete'])->name('admin.delete_ingredient');

Route::get('/user/delete_user/{id}', [UserController::class, 'delete'])->name('user.delete_user');


Route::get('/admin/{id}/edit_product', [ProductController::class, 'edit_product'])->name('admin.edit_product');
Route::put('/admin/update_product/{id}', [ProductController::class, 'update_product'])->name('admin.update_product');


Route::get('/admin/{id}/edit_ingredient', [IngredientController::class, 'edit'])->name('admin.edit_ingredient');
Route::put('/admin/{id}', [IngredientController::class, 'update_ingredient'])->name('admin.update_ingredient');


Route::get('/admin/delete_product/{id}', [ProductController::class, 'delete_product'])->name('admin.delete_product');

Route::put('/admin', [AdminController::class, 'uploadAvatar'])->name('admin.uploadAvatar');

Route::get('/search', [SearchController::class, 'index']);

Route::post('/add_to_cart', [CartController::class, 'addToCart'])->name('add_to_cart');
Route::delete('/remove_from_cart/{id}', [CartController::class, 'removeFromCart'])->name('remove_from_cart');

Route::get('/user/showinvoice/{id}', [UserController::class, 'showInvoice'])->name('user.showinvoice');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

Route::get('/user/showinvoice2/{id}', [UserController::class, 'showInvoice2'])->name('user.showinvoice2');
Route::post('/checkout/{productId}', [CheckoutController::class, 'processCheckout2'])->name('checkout.process2');

Route::get('/thank_you/{id}', [UserController::class, 'showThankYou'])->name('user.thank_you');

Route::get('/admin/edit_invoice/{id}', [InvoiceController::class, 'edit'])->name('admin.edit_invoice');
Route::post('/admin/update_invoice/{id}', [InvoiceController::class, 'update'])->name('admin.update_invoice');
Route::get('/admin/delete/{id}', [InvoiceController::class, 'delete']);

Route::get('/user/showallinvoice', [UserController::class, 'showAllInvoice'])->name('user.showallinvoice');
Route::post('/checkout/all', [CheckoutController::class, 'processAll'])->name('checkout.process.all');

Route::get('/user/profile', [UserController::class, 'showProfile'])->name('user.profile');
Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');


Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::get('/forgot-password', [AdminAuthController::class, 'forgetPass'])->name('user.forgot-password');
Route::post('/forgot-password', [AdminAuthController::class, 'postForgetPass']);

Route::get('/reset-password/{user}/{token}', [AdminAuthController::class, 'getPass'])->name('user.reset-password');
Route::post('/reset-password/{user}/{token}', [AdminAuthController::class, 'postGetPass']);


Route::patch('/update-cart/{id}', [CartController::class, 'update']);


Route::post('/user/contact', [ContactFormController::class, 'store'])->name('user.contact');

Route::get('/user/verify/{verification_code}', [ContactFormController::class, 'verify'])->name('verification.verify');

Route::get('/user/resend', [ContactFormController::class, 'resend'])->name('verification.resend');

// Route::get('/get_cart_data', [CartController::class, 'getCartData'])->name('get_cart_data');

// Route::post('/update_cart', [CartController::class, 'updateCart'])->name('update_cart');

Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue.index');


Route::get('/products/{type}', [UserController::class, 'showByType'])->name('products.showByType');

Route::put('/user/{id}/permissions', [UserController::class, 'update_permissions'])->name('update_permissions');





