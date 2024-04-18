<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.π

use App\Models\ButirSoal;
use App\Models\Role;
use App\Models\Soal;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// User
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->push('User', route('user'));
});

// Permission
Breadcrumbs::for('permission', function (BreadcrumbTrail $trail) {
    $trail->push('Permission', route('permission'));
});

// Role
Breadcrumbs::for('role', function (BreadcrumbTrail $trail) {
    $trail->push('Role', route('role'));
});
Breadcrumbs::for('role.detail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('role');
    $trail->push(ucwords(Role::find($id)['name']), route('role.detail', $id));
});

// Sekolah
Breadcrumbs::for('sekolah', function (BreadcrumbTrail $trail) {
    $trail->push('Sekolah', route('sekolah'));
});

// Matapelajaran
Breadcrumbs::for('matapelajaran', function (BreadcrumbTrail $trail) {
    $trail->push('Matapelajaran', route('matapelajaran'));
});

//Soal
Breadcrumbs::for('soal', function (BreadcrumbTrail $trail) {
    $trail->push('Soal', route('soal'));
});
Breadcrumbs::for('soal.detail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('soal');
    $soal = Soal::find($id);
    $trail->push(ucwords($soal->kode_soal . ' - ' . $soal->nama), route('soal.detail', $id));
});
Breadcrumbs::for('soal.butirsoal.create', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('soal.detail', $id);
    $trail->push('Create', route('soal.butirsoal.create', $id));
});
Breadcrumbs::for('soal.butirsoal.edit', function (BreadcrumbTrail $trail, $id) {
    $butirsoal = ButirSoal::find($id);
    $trail->parent('soal.detail', $butirsoal->soal_id);
    $trail->push('Edit', route('soal.butirsoal.edit', $id));
});

//Siswa
Breadcrumbs::for('siswa', function (BreadcrumbTrail $trail) {
    $trail->push('Siswa', route('siswa'));
});

//Pengaturan Ujian
Breadcrumbs::for('pengaturan-ujian', function (BreadcrumbTrail $trail) {
    $trail->push('Pengaturan Ujian', route('pengaturan-ujian'));
});
//Ganti Password
Breadcrumbs::for('ganti-password', function (BreadcrumbTrail $trail) {
    $trail->push('Ganti Password', route('ganti-password'));
});
//Reset Ujian
Breadcrumbs::for('reset-ujian', function (BreadcrumbTrail $trail) {
    $trail->push('Reset Ujian', route('reset-ujian'));
});
//Rekap Nilai
Breadcrumbs::for('rekap-nilai', function (BreadcrumbTrail $trail) {
    $trail->push('Rekap Nilai', route('rekap-nilai'));
});
Breadcrumbs::for('rekap-nilai.kumulatif', function (BreadcrumbTrail $trail) {
    $trail->parent('rekap-nilai');
    $trail->push('Kumulatif', route('rekap-nilai.kumulatif'));
});
Breadcrumbs::for('rekap-nilai.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('rekap-nilai');
    $trail->push('Dashboard', route('rekap-nilai.dashboard'));
});
//Rekap Nilai Global
Breadcrumbs::for('rekap-nilai-global', function (BreadcrumbTrail $trail) {
    $trail->push('Rekap Nilai Global', route('rekap-nilai-global'));
});
Breadcrumbs::for('rekap-nilai-global.kumulatif', function (BreadcrumbTrail $trail) {
    $trail->parent('rekap-nilai-global');
    $trail->push('Kumulatif', route('rekap-nilai-global.kumulatif'));
});
Breadcrumbs::for('rekap-nilai-global.dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('rekap-nilai-global');
    $trail->push('Dashboard', route('rekap-nilai-global.dashboard'));
});
Breadcrumbs::for('kirim-nilai', function (BreadcrumbTrail $trail) {
    $trail->push('Kirim Nilai', route('kirim-nilai'));
});
Breadcrumbs::for('kirim-nilai.checkSyncData', function (BreadcrumbTrail $trail) {
    $trail->parent('kirim-nilai');
    $trail->push('Check Sinkronisasi Data', route('kirim-nilai.checkSyncData'));
});
Breadcrumbs::for('import-nilai', function (BreadcrumbTrail $trail) {
    $trail->push('Import Nilai', route('import-nilai'));
});
// Auth::siswa
Breadcrumbs::for('home.siswa', function (BreadcrumbTrail $trail) {
    // $trail->push('Home', route('home.siswa'));
});
//Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('profile'));
});
//Cat
Breadcrumbs::for('cat', function (BreadcrumbTrail $trail) {
    $trail->push('Computer Assisted Test', route('cat'));
});
Breadcrumbs::for('cat.mulai', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('cat');
    $trail->push('Mulai', route('cat.mulai', $id));
});
Breadcrumbs::for('cat.nilai', function (BreadcrumbTrail $trail) {
    $trail->parent('cat');
    $trail->push('Nilai', route('cat.nilai'));
});


// // Home > Blog
// Breadcrumbs::for('blog', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category));
// });
