<?php

use App\Http\Controllers\{
    CategoryController,
    DashboardController,
    ExpenditureController,
    MemberController,
    ProductController,
    PurchaseController,
    PurchaseDetailController,
    ReportController,
    SaleController,
    SaleDetailController,
    SupplierController,
    UserController
};
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Route::get('/landing', function () {
    return view('land');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('home');
    })->name('dashboard');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
        Route::resource('category', CategoryController::class);

        Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
        Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete_selected');
        Route::post('/product/print-barcode', [ProductController::class, 'printBarcode'])->name('product.print_barcode');
        Route::resource('product', ProductController::class);

        Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
        Route::resource('member', MemberController::class);

        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('supplier', SupplierController::class);

        Route::get('/expenditure/data', [ExpenditureController::class, 'data'])->name('expenditure.data');
        Route::resource('expenditure', ExpenditureController::class);

        Route::get('/purchase/data', [PurchaseController::class, 'data'])->name('purchase.data');
        Route::get('/purchase/{id}/create', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::resource('purchase', PurchaseController::class)->except('create');

        Route::get('/purchase_detail/{id}/data', [PurchaseDetailController::class, 'data'])->name('purchase_detail.data');
        Route::get('/purchase_detail/loadform/{discount}/{total}', [PurchaseDetailController::class, 'loadForm'])->name('purchase_detail.load_form');
        Route::resource('purchase_detail', PurchaseDetailController::class)->except('create', 'show', 'edit');

        Route::get('/sale/data', [SaleController::class, 'data'])->name('sale.data');
        Route::get('sale', [SaleController::class, 'index'])->name('sale.index');
        Route::get('sale/{id}', [SaleController::class, 'show'])->name('sale.show');
        Route::delete('sale/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');

        Route::get('/report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report/data/{begin}/{end}', [ReportController::class, 'data'])->name('report.data');
        // Route::get('/report/pdf/{begin}/{end}', [ReportController::class, 'exportPDF'])->name('report.export_pdf');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('user', UserController::class);
    });

    Route::get('/transaction/new', [SaleController::class, 'create'])->name('transaction.new');
    Route::post('/transaction/save', [SaleController::class, 'store'])->name('transaction.save');
    Route::get('/transaction/finish', [SaleController::class, 'finish'])->name('transaction.finish');
    Route::get('/transaction/small-note', [SaleController::class, 'smallNote'])->name('transaction.small_note');
    Route::get('/transaction/big-note', [SaleController::class, 'bigNote'])->name('transaction.big_note');

    Route::get('/transaction/{id}/data', [SaleDetailController::class, 'data'])->name('transaction.data');
    Route::get('/transaction/loadform/{discount}/{total}/{accepted}', [SaleDetailController::class, 'loadForm'])->name('transaction.load_form');
    Route::resource('transaction', SaleDetailController::class)->except('show');
});
