<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/login', 'Otentikasi\OtentikasiController@login')->name('login');
Route::post('/otentikasi/logout', 'Otentikasi\OtentikasiController@logout')->name('logout');
Route::post('/otentikasi/cek_login', 'Otentikasi\OtentikasiController@cek_login');

// Route::get('/otentikasi/email_reset_password','OtentikasiController@email_reset_password')->name('login');
// Route::post('/otentikasi/send_reset_password','OtentikasiController@send_reset_password')->name('login');


//CheckLogin
Route::middleware(['checklogin'])->group(function () {
    Route::get('/home', 'DashboardController@index')->name('home');
    Route::get('/', function () {
        return redirect('/home');
    });

    Route::get('/kirimemail', 'DashboardController@kirimemail');
    Route::get('/seeemail', 'DashboardController@seeemail');

    //Otentikasi
    //Role
    Route::get('/roles/delete/{id}', 'Otentikasi\RolesController@delete');
    Route::resource('roles', 'Otentikasi\RolesController');
    //Menu
    Route::get('/menus/delete/{id}', 'Otentikasi\MenusController@delete');
    Route::resource('menus', 'Otentikasi\MenusController');
    //User
    Route::get('/users/delete/{id}', 'Otentikasi\UsersController@delete');
    Route::get('/users/my_profile', 'Otentikasi\UsersController@my_profile');
    Route::get('users/reset_password', 'Otentikasi\UsersController@reset_password');
    Route::post('users/update_reset_password', 'Otentikasi\UsersController@update_reset_password');
    Route::get('users/ganti_password', 'Otentikasi\UsersController@ganti_password');
    Route::post('users/save_ganti_password', 'Otentikasi\UsersController@save_ganti_password');
    Route::resource('users', 'Otentikasi\UsersController');

    //User_Role
    Route::get('/user_roles/delete/{id}', 'Otentikasi\UserRolesController@delete');
    Route::resource('user_roles', 'Otentikasi\UserRolesController');
    //Role_menu
    Route::get('/role_menus/delete/{id}', 'Otentikasi\RoleMenusController@delete');
    Route::resource('role_menus', 'Otentikasi\RoleMenusController');


    //Projects Group
    //Project
    Route::post('projects/ambilData', 'Project\ProjectsController@ambilData');
    Route::patch('/projects/upload', 'Project\ProjectsController@upload');
    Route::get('/projects/view/{project}', 'Project\ProjectsController@view');
    Route::post('projects/buatProject', 'Project\ProjectsController@buatProject');
    Route::get('/projects/delete/{project}', 'Project\ProjectsController@delete');
    Route::get('/projects/view_respondents/{project}', 'Project\ProjectsController@viewRespondents');
    Route::get('/projects/set_flag_rules/{id}', 'Project\ProjectsController@setFlagRules');
    Route::get('/projects/get_item_budget', 'Project\ProjectsController@getItemBudget');
    Route::get('/projects/budget_integration/{id}', 'Project\ProjectsController@budgetIntegration');
    Route::patch('/projects/store_flag_rules', 'Project\ProjectsController@storeFlagRules');
    Route::patch('projects/set_budget_integration', 'Project\ProjectsController@setBudgetIntegration');
    Route::resource('projects', 'Project\ProjectsController');

    //Scan QR
    Route::get('/projects/scan_qr', 'Project\ProjectsController@scan_qr');

    //Project Activities
    Route::get('project_team_managements/{project}', 'Project\ProjectTeamManagementsController@index');
    Route::post('project_team_managements/ambilData', 'Project\ProjectTeamManagementsController@ambilData');
    Route::post('project_team_managements/ambilProvinsi', 'Project\ProjectTeamManagementsController@ambilProvinsi');
    Route::post('project_team_managements/tambah_honor', 'Project\ProjectTeamManagementsController@tambahHonor');
    Route::get('project_team_managements/hapus_honor/{id}', 'Project\ProjectTeamManagementsController@hapusHonor');
    Route::post('project_team_managements/tambah_honor_do', 'Project\ProjectTeamManagementsController@tambahHonorDo');
    Route::get('project_team_managements/hapus_honor_do/{id}', 'Project\ProjectTeamManagementsController@hapusHonorDo');
    Route::post('project_team_managements/denda_tl', 'Project\ProjectTeamManagementsController@dendaTl');
    Route::post('project_team_managements/tambah_honor_gift', 'Project\ProjectTeamManagementsController@tambahHonorGift');
    Route::get('project_team_managements/hapus_honor_gift/{id}', 'Project\ProjectTeamManagementsController@hapusHonorGift');
    Route::get('project_team_managements/leader/{teamId}/kota/{projectKotaId}', 'Project\ProjectTeamManagementsController@get_leader');
    // Route::get('project_plans/{project}','Project\ProjectPlansController@index');

    //Project Plan
    Route::get('project_plans', 'Project\ProjectPlansController@index');
    Route::get('project_plans/{project_plan}/edit', 'Project\ProjectPlansController@edit');
    Route::patch('project_plans/{project_plan}', 'Project\ProjectPlansController@update');
    Route::get('project_plans/delete/{project_plan}', 'Project\ProjectPlansController@delete');
    Route::post('project_plans/store', 'Project\ProjectPlansController@store');
    Route::get('project_plans/prepare_absensi/{project_plan}', 'Project\ProjectPlansController@prepare_absensi');
    Route::get('project_plans/index2', 'Project\ProjectPlansController@index2');
    Route::get('project_plans/create2', 'Project\ProjectPlansController@create2');
    Route::post('project_plans/store2', 'Project\ProjectPlansController@store2');
    Route::get('project_plans/delete2/{project_plan}', 'Project\ProjectPlansController@delete2');
    Route::get('project_plans/{project_plan}/edit2', 'Project\ProjectPlansController@edit2');
    Route::get('project_plans/print_qr/{project_plan}', 'Project\ProjectPlansController@print_qr');
    Route::get('project_plans/print_qr_respondent/{project_plan}', 'Project\ProjectPlansController@print_qr_respondent');

    Route::post('project_plans/update2/{project_plan}', 'Project\ProjectPlansController@update2');
    Route::resource('project_plans', 'Project\ProjectPlansController');
    Route::get('project_plans/schedule/{project_id}', 'Project\ProjectPlansController@schedule');
    Route::get('project_plans/schedule2/{project_id}', 'Project\ProjectPlansController@schedule2');
    Route::post('project_plans/simpanSchedule', 'Project\ProjectPlansController@simpanSchedule');
    Route::post('project_plans/simpanSchedule2', 'Project\ProjectPlansController@simpanSchedule2');
    Route::post('project_plans/tambah', 'Project\ProjectPlansController@tambah')->name('project_plans.tambah');
    Route::post('project_plans/tambah2', 'Project\ProjectPlansController@tambah2')->name('project_plans.tambah2');
    Route::post('project_plans/add_task', 'Project\ProjectPlansController@addTask');
    Route::get('project_plans/show_presence_audience/{project_plan_id}', 'Project\ProjectPlansController@show_presence_audience');
    Route::get('project_plans/show_presence_audience_respondent/{project_plan_id}', 'Project\ProjectPlansController@show_presence_audience_respondent');
    Route::get('project_plans/delete_audience/{id}', 'Project\ProjectPlansController@delete_audience');
    Route::post('project_plans/check_has_presence', 'Project\ProjectPlansController@checkHasPresence');

    //Project Kegiatan & absensi (of Plan)
    Route::get('/project_kegiatans/delete/{project_kegiatan}', 'Project\ProjectKegiatansController@delete');
    Route::resource('project_kegiatans', 'Project\ProjectKegiatansController');
    Route::get('/project_kegiatans/print_qr/{project_kegiatan}', 'Project\ProjectKegiatansController@print_qr');
    Route::get('/project_absensis/delete/{project_absensi}', 'Project\ProjectAbsensisController@delete');
    Route::get('/project_absensis/scanqr', 'Project\ProjectAbsensisController@scanqr');
    Route::post('/project_absensis/saveqr', 'Project\ProjectAbsensisController@saveqr');
    Route::get('/project_absensis/show_presence_audience/{project_plan_id}', 'Project\ProjectAbsensisController@show_presence_audience');

    Route::resource('project_absensis', 'Project\ProjectAbsensisController');

    //Project_kota
    Route::get('project_kotas/{project_id}', 'Project\ProjectKotasController@index');
    Route::get('project_kotas/create/{project_id}', 'Project\ProjectKotasController@create');
    Route::post('project_kotas', 'Project\ProjectKotasController@store');
    Route::get('project_kotas/{project_kota}/edit', 'Project\ProjectKotasController@edit');
    Route::patch('project_kotas/{project_kota}', 'Project\ProjectKotasController@update');
    Route::get('/project_kotas/delete/{project_kota}', 'Project\ProjectKotasController@delete');
    Route::post('project_kotas/editJumlah', 'Project\ProjectKotasController@editJumlah');

    //Project_jabatan
    Route::get('project_jabatans/{project_jabatan}', 'Project\ProjectJabatansController@index');
    Route::get('project_jabatans/create/{project_id}', 'Project\ProjectJabatansController@create');
    Route::post('project_jabatans', 'Project\ProjectJabatansController@store');
    Route::get('project_jabatans/{project_jabatan}/edit', 'Project\ProjectJabatansController@edit');
    Route::patch('project_jabatans/{project_jabatan}', 'Project\ProjectJabatansController@update');
    Route::get('/project_jabatans/delete/{project_jabatan}', 'Project\ProjectJabatansController@delete');

    //Project_team
    Route::get('project_teams/{project_team}', 'Project\ProjectTeamsController@index');
    Route::get('project_teams/create/{project_id}', 'Project\ProjectTeamsController@create');
    Route::post('project_teams', 'Project\ProjectTeamsController@store');
    Route::get('project_teams/{project_team}/edit', 'Project\ProjectTeamsController@edit');
    Route::patch('project_teams/{project_team}', 'Project\ProjectTeamsController@update');
    Route::get('/project_teams/delete/{project_team}', 'Project\ProjectTeamsController@delete');
    Route::get('/project_teams/kota/{kotaId}/leader/{teamLeaderId}/member', 'Project\ProjectTeamsController@member_team_leader');
    Route::post('project_teams/edit/leader/team/{id}', 'Project\ProjectTeamsController@update_team_leader');
    Route::get('project_teams/project-jabatan/{projectJabatanId}/teams', 'Project\ProjectTeamsController@get_teams');

    
    //Umum
    Route::get('/kotas/delete/{id}', 'Umum\KotasController@delete');
    Route::get('/kelurahans/delete/{id}', 'Umum\KelurahansController@delete');
    Route::resource('kotas', 'Umum\KotasController');
    Route::resource('kelurahans', 'Umum\KelurahansController');
    Route::get('/pekerjaans/delete/{id}', 'Umum\PekerjaansController@delete');
    Route::resource('pekerjaans', 'Umum\PekerjaansController');
    Route::get('/pendidikans/delete/{id}', 'Umum\PendidikansController@delete');
    Route::resource('pendidikans', 'Umum\PendidikansController');
    Route::get('/divisis/delete/{id}', 'Umum\DivisisController@delete');
    Route::get('/divisis/view/{id}', 'Umum\DivisisController@view');
    Route::resource('divisis', 'Umum\DivisisController');
    Route::get('/banks/delete/{id}', 'Umum\BanksController@delete');
    Route::get('/banks/view/{id}', 'Umum\BanksController@view');
    Route::resource('banks', 'Umum\BanksController');

    //Project Resources
    Route::get('/tasks/delete/{id}', 'ProjectResource\TasksController@delete');
    Route::resource('tasks', 'ProjectResource\TasksController');
    Route::get('/lokasis/delete/{id}', 'ProjectResource\LokasisController@delete');
    Route::resource('lokasis', 'ProjectResource\LokasisController');

    //Customer
    Route::get('/customers/delete/{id}', 'Customer\CustomersController@delete');
    Route::get('/customer_pics/delete/{id}', 'Customer\CustomerPicsController@delete');
    Route::resource('customers', 'Customer\CustomersController');
    Route::resource('customer_pics', 'Customer\CustomerPicsController');

    //Rekap Interviewer
    Route::post('/rekap_interviewer/change_status', 'Finance\RekapInterviewerController@changeStatus');
    Route::post('/rekap_interviewer/update_marking', 'Finance\RekapInterviewerController@updateMarking');
    Route::get('/rekap_interviewer/index_rtp', 'Finance\RekapInterviewerController@indexRtp');
    Route::get('/rekap_interviewer/marking/{id}', 'Finance\RekapInterviewerController@marking');
    Route::get('/rekap_interviewer/delete/{id}', 'Finance\RekapInterviewerController@delete');
    Route::get('/rekap_interviewer/view/{id}', 'Finance\RekapInterviewerController@view');
    Route::resource('rekap_interviewer', 'Finance\RekapInterviewerController');

    //Rekap TL
    Route::post('/rekap_tl/change_status', 'Finance\RekapTlController@changeStatus');
    Route::post('/rekap_tl/update_marking', 'Finance\RekapTlController@updateMarking');
    Route::get('/rekap_tl/index_rtp', 'Finance\RekapTlController@indexRtp');
    Route::get('/rekap_tl/marking/{id}/{jabatan_id}', 'Finance\RekapTlController@marking');
    Route::get('/rekap_tl/delete/{id}', 'Finance\RekapTlController@delete');
    Route::get('/rekap_tl/view/{id}', 'Finance\RekapTlController@view');
    Route::resource('rekap_tl', 'Finance\RekapTlController');

    //Respondent Gift
    Route::post('/respondent_gift/update_bpu', 'Finance\RespondentGiftController@updateBpu');
    Route::post('/respondent_gift/insert_bpu', 'Finance\RespondentGiftController@insertBpu');
    Route::get('/respondent_gift/get_data_void', 'Finance\RespondentGiftController@getDataVoid');
    Route::get('/respondent_gift/pengajuan_gift', 'Finance\RespondentGiftController@pengajuanGift');
    Route::get('/respondent_gift/rtp_gift', 'Finance\RespondentGiftController@rtpGift');
    Route::get('/respondent_gift/paid_gift', 'Finance\RespondentGiftController@paidGift');
    Route::post('/respondent_gift/change_status', 'Finance\RespondentGiftController@changeStatus');
    Route::resource('respondent_gift', 'Finance\RespondentGiftController');

    //Rekap Gift
    Route::resource('rekap_budget', 'Finance\RekapBudgetController');

    //Team
    Route::get('/bahasas/delete/{id}', 'Team\BahasasController@delete');
    Route::get('/jabatans/delete/{id}', 'Team\JabatansController@delete');
    Route::get('/teams/delete/{id}', 'Team\TeamsController@delete');
    Route::get('/teams/view/{project}', 'Team\TeamsController@view');
    Route::get('/keahlian/delete/{id}', 'Team\KeahlianController@delete');
    Route::resource('bahasas', 'Team\BahasasController');
    Route::resource('jabatans', 'Team\JabatansController');
    Route::resource('teams', 'Team\TeamsController');
    Route::resource('keahlian', 'Team\KeahlianController');
    Route::get('/vendors/delete/{id}', 'Team\VendorsController@delete');
    Route::get('/vendors/view/{id}', 'Team\VendorsController@view');
    Route::resource('vendors', 'Team\VendorsController');
    Route::get('/layanans/delete/{id}', 'Team\LayanansController@delete');
    Route::get('/layanans/view/{id}', 'Team\LayanansController@view');
    Route::resource('layanans', 'Team\LayanansController');

    //Team Bahasa
    Route::get('team_bahasas/{team_bahasa}', 'Team\TeamBahasasController@index');
    Route::get('team_bahasas/create/{team_id}', 'Team\TeamBahasasController@create');
    Route::post('team_bahasas', 'Team\TeamBahasasController@store');
    Route::get('team_bahasas/{team_bahasa}/edit', 'Team\TeamBahasasController@edit');
    Route::patch('team_bahasas/{team_bahasa}', 'Team\TeamBahasasController@update');
    Route::get('team_bahasas/delete/{team_bahasa}', 'Team\TeamBahasasController@delete');

    //Team Keahlian
    Route::get('team_keahlian/{team_keahlian}', 'Team\TeamKeahlianController@index');
    Route::get('team_keahlian/create/{team_id}', 'Team\TeamKeahlianController@create');
    Route::post('team_keahlian', 'Team\TeamKeahlianController@store');
    Route::get('team_keahlian/{team_keahlian}/edit', 'Team\TeamKeahlianController@edit');
    Route::patch('team_keahlian/{team_keahlian}', 'Team\TeamKeahlianController@update');
    Route::get('team_keahlian/delete/{team_keahlian}', 'Team\TeamKeahlianController@delete');

    //Vendor Layanan
    Route::get('vendor_layanan/{vendor_layanan}', 'Team\VendorLayanansController@index');
    Route::get('vendor_layanan/create/{vendor_id}', 'Team\VendorLayanansController@create');
    Route::post('vendor_layanan', 'Team\VendorLayanansController@store');
    Route::get('vendor_layanan/{vendor_layanan}/edit', 'Team\VendorLayanansController@edit');
    Route::patch('vendor_layanan/{vendor_layanan}', 'Team\VendorLayanansController@update');
    Route::get('vendor_layanan/delete/{vendor_layanan}', 'Team\VendorLayanansController@delete');

    //Bahasa Team
    Route::get('bahasa_teams/{bahasa_team}', 'Team\BahasaTeamsController@index');
    Route::get('bahasa_teams/create/{bahasa_id}', 'Team\BahasaTeamsController@create');
    Route::post('bahasa_teams', 'Team\BahasaTeamsController@store');
    Route::get('bahasa_teams/{bahasa_team}/edit', 'Team\BahasaTeamsController@edit');
    Route::patch('bahasa_teams/{bahasa_team}', 'Team\BahasaTeamsController@update');
    Route::get('bahasa_teams/delete/{team_bahasa}', 'Team\BahasaTeamsController@delete');

    //Team Jabatan
    Route::get('team_jabatans/{team_jabatan}', 'Team\TeamJabatansController@index');
    Route::get('team_jabatans/create/{team_id}', 'Team\TeamJabatansController@create');
    Route::post('team_jabatans', 'Team\TeamJabatansController@store');
    Route::get('team_jabatans/{team_jabatan}/edit', 'Team\TeamJabatansController@edit');
    Route::patch('team_jabatans/{team_jabatan}', 'Team\TeamJabatansController@update');
    Route::get('/team_jabatans/delete/{team_jabatan}', 'Team\TeamJabatansController@delete');

    //Jabatan Team
    Route::get('jabatan_teams/{jabatan_team}', 'Team\JabatanTeamsController@index');
    Route::get('jabatan_teams/create/{jabatan_id}', 'Team\JabatanTeamsController@create');
    Route::post('jabatan_teams', 'Team\JabatanTeamsController@store');
    Route::get('jabatan_teams/{jabatan_team}/edit', 'Team\JabatanTeamsController@edit');
    Route::patch('jabatan_teams/{jabatan_team}', 'Team\JabatanTeamsController@update');
    Route::get('/jabatan_teams/delete/{team_jabatan}', 'Team\JabatanTeamsController@delete');

    //Keahlian Team
    Route::get('keahlian_teams/{keahlian_team}', 'Team\KeahlianTeamsController@index');
    Route::get('keahlian_teams/create/{keahlian_id}', 'Team\KeahlianTeamsController@create');
    Route::post('keahlian_teams', 'Team\KeahlianTeamsController@store');
    Route::get('keahlian_teams/{keahlian_team}/edit', 'Team\KeahlianTeamsController@edit');
    Route::patch('keahlian_teams/{keahlian_team}', 'Team\KeahlianTeamsController@update');
    Route::get('/keahlian_teams/delete/{team_keahlian}', 'Team\KeahlianTeamsController@delete');

    //Layanan Vendor
    Route::get('layanan_vendors/{layanan_vendor}', 'Team\LayananVendorsController@index');
    Route::get('layanan_vendors/create/{layanan_id}', 'Team\LayananVendorsController@create');
    Route::post('layanan_vendors', 'Team\LayananVendorsController@store');
    Route::get('layanan_vendors/{layanan_vendor}/edit', 'Team\LayananVendorsController@edit');
    Route::patch('layanan_vendors/{layanan_vendor}', 'Team\LayananVendorsController@update');
    Route::get('/layanan_vendors/delete/{vendor_layanan}', 'Team\LayananVendorsController@delete');


    //Respondents
    Route::post('/respondents/change_status_perbaikan', 'Respondent\RespondentsController@changeStatusPerbaikan');
    Route::get('/respondents/delete/{id}', 'Respondent\RespondentsController@delete');
    Route::get('/import_excels/delete/{id}', 'Respondent\ImportExcelsController@delete');
    Route::get('/respondents/get_evaluasi', 'Respondent\RespondentsController@getEvaluasi');
    Route::post('/respondents/store_keterangan_rekaman', 'Respondent\RespondentsController@storeKeteranganRekaman');
    Route::post('/respondents/store_keterangan_callback', 'Respondent\RespondentsController@storeKeteranganCallback');
    Route::post('/respondents/store_keterangan_qc', 'Respondent\RespondentsController@storeKeteranganQc');
    Route::post('/respondents/store_evaluasi', 'Respondent\RespondentsController@storeEvaluasi');
    Route::get('/respondents/pick_respondent', 'Respondent\RespondentsController@pickRespondent');
    Route::get('/respondents/set_respondent/{id}', 'Respondent\RespondentsController@setRespondent');
    Route::resource('is_valids', 'Respondent\IsValidsController');
    Route::resource('sesAs', 'Respondent\SesAsController');
    Route::resource('sesBs', 'Respondent\SesBsController');
    Route::resource('sesFinals', 'Respondent\SesFinalsController');
    Route::resource('project_importeds', 'Respondent\ProjectImportedsController');
    Route::resource('respondents', 'Respondent\RespondentsController');
    Route::resource('import_excels', 'Respondent\ImportExcelsController');
    Route::resource('project_importeds', 'Respondent\ProjectImportedsController');

    //Form QC
    Route::post('/respondents/delete_tmp_respondent', 'Respondent\RespondentsController@deleteTmpRespondent');
    Route::post('/respondents/store_form_qc', 'Respondent\RespondentsController@storeFormQc');
    Route::get('/form_qc/get_data_update_qc', 'Respondent\DataQcsController@getDataUpdateQc');
    Route::get('/form_qc/view_uploaded_file/{id}', 'Respondent\DataQcsController@viewUploadedFile');
    Route::get('/form_qc/view/{file}', 'Respondent\DataQcsController@view');
    Route::get('/form_qc/delete/{id}', 'Respondent\DataQcsController@delete');
    Route::get('/form_qc/set_template_qc/{id}', 'Respondent\DataQcsController@setTemplateQc');
    Route::get('/form_qc/load_template_qc/{id}', 'Respondent\DataQcsController@loadTemplateQc');
    Route::post('/form_qc/store_template_qc/', 'Respondent\DataQcsController@storeTemplateQc');
    Route::get('/form_qc/delete_template_qc/{id}', 'Respondent\DataQcsController@deleteTemplateQc');
    Route::get('/form_qc/qc_respondent/{id}', 'Respondent\DataQcsController@qcRespondent');
    Route::post('/form_qc/store_qc_respondent/', 'Respondent\DataQcsController@storeRespondentQc');
    Route::post('/form_qc/set_callback/', 'Respondent\DataQcsController@storeCallback');
    Route::post('/form_qc/store_form_qc/', 'Respondent\DataQcsController@storeFormQc');
    Route::patch('/form_qc/upload', 'Respondent\DataQcsController@upload');
    Route::resource('form_qc', 'Respondent\DataQcsController');

    //Form Pengecekan
    Route::post('/respondents/store_form_pengecekan', 'Respondent\RespondentsController@storeFormQc');
    Route::get('/form_pengecekan/get_data_pengecekan', 'Respondent\DataQcsController@getDataPengecekan');
    Route::get('/form_pengecekan/view/{file}', 'Respondent\DataPengecekansController@view');
    Route::get('/form_pengecekan/delete/{id}', 'Respondent\DataPengecekansController@delete');
    Route::post('/form_pengecekan/set_on_notif', 'Respondent\DataPengecekansController@setOnNotif');
    Route::resource('form_pengecekan', 'Respondent\DataPengecekansController');



    //******************************************************/
    //**********  ----------- Produk -----------  **********
    //Ini ada 3 level : Kategori, Tipe, Nama
    //Tipe Produk tidak bisa pakai resource karena harus bawa $kategori_produk_id

    // ***** Kategori Produk
    Route::get('kategori_produks/delete/{id}', 'Produk\KategoriProduksController@delete');
    Route::resource('kategori_produks', 'Produk\KategoriProduksController');

    // ***** Tipe Produk
    Route::get('tipe_produks/delete/{id}', 'Produk\TipeProduksController@delete');
    Route::get('tipe_produks/{kategori_produk_id}', 'Produk\TipeProduksController@index');
    Route::get('tipe_produks/create/{kategori_produk_id}', 'Produk\TipeProduksController@create');
    Route::post('tipe_produks', 'Produk\TipeProduksController@store');
    Route::get('tipe_produks/{tipe_produk_id}/edit', 'Produk\TipeProduksController@edit');
    Route::patch('tipe_produks/{tipe_produk_id}', 'Produk\TipeProduksController@update');

    // ***** Nama Produk
    Route::get('nama_produks/delete/{id}', 'Produk\NamaProduksController@delete');
    Route::get('nama_produks/{tipe_produk_id}', 'Produk\NamaProduksController@index');
    Route::get('nama_produks/create/{tipe_produk_id}', 'Produk\NamaProduksController@create');
    Route::post('nama_produks', 'Produk\NamaProduksController@store');
    Route::get('nama_produks/{nama_produk_id}/edit', 'Produk\NamaProduksController@edit');
    Route::put('nama_produks/{nama_produk_id}', 'Produk\NamaProduksController@update');

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

Route::get('project_plans/fill_presence/{id}', 'Project\ProjectPlansController@fill_presence');
Route::get('project_plans/fill_presence_respondent/{id}', 'Project\ProjectPlansController@fill_presence_respondent');
Route::post('project_plans/store_presence', 'Project\ProjectPlansController@store_presence');
