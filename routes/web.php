<?php

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

\Auth::routes();

Route::get('user/forgot/password', function(){
	return view('auth.passwords.email');
})->name('forgot.password');

Route::get('/', 'PageController@home')->name('home');

Route::get('/about-us', 'PageController@about')->name('aboutpage');

Route::get('/location', 'PageController@location')->name('locationpage');

#Selected building
Route::get('/location/{building}', 'PageController@showLocation')->name('location.show');

Route::get('/location/{building}/reservation/{room}', 'PageController@reservation')->name('location.reservation');


Route::get('{slug}', 'PageController@show');

Route::post('/reservation/store', 'Admins\ReservationController@store')->name('reservation.store');

Route::get('/gallery', function () { return view('pages.gallery'); })->name('gallerypage');

Route::get('tenant/logout', function(){
    \Auth::logout();
    return redirect()->route('home');
})->name('tenant.logout');

Route::post('subscribe', 'SubscriptionController@store')->name('subscribe');


Route::namespace('Tenants')
->middleware('auth')
->prefix('tenant')
->group(function(){
	Route::get('/profile', 'TenantController@index')->name('tenant.profile');
	Route::get('/overview', 'UnpaidBillController@index')->name('tenant.overview');
	Route::post('/profile/update/{id}', 'TenantController@update')->name('tenant.update.profile');
	Route::post('/password/update/{id}', 'TenantController@updatePassword')->name('tenant.update.password');
	Route::post('unpaid/fetch/q', 'UnpaidBillFetchController@fetch')->name('unpaid.bills.fetch');
	Route::post('tenantrent/fetch/q', 'BillingRentFetchController@fetch')->name('tenant.rent.fetch');
	Route::post('tenantutil/fetch/q', 'BillingUtilityFetchController@fetch')->name('tenant.util.fetch');
	Route::post('history/bill/fetch/q', 'HistoryFetchController@fetch')->name('history.bill.fetch');
	
	Route::get('document', 'DocumentController@index')->name('document.index');
	Route::post('document/store', 'DocumentController@store')->name('document.store');

	Route::post('document/fetch/q', 'DocumentFetchController@fetch')->name('document.fetch');

	Route::get('/payments', 'TenantController@payment')->name('payments');
	Route::post('/payments', 'TenantController@paymentSuccess')->name('paymentsSuccess');

	Route::post('checkout/process', 'TenantController@process')->name('checkout.payment');

	Route::get('/checkout/{id}', 'TenantController@checkout')->name('checkout');
	
	Route::post('billing/fetch/rent/{id?}', 'InvoiceFetchController@fetchItem')->name('billing.rent.fetch');

	Route::post('checkout/success', 'TenantController@success')->name('checkout.success');

	Route::get('invoice/{id}', 'TenantController@printInvoice')->name('invoice');
	Route::get('generate/invoice/{id}', 'TenantController@generateInvoice')->name('invoice.print');
});

Route::name('admin.')
->prefix('admin')
->namespace('Admins')
->group(function() {
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.show');
	Route::post('login', 'Auth\LoginController@login')->name('login');
	Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email.show');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.show');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
});

Route::namespace('Admins')
->middleware('admin_auth')
->prefix('admin')
->group(function() {

	Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');
	Route::get('/permissions', 'AdminController@index')->name('permissions');
	Route::get('/permission/create', 'AdminController@create')->name('permission.create');
	Route::post('/permission/store', 'AdminController@store')->name('permission.store');
	Route::get('/permission/edit/{id}', 'AdminController@edit')->name('permission.edit');
	Route::post('/permission/update/{id}', 'AdminController@update')->name('permission.update');
	Route::get('/permission/destroy/{id}', 'AdminController@destroy')->name('permission.destroy');

	Route::post('billing/fetch/officer/{id?}', 'BillingOfficerFetchController@fetchItem')->name('billing.officer.fetch');

	Route::get('/building', 'BuildingController@index')->name('buildings');
	Route::get('/buildings/create', 'BuildingController@create')->name('building.create');
	Route::post('/buildings/store', 'BuildingController@store')->name('building.store');
	Route::get('/buildings/edit/{id}', 'BuildingController@edit')->name('building.edit');
	Route::post('/buildings/update/{id}', 'BuildingController@update')->name('building.update');
	Route::get('/buildings/destroy/{id}', 'BuildingController@destroy')->name('building.destroy');
	Route::delete('/amenity/destroy/{id}', 'BuildingController@destroyAmenities')->name('amenity.destroy');

	Route::post('locations/fetch/positions', 'BuildingFetchController@fetchPositions')->name('locations.fetch-positions');
	Route::post('building/fetch/{id?}', 'BuildingFetchController@fetchItem')->name('building.fetch');

	Route::get('/rooms', 'RoomController@index')->name('rooms');
	Route::get('/building/room/{id}', 'RoomController@showBuilding')->name('selected.building');
	Route::get('/building/room/{id}?q=', 'RoomController@showBuilding')->name('selected.building');
	Route::get('/room/create/{id}', 'RoomController@create')->name('room.create');
	Route::post('/room/store', 'RoomController@store')->name('room.store');
	Route::get('/room/edit/{id}', 'RoomController@edit')->name('room.edit');
	Route::post('/room/update/{id}', 'RoomController@update')->name('room.update');
	Route::get('/room/destroy/{id}', 'RoomController@destroy')->name('room.destroy');

	Route::get('/applicants', 'ReservationController@index')->name('applicants');
	Route::get('/applicants/edit/{id}', 'ReservationController@edit')->name('applicant.edit');
	Route::post('/applicants/update/{id}', 'ReservationController@update')->name('applicant.update');
	Route::get('/applicants/deny/{id}', 'ReservationController@deny')->name('applicant.deny');

	Route::post('applicants/fetch/q', 'ReservationFetchController@fetch')->name('applicants.fetch');
	Route::post('applicants/fetch/{id?}', 'ReservationFetchController@fetchItem')->name('applicant.fetch');


	Route::get('/tenants', 'ContractController@index')->name('tenants');
	Route::get('/contract/create', 'ContractController@create')->name('contract.create');
	Route::post('/contract/store', 'ContractController@store')->name('contract.store');
	Route::get('/contracts', 'ContractController@contractIndex')->name('contracts');
	Route::get('/contract/edit/{id}', 'ContractController@edit')->name('contract.edit');
	Route::post('/contract/update/{id}', 'ContractController@update')->name('contract.update');
	Route::get('/contract/show/{id}', 'ContractController@show')->name('contract.show');
	Route::post('/contract/update/info/{id}', 'ContractController@updateInfo')->name('contract.update.info');

	Route::post('tenants/fetch/q', 'ContractFetchController@fetch')->name('tenants.fetch');
	Route::post('tenant/fetch/{id?}', 'ContractFetchController@fetchItem')->name('tenant.fetch');

	Route::get('/rent', 'BillingRentController@index')->name('billing');
	Route::post('/rent/store', 'BillingRentController@store')->name('billing.store');
	Route::post('/rent/update/{id}', 'BillingRentController@update')->name('billing.update');
	Route::post('/rent/penalty/{id}', 'BillingRentController@penalty')->name('billing.penalty');
	Route::get('/rent/edit/{id}', 'BillingRentController@edit')->name('billing.edit');

	Route::get('/history/show/{id}', 'BillingRentController@show')->name('history.show');

	Route::post('rents/fetch/q', 'BillingRentFetchController@fetch')->name('rents.fetch');
	Route::post('rent/fetch/{id?}', 'BillingRentFetchController@fetchItem')->name('rent.fetch');
	Route::post('history/fetch/q', 'InvoiceFetchController@fetch')->name('histories.fetch');
	Route::post('history/fetch/{id?}', 'InvoiceFetchController@fetchItem')->name('history.fetch');

	Route::get('utility/edit/{id}', 'BillingUtilityController@edit')->name('utility.edit');
	Route::post('utility/update/{id}', 'BillingUtilityController@update')->name('utility.update');

	Route::post('utilitiesi/fetch/q', 'BillingUtilityFetchController@fetch')->name('utilities.fetch');
	Route::post('utility/fetch/{id?}', 'BillingUtilityFetchController@fetchItem')->name('utility.fetch');

	Route::get('about', 'AboutUsContentController@index')->name('about.index');
	Route::get('about/create', 'AboutUsContentController@create')->name('about.create');
	Route::post('about/store', 'AboutUsContentController@store')->name('about.store');
	Route::get('about/{id}', 'AboutUsContentController@edit')->name('about.edit');
	Route::post('about/{id}', 'AboutUsContentController@update')->name('about.update');

	Route::post('about/fetch/q', 'AboutUsContentFetchController@fetch')->name('abouts.fetch');
	Route::post('about/fetch/content/{id?}', 'AboutUsContentFetchController@fetchItem')->name('about.fetch');

	Route::get('gallery', 'GalleryController@index')->name('gallery.index');
	Route::get('gallery/create', 'GalleryController@create')->name('gallery.create');
	Route::post('gallery/store', 'GalleryController@store')->name('gallery.store');
	Route::get('gallery/{id}', 'GalleryController@edit')->name('gallery.edit');
	Route::post('gallery/{id}', 'GalleryController@update')->name('gallery.update');
	Route::get('gallery/destroy/{id}', 'GalleryController@destroy')->name('gallery.destroy');
	Route::get('gallery/destroy/image/{id}', 'GalleryController@destroyImage')->name('gallery.destroy.image');

	Route::post('galleries/fetch/q', 'GalleryFetchController@fetch')->name('galleries.fetch');
	Route::post('gallery/fetch/content/{id?}', 'GalleryFetchController@fetchItem')->name('gallery.fetch');

	Route::get('pages', 'PageController@index')->name('pages.index');
	Route::get('pages/create', 'PageController@create')->name('pages.create');
	Route::post('pages/store', 'PageController@store')->name('pages.store');
	Route::get('pages/{id}', 'PageController@edit')->name('pages.edit');
	Route::post('pages/{id}', 'PageController@update')->name('pages.update');
	Route::delete('pages/{id}', 'PageController@destroy')->name('pages.destroy');
	Route::post('pages/restore/{user}', 'PageController@restore')->name('pages.restore');

	Route::post('pages/fetch/q', 'PageFetchController@fetch')->name('pages.fetch');
	Route::post('pages/fetch/q?archive=1', 'PageFetchController@fetch')->name('pages.fetch.archive');
	Route::post('pages/fetch/pages/{id?}', 'PageFetchController@fetchItem')->name('page.fetch');


	Route::get('page-items', 'PageItemController@index')->name('page-items.index');
	Route::get('page-items/create', 'PageItemController@create')->name('page-items.create');
	Route::post('page-items/store', 'PageItemController@store')->name('page-items.store');
	Route::get('page-items/{id}', 'PageItemController@edit')->name('page-items.edit');
	Route::post('page-items/{id}', 'PageItemController@update')->name('page-items.update');
	Route::delete('page-items/{id}', 'PageItemController@destroy')->name('page-items.destroy');
	Route::post('page-items/restore/{user}', 'PageItemController@restore')->name('page-items.restore');

	Route::post('page-items/fetch/q', 'PageItemFetchController@fetch')->name('page-items.fetch');
	Route::post('page-items/fetch/q?archive=1', 'PageItemFetchController@fetch')->name('page-items.fetch.archive');
	Route::post('page-items/fetch/q?page_id={id}', 'PageItemFetchController@fetch')->name('page-items.fetch.page');
	Route::post('page-items/fetch/page-items/{id?}', 'PageItemFetchController@fetchItem')->name('page-item.fetch');

	Route::get('carousel', 'CarouselController@index')->name('carousel.index');
	Route::get('carousel/edit/{id}', 'CarouselController@edit')->name('carousel.edit');
	Route::get('carousel/create', 'CarouselController@create')->name('carousel.create');
	Route::post('carousel/store', 'CarouselController@store')->name('carousel.store');
	Route::post('carousel/update/{id}', 'CarouselController@update')->name('carousel.update');
	Route::delete('carousel/destroy/{id}', 'CarouselController@destroy')->name('carousel.destroy');
	Route::post('carousel/restore/{id}', 'CarouselController@restore')->name('carousel.restore');

	Route::post('carousel/{id}', 'CarouselImageController@destroy')->name('carousel.destroy');

	Route::post('carousels/fetch/q', 'CarouselFetchController@fetch')->name('carousels.fetch');
	Route::post('carousels/fetch/q?archive=1', 'CarouselFetchController@fetch')->name('carousels.archive');
	Route::post('carousels/fetch/carousel/{id?}', 'CarouselFetchController@fetchItem')->name('carousel.fetch');

	
	Route::post('utility', 'UtilityController@store')->name('utility.store');
	Route::post('utility/fee', 'BillingUtilityController@store')->name('utility.fee.store');
	Route::post('utility/penalty/{id}', 'BillingUtilityController@penalty')->name('utility.penalty');

	Route::get('/overview', 'PageController@overview')->name('overview');

	Route::get('/evict/{id}', 'ContractController@evict')->name('evict.tenant');

	Route::get('/export/rent', 'BillingRentController@export')->name('export.billing.rent');
	Route::get('/export/utility', 'BillingUtilityController@export')->name('export.billing.utility');
	Route::post('/export/contracts', 'ContractController@export')->name('export.contract');

	Route::get('contract/print/{id}', 'ContractController@printContract')->name('contract.print');

});

// Route::get('/home', 'HomeController@index')->name('home');
