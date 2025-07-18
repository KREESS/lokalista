<?php

use App\Http\Controllers\admin\ChatAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\admin\KategoriAdminController;
use App\Http\Controllers\admin\LaporanPenjualanAdminController;
use App\Http\Controllers\admin\PesananAdminController;
use App\Http\Controllers\admin\ProdukAdminController;
use App\Http\Controllers\admin\ProfileAdminController;
use App\Http\Controllers\admin\RekeningAdminController;
use App\Http\Controllers\customer\AlamatUserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\customer\ChatCustomerController;
use App\Http\Controllers\customer\CheckoutCustomerController;
use App\Http\Controllers\Customer\DashboardCustomerController;
use App\Http\Controllers\customer\KeranjangCustomerController;
use App\Http\Controllers\customer\PesananCustomerController;
use App\Http\Controllers\customer\ProdukCustomerController;
use App\Http\Controllers\Customer\ProfileCustomerController;
use App\Http\Controllers\Superadmin\DashboardSuperAdminController;
use App\Http\Controllers\Superadmin\ProfileSuperAdminController;
use App\Http\Controllers\Superadmin\LaporanPenjualanSuperAdminController;
use App\Http\Controllers\Superadmin\SuperAdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LiveChatController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/home/produk', [HomeController::class, 'produk'])->name('home.produk');
Route::get('/produk/detail_produk/{produk}', [HomeController::class, 'detail_produk'])->name('home.produk_detail');
Route::get('/produk/kategori/{produk}', [HomeController::class, 'search_kategori'])->name('home.produk_kategori');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Auth::routes();

Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function ()
        {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('users/toggle/{user}', [App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('users.toggle');
    });
    

    Route::get('/admin/profile', [ProfileAdminController::class, 'index'])->name('admin.profile');
    Route::put('/admin/profile/data/{profile}', [ProfileAdminController::class, 'update_data'])->name('admin.profile_data_update');
    Route::put('/admin/profile/password/{profile}', [ProfileAdminController::class, 'update_password'])->name('admin.profile_password_update');
    Route::put('/admin/profile/foto/{profile}', [ProfileAdminController::class, 'update_foto'])->name('admin.profile_foto_update');

    Route::resource('/admin/kategori', KategoriAdminController::class);

    Route::resource('/admin/produk', ProdukAdminController::class);

    Route::resource('/admin/rekening', RekeningAdminController::class);

    Route::get('/admin/pesanan_masuk', [PesananAdminController::class, 'lihat_pesanan'])->name('admin.pesanan_masuk');
    Route::get('/admin/pesanan_masuk/terima/{pesanan}', [PesananAdminController::class, 'terima_pesanan'])->name('admin.pesanan_terima');
    Route::get('/admin/pesanan_masuk/tolak/{pesanan}', [PesananAdminController::class, 'tolak_pesanan'])->name('admin.pesanan_tolak');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Route lainnya ...
        Route::get('/pesanan/hapus/{id}', [PesananAdminController::class, 'hapus_pesanan'])->name('pesanan_hapus');
    });
    
    Route::get('/admin/pesanan_prosess', [PesananAdminController::class, 'pesanan_onprosses'])->name('admin.pesanan_prosses');

    Route::get('/admin/pesanan_invoice/{pesanan}', [PesananAdminController::class, 'invoice'])->name('admin.pesanan_invoice');

    Route::get('/admin/pesanan/dp/tagihan/{pesanan}', [PesananAdminController::class, 'pesanan_dp_tagihan'])->name('admin.pesanan_tagihan');

    Route::get('/admin/pesanan/dp/tolak_sisa/{pesanan}', [PesananAdminController::class, 'tolak_sisa'])->name('admin.tolak_sisa');

    Route::post('/admin/pesanan_kirim', [PesananAdminController::class, 'pesanan_kirim'])->name('admin.pesanan_kirim');
    Route::get('/admin/pesanan_deliver', [PesananAdminController::class, 'pesanan_deliver'])->name('admin.pesanan_deliver');

    Route::get('/livechat', [ChatAdminController::class, 'livechat_index'])->name('admin.livechat');
    // Route::get('/livechat/{user_id}', [ChatAdminController::class, 'livechat_detail'])->name('admin.livechat.detail');
    Route::post('/livechat/send', [ChatAdminController::class, 'livechat_send'])->name('admin.livechat.send');
    Route::get('/admin/livechat/{id}', [ChatAdminController::class, 'livechatDetail'])->name('admin.livechat.detail');

    Route::get('/admin/Laporan', [LaporanPenjualanAdminController::class, 'index'])->name('admin.laporan');
    Route::post('/admin/Laporan', [LaporanPenjualanAdminController::class, 'laporan_cari'])->name('admin.laporan_cari');
});

Route::middleware(['auth', 'user-access:customer'])->group(function () {

    Route::get('/customer/dashboard', [DashboardCustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/customer/dashboard/detail/{dashboard}', [DashboardCustomerController::class, 'detail_dashboard'])->name('customer.dashboard_detail');
    Route::get('/customer/dashboard/kategori/{dashboard}', [DashboardCustomerController::class, 'search_kategori'])->name('customer.dashboard_kategori');

    Route::get('/customer/profile', [ProfileCustomerController::class, 'index'])->name('customer.profile');
    Route::put('/customer/profile/data/{profile}', [ProfileCustomerController::class, 'update_data'])->name('customer.profile_data_update');
    Route::put('/customer/profile/password/{profile}', [ProfileCustomerController::class, 'update_password'])->name('customer.profile_password_update');
    Route::put('/customer/profile/foto/{profile}', [ProfileCustomerController::class, 'update_foto'])->name('customer.profile_foto_update');

    Route::get('/customer/produk', [ProdukCustomerController::class, 'index'])->name('customer.produk');
    Route::get('/customer/produk/detail/{id}', [ProdukCustomerController::class, 'detail_produk'])->name('customer.produk.detail');
    Route::get('/customer/produk/detail/{produk}', [ProdukCustomerController::class, 'detail_produk'])->name('customer.produk_detail');
    Route::get('/customer/produk/search', [ProdukCustomerController::class, 'search'])->name('customer.search');
    Route::get('/customer/produk/kategori/{produk}', [ProdukCustomerController::class, 'search_kategori'])->name('customer.produk_kategori');

    Route::get('/customer/keranjang', [KeranjangCustomerController::class, 'index'])->name('customer.keranjang');
    Route::post('/customer/keranjang', [KeranjangCustomerController::class, 'store'])->name('customer.keranjang_store');
    Route::put('/customer/keranjang/{keranjang}', [KeranjangCustomerController::class, 'update'])->name('customer.keranjang_update');
    Route::delete('/customer/keranjang/{keranjang}', [KeranjangCustomerController::class, 'delete'])->name('customer.keranjang_delete');

    Route::get('/customer/checkout/{id_keranjang}', [CheckoutCustomerController::class, 'index'])->name('customer.checkout');

    Route::resource('/customer/alamat', AlamatUserController::class);
    Route::delete('/customer/pesanan/{id}', [PesananCustomerController::class, 'destroy'])->name('customer.pesanan.destroy');

    Route::post('/midtrans/token', [PesananCustomerController::class, 'getSnapToken'])->name('midtrans.token');
    Route::get('/customer/pesanan', [PesananCustomerController::class, 'index'])->name('customer.pesanan');
    Route::post('/customer/pesanan/store', [PesananCustomerController::class, 'store_pesanan'])->name('customer.pesanan_store');
    Route::get('/customer/pesanan/upload_ulang/{pesanan}', [PesananCustomerController::class, 'upload_ulang'])->name('customer.upload_ulang');
    Route::post('/customer/pesanan/upload_ulang/store', [PesananCustomerController::class, 'upload_store'])->name('customer.upload_store');

    Route::post('/customer/pesanan/sisa_tagihan', [PesananCustomerController::class, 'upload_sisa_tagihan'])->name('customer.upload_sisa_tagihan');

    Route::get('/customer/pesanan_invoice/{pesanan}', [PesananCustomerController::class, 'invoice'])->name('customer.pesanan_invoice');

    Route::get('/customer/pesanan_deliver', [PesananCustomerController::class, 'pesanan_deliver'])->name('customer.pesanan_deliver');

    Route::post('/customer/pesanan_diterima', [PesananCustomerController::class, 'pesanan_diterima'])->name('customer.pesanan_diterima');
    Route::get('/customer/riwayat_pesanan', [PesananCustomerController::class, 'history'])->name('customer.pesanan_history');

    Route::get('/customer/chat', [ChatCustomerController::class, 'index'])->name('customer.chat');
    Route::post('/customer/chat', [ChatCustomerController::class, 'send'])->name('customer.post_chat');


    // PAYMENT OTOMATIS DENGAN MENGGUNAKAN MIDTRANS
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/midtrans/callback', [PaymentController::class, 'handleMidtransCallback']);
    Route::post('/checkout/proses', [PaymentController::class, 'proses'])->name('checkout.proses');
    Route::any('/checkout/sukses', [PaymentController::class, 'updateStatusPembayaran'])->name('checkout.sukses');
});


Route::middleware(['auth', 'user-access:super admin'])->group(function () {

    Route::get('/superadmin/dashboard', [DashboardSuperAdminController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/superadmin/profile', [ProfileSuperAdminController::class, 'index'])->name('superadmin.profile');
    Route::put('/superadmin/profile/data/{profile}', [ProfileSuperAdminController::class, 'update_data'])->name('superadmin.profile_data_update');
    Route::put('/superadmin/profile/password/{profile}', [ProfileSuperAdminController::class, 'update_password'])->name('superadmin.profile_password_update');
    Route::put('/superadmin/profile/foto/{profile}', [ProfileSuperAdminController::class, 'update_foto'])->name('superadmin.profile_foto_update');
    Route::get('/superadmin/Laporan', [LaporanPenjualanSuperAdminController::class, 'index'])->name('superadmin.laporan');
    Route::post('/superadmin/Laporan', [LaporanPenjualanSuperAdminController::class, 'laporan_cari'])->name('superadmin.laporan_cari');

    Route::get('/users', [SuperAdminUserController::class, 'index'])->name('superadmin.users.index');
    Route::get('/users/create', [SuperAdminUserController::class, 'create'])->name('superadmin.users.create');
    Route::post('/users/store', [SuperAdminUserController::class, 'store'])->name('superadmin.users.store');
    Route::get('/users/edit/{id}', [SuperAdminUserController::class, 'edit'])->name('superadmin.users.edit');
    Route::put('/users/update/{id}', [SuperAdminUserController::class, 'update'])->name('superadmin.users.update');
    Route::delete('/users/delete/{id}', [SuperAdminUserController::class, 'destroy'])->name('superadmin.users.destroy');
    Route::post('/users/toggle/{id}', [SuperAdminUserController::class, 'toggleActive'])->name('superadmin.users.toggle');
});

Route::middleware('auth')->group(function () {
    Route::get('/live-chat/fetch', [LiveChatController::class, 'fetch'])->name('livechat.fetch');
    Route::post('/live-chat/send', [LiveChatController::class, 'send'])->name('livechat.send');
});
