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
//LOGIN - LOGOUT
Route::get('/login','Otentikasi\OtentikasiController@login')->name('login');
Route::post('/otentikasi/logout','Otentikasi\OtentikasiController@logout')->name('logout');
Route::post('/otentikasi/cek_login','Otentikasi\OtentikasiController@cek_login');

// Route::get('/otentikasi/email_reset_password','OtentikasiController@email_reset_password')->name('login');
// Route::post('/otentikasi/send_reset_password','OtentikasiController@send_reset_password')->name('login');


//CheckLogin
Route::middleware(['checklogin'])->group(function(){
    Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('/', function () {
        return redirect('/home');
    });

    //Otentikasi
    //Role
    Route::get('/roles/delete/{id}','Otentikasi\RolesController@delete');
    Route::resource('roles','Otentikasi\RolesController');
    //Menu
    Route::get('/menus/delete/{id}','Otentikasi\MenusController@delete');
    Route::resource('menus','Otentikasi\MenusController');
    //User
    Route::get('/users/delete/{id}','Otentikasi\UsersController@delete');
    Route::get('/users/my_profile','Otentikasi\UsersController@my_profile');
    Route::get('users/reset_password','Otentikasi\UsersController@reset_password');
    Route::post('users/update_reset_password','Otentikasi\UsersController@update_reset_password');
    Route::get('users/ganti_password','Otentikasi\UsersController@ganti_password');
    Route::post('users/save_ganti_password','Otentikasi\UsersController@save_ganti_password');
    Route::resource('users','Otentikasi\UsersController');

    //User_Role
    Route::get('/user_roles/delete/{id}','Otentikasi\UserRolesController@delete');
    Route::resource('user_roles','Otentikasi\UserRolesController');
    //Role_menu
    Route::get('/role_menus/delete/{id}','Otentikasi\RoleMenusController@delete');
    Route::resource('role_menus','Otentikasi\RoleMenusController');


    //Projects Group
    //Project
    Route::post('projects/ambilData', 'Project\ProjectsController@ambilData');
    Route::post('projects/buatProject', 'Project\ProjectsController@buatProject');
    Route::get('/projects/delete/{project}','Project\ProjectsController@delete');
    Route::resource('projects','Project\ProjectsController');

    //Scan QR
    Route::get('/projects/scan_qr','Project\ProjectsController@scan_qr');
    
    //Project Activities
    Route::get('project_team_managements/{project}','Project\ProjectTeamManagementsController@index');
    Route::post('project_team_managements/ambilData','Project\ProjectTeamManagementsController@ambilData');
    Route::post('project_team_managements/ambilProvinsi','Project\ProjectTeamManagementsController@ambilProvinsi');
    // Route::get('project_plans/{project}','Project\ProjectPlansController@index');

    //Project Plan
    Route::get('project_plans/index2', 'Project\ProjectPlansController@index2');
    Route::get('project_plans/create2', 'Project\ProjectPlansController@create2');
    Route::post('project_plans/store2', 'Project\ProjectPlansController@store2');
    Route::get('project_plans/delete2/{project_plan}', 'Project\ProjectPlansController@delete2');
    Route::get('project_plans/{project_plan}/edit2', 'Project\ProjectPlansController@edit2');
    Route::post('project_plans/update2/{project_plan}', 'Project\ProjectPlansController@update2');
    Route::resource('project_plans','Project\ProjectPlansController');
    Route::get('project_plans/prepare_absensi/{project_plan}', 'Project\ProjectPlansController@prepare_absensi');
    Route::get('project_plans/schedule/{project_id}', 'Project\ProjectPlansController@schedule');
    Route::get('project_plans/schedule2/{project_id}', 'Project\ProjectPlansController@schedule2');
    Route::post('project_plans/simpanSchedule', 'Project\ProjectPlansController@simpanSchedule');
    Route::post('project_plans/simpanSchedule2', 'Project\ProjectPlansController@simpanSchedule2');
    Route::post('project_plans/tambah', 'Project\ProjectPlansController@tambah')->name('project_plans.tambah');
    Route::post('project_plans/tambah2', 'Project\ProjectPlansController@tambah2')->name('project_plans.tambah2');

    //Project Kegiatan & absensi (of Plan)
    Route::get('/project_kegiatans/delete/{project_kegiatan}','Project\ProjectKegiatansController@delete');
    Route::resource('project_kegiatans','Project\ProjectKegiatansController');
    Route::get('/project_kegiatans/print_qr/{project_kegiatan}','Project\ProjectKegiatansController@print_qr');
    Route::get('/project_absensis/delete/{project_absensi}','Project\ProjectAbsensisController@delete');
    Route::get('/project_absensis/scanqr','Project\ProjectAbsensisController@scanqr');
    Route::post('/project_absensis/saveqr','Project\ProjectAbsensisController@saveqr');
    Route::get('/project_absensis/list_absen_kegiatan/{project_kegiatan_id}','Project\ProjectAbsensisController@list_absen_kegiatan');

    Route::resource('project_absensis','Project\ProjectAbsensisController');
    
    //Project_kota
    Route::get('project_kotas/{project_id}','Project\ProjectKotasController@index');
    Route::get('project_kotas/create/{project_id}','Project\ProjectKotasController@create');
    Route::post('project_kotas','Project\ProjectKotasController@store');
    Route::get('project_kotas/{project_kota}/edit','Project\ProjectKotasController@edit');
    Route::patch('project_kotas/{project_kota}','Project\ProjectKotasController@update');
    Route::get('/project_kotas/delete/{project_kota}','Project\ProjectKotasController@delete');
    Route::post('project_kotas/editJumlah','Project\ProjectKotasController@editJumlah');

    //Project_jabatan
    Route::get('project_jabatans/{project_jabatan}','Project\ProjectJabatansController@index');
    Route::get('project_jabatans/create/{project_id}','Project\ProjectJabatansController@create');
    Route::post('project_jabatans','Project\ProjectJabatansController@store');
    Route::get('project_jabatans/{project_jabatan}/edit','Project\ProjectJabatansController@edit');
    Route::patch('project_jabatans/{project_jabatan}','Project\ProjectJabatansController@update');
    Route::get('/project_jabatans/delete/{project_jabatan}','Project\ProjectJabatansController@delete');

    //Project_team
    Route::get('project_teams/{project_team}','Project\ProjectTeamsController@index');
    Route::get('project_teams/create/{project_id}','Project\ProjectTeamsController@create');
    Route::post('project_teams','Project\ProjectTeamsController@store');
    Route::get('project_teams/{project_team}/edit','Project\ProjectTeamsController@edit');
    Route::patch('project_teams/{project_team}','Project\ProjectTeamsController@update');
    Route::get('/project_teams/delete/{project_team}','Project\ProjectTeamsController@delete');

    //Umum
    Route::get('/kotas/delete/{id}','Umum\KotasController@delete');
    Route::resource('kotas','Umum\KotasController');
    Route::get('/pekerjaans/delete/{id}','Umum\PekerjaansController@delete');
    Route::resource('pekerjaans','Umum\PekerjaansController');
    Route::get('/pendidikans/delete/{id}','Umum\PendidikansController@delete');
    Route::resource('pendidikans','Umum\PendidikansController');

    //Project Resources
    Route::get('/tasks/delete/{id}','ProjectResource\TasksController@delete');
    Route::resource('tasks','ProjectResource\TasksController');
    Route::get('/lokasis/delete/{id}','ProjectResource\LokasisController@delete');
    Route::resource('lokasis','ProjectResource\LokasisController');

    //Customer
    Route::get('/customers/delete/{id}','Customer\CustomersController@delete');
    Route::get('/customer_pics/delete/{id}','Customer\CustomerPicsController@delete');
    Route::resource('customers','Customer\CustomersController');
    Route::resource('customer_pics','Customer\CustomerPicsController');
    
    //Team 
    Route::get('/bahasas/delete/{id}','Team\BahasasController@delete');
    Route::get('/jabatans/delete/{id}','Team\JabatansController@delete');
    Route::get('/teams/delete/{id}','Team\TeamsController@delete');
    Route::resource('bahasas','Team\BahasasController');
    Route::resource('jabatans','Team\JabatansController');
    Route::resource('teams','Team\TeamsController');

    //Team Bahasa
    Route::get('team_bahasas/{team_bahasa}','Team\TeamBahasasController@index');
    Route::get('team_bahasas/create/{team_id}','Team\TeamBahasasController@create');
    Route::post('team_bahasas','Team\TeamBahasasController@store');
    Route::get('team_bahasas/{team_bahasa}/edit','Team\TeamBahasasController@edit');
    Route::patch('team_bahasas/{team_bahasa}','Team\TeamBahasasController@update');
    Route::get('team_bahasas/delete/{team_bahasa}','Team\TeamBahasasController@delete');

    //Bahasa Team
    Route::get('bahasa_teams/{bahasa_team}','Team\BahasaTeamsController@index');
    Route::get('bahasa_teams/create/{bahasa_id}','Team\BahasaTeamsController@create');
    Route::post('bahasa_teams','Team\BahasaTeamsController@store');
    Route::get('bahasa_teams/{bahasa_team}/edit','Team\BahasaTeamsController@edit');
    Route::patch('bahasa_teams/{bahasa_team}','Team\BahasaTeamsController@update');
    Route::get('bahasa_teams/delete/{team_bahasa}','Team\BahasaTeamsController@delete');

    //Team Jabatan
    Route::get('team_jabatans/{team_jabatan}','Team\TeamJabatansController@index');
    Route::get('team_jabatans/create/{team_id}','Team\TeamJabatansController@create');
    Route::post('team_jabatans','Team\TeamJabatansController@store');
    Route::get('team_jabatans/{team_jabatan}/edit','Team\TeamJabatansController@edit');
    Route::patch('team_jabatans/{team_jabatan}','Team\TeamJabatansController@update');
    Route::get('/team_jabatans/delete/{team_jabatan}','Team\TeamJabatansController@delete');
    
    //Jabatan Team
    Route::get('jabatan_teams/{jabatan_team}','Team\JabatanTeamsController@index');
    Route::get('jabatan_teams/create/{jabatan_id}','Team\JabatanTeamsController@create');
    Route::post('jabatan_teams','Team\JabatanTeamsController@store');
    Route::get('jabatan_teams/{jabatan_team}/edit','Team\JabatanTeamsController@edit');
    Route::patch('jabatan_teams/{jabatan_team}','Team\JabatanTeamsController@update');
    Route::get('/jabatan_teams/delete/{team_jabatan}','Team\JabatanTeamsController@delete');


    //Respondents
    Route::get('/respondents/delete/{id}','Respondent\RespondentsController@delete');
    Route::get('/import_excels/delete/{id}','Respondent\ImportExcelsController@delete');
    Route::resource('is_valids','Respondent\IsValidsController');
    Route::resource('sesAs','Respondent\SesAsController');
    Route::resource('sesBs','Respondent\SesBsController');
    Route::resource('sesFinals','Respondent\SesFinalsController');
    Route::resource('project_importeds','Respondent\ProjectImportedsController');
    Route::resource('respondents','Respondent\RespondentsController');
    Route::resource('import_excels','Respondent\ImportExcelsController');
    Route::resource('project_importeds', 'Respondent\ProjectImportedsController');

    //******************************************************/
    //**********  ----------- Produk -----------  ********** 
    //Ini ada 3 level : Kategori, Tipe, Nama
    //Tipe Produk tidak bisa pakai resource karena harus bawa $kategori_produk_id
    
    // ***** Kategori Produk
    Route::get('kategori_produks/delete/{id}','Produk\KategoriProduksController@delete');
    Route::resource('kategori_produks', 'Produk\KategoriProduksController');

    // ***** Tipe Produk
    Route::get('tipe_produks/delete/{id}','Produk\TipeProduksController@delete');
    Route::get('tipe_produks/{kategori_produk_id}', 'Produk\TipeProduksController@index');
    Route::get('tipe_produks/create/{kategori_produk_id}', 'Produk\TipeProduksController@create');
    Route::post('tipe_produks','Produk\TipeProduksController@store');
    Route::get('tipe_produks/{tipe_produk_id}/edit', 'Produk\TipeProduksController@edit');
    Route::patch('tipe_produks/{tipe_produk_id}','Produk\TipeProduksController@update');

    // ***** Nama Produk
    Route::get('nama_produks/delete/{id}','Produk\NamaProduksController@delete');
    Route::get('nama_produks/{tipe_produk_id}', 'Produk\NamaProduksController@index');
    Route::get('nama_produks/create/{tipe_produk_id}', 'Produk\NamaProduksController@create');
    Route::post('nama_produks','Produk\NamaProduksController@store');
    Route::get('nama_produks/{nama_produk_id}/edit', 'Produk\NamaProduksController@edit');
    Route::put('nama_produks/{nama_produk_id}','Produk\NamaProduksController@update');

    // ROUTE BUDGET
    Route::get('budgets', 'BudgetsController@index');
    Route::post('budgets/simpanLimit', 'BudgetsController@simpanLimit');
    Route::get('/budgets/divisi', 'BudgetsController@divisi');
    Route::get('/budgets/inputBudget/{budget}', 'BudgetsController@inputBudget');
    Route::post('budgets/simpanBudgetByDivisi', 'BudgetsController@simpanBudgetByDivisi');
    Route::get('/budgets/hapusBudgetDivisi/{id}/{waktu}', 'BudgetsController@hapusBudgetDivisi');
    Route::post('/budgets/editBudgetByDivisi', 'BudgetsController@editBudgetByDivisi');
    Route::get('/budgets/pengajuan', 'BudgetsController@pengajuan');
    Route::get('/budgets/pengajuanBudget/{waktu}', 'BudgetsController@pengajuanBudget');
    Route::post('/budgets/simpanPengajuan', 'BudgetsController@simpanPengajuan');
    Route::get('/budgets/persetujuan/{noid}', 'BudgetsController@persetujuan');
    Route::post('/budgets/simpanPersetujuan', 'BudgetsController@simpanPersetujuan');
    Route::get('/budgets/print/{waktu}', 'BudgetsController@print');

    // AKHIR ROUTE BUDGET

});


