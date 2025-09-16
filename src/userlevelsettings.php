<?php

namespace PHPMaker2025\pssk2025;

/**
 * User levels
 *
 * @var array<int, string, string>
 * [0] int User level ID
 * [1] string User level name
 * [2] string User level hierarchy
 */
$USER_LEVELS = [["-2","Anonymous",""],
    ["0","Default",""]];

/**
 * User roles
 *
 * @var array<int, string>
 * [0] int User level ID
 * [1] string User role name
 */
$USER_ROLES = [["-1","ROLE_ADMIN"],
    ["0","ROLE_DEFAULT"]];

/**
 * User level permissions
 *
 * @var array<string, int, int>
 * [0] string Project ID + Table name
 * [1] int User level ID
 * [2] int Permissions
 */
// Begin of modification by Masino Sinaga, September 17, 2023
$USER_LEVEL_PRIVS_1 = [["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}announcement","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}announcement","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}help","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}help","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}help_categories","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}help_categories","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}home.php","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}home.php","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}languages","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}languages","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}settings","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}settings","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}theuserprofile","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}theuserprofile","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}userlevelpermissions","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}userlevelpermissions","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}userlevels","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}userlevels","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}users","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}users","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}annex","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}annex","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}beasiswa","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}beasiswa","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}cuti_akademik","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}cuti_akademik","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}daftar matakuliah","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}daftar matakuliah","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}detil_mata_kuliah","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}detil_mata_kuliah","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}detil_semester_antara","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}detil_semester_antara","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}detil_ujian_tahap_bersama","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}detil_ujian_tahap_bersama","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}dosen","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}dosen","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}karya_ilmiah","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}karya_ilmiah","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}kemahasiswaan","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}kemahasiswaan","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}kesehatan_mahasiswa","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}kesehatan_mahasiswa","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}mahasiswa","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}mahasiswa","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}mata_kuliah","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}mata_kuliah","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}pembimbingan","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}pembimbingan","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}penyakit","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}penyakit","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}semester_antara","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}semester_antara","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}tahun_akademik","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}tahun_akademik","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}ujian_tahap_bersama","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}ujian_tahap_bersama","0","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}dashboard.php","-2","0"],
    ["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}dashboard.php","0","0"]];
$USER_LEVEL_PRIVS_2 = [["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}breadcrumblinksaddsp","-1","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}breadcrumblinkschecksp","-1","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}breadcrumblinksdeletesp","-1","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}breadcrumblinksmovesp","-1","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}loadhelponline","-2","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}loadaboutus","-2","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}loadtermsconditions","-2","8"],
					["{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}printtermsconditions","-2","8"]];
$USER_LEVEL_PRIVS = array_merge($USER_LEVEL_PRIVS_1, $USER_LEVEL_PRIVS_2);
// End of modification by Masino Sinaga, September 17, 2023

/**
 * Tables
 *
 * @var array<string, string, string, bool, string>
 * [0] string Table name
 * [1] string Table variable name
 * [2] string Table caption
 * [3] bool Allowed for update (for userpriv.php)
 * [4] string Project ID
 * [5] string URL (for OthersController::index)
 */
// Begin of modification by Masino Sinaga, September 17, 2023
$USER_LEVEL_TABLES_1 = [["announcement","announcement","Announcement",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","announcementlist"],
    ["help","help","Help (Details)",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","helplist"],
    ["help_categories","help_categories","Help (Categories)",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","helpcategorieslist"],
    ["home.php","home","Home",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","home"],
    ["languages","languages","Languages",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","languageslist"],
    ["settings","settings","Application Settings",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","settingslist"],
    ["theuserprofile","theuserprofile","User Profile",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","theuserprofilelist"],
    ["userlevelpermissions","userlevelpermissions","User Level Permissions",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","userlevelpermissionslist"],
    ["userlevels","userlevels","User Levels",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","userlevelslist"],
    ["users","users","Users",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","userslist"],
    ["annex","annex","annex",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","annexlist"],
    ["beasiswa","beasiswa","beasiswa",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","beasiswalist"],
    ["cuti_akademik","cuti_akademik","cuti akademik",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","cutiakademiklist"],
    ["daftar matakuliah","daftar_matakuliah","daftar matakuliah",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","daftarmatakuliahlist"],
    ["detil_mata_kuliah","detil_mata_kuliah","detil mata kuliah",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","detilmatakuliahlist"],
    ["detil_semester_antara","detil_semester_antara","detil semester antara",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","detilsemesterantaralist"],
    ["detil_ujian_tahap_bersama","detil_ujian_tahap_bersama","detil ujian tahap bersama",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","detilujiantahapbersamalist"],
    ["dosen","dosen","dosen",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","dosenlist"],
    ["karya_ilmiah","karya_ilmiah","karya ilmiah",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","karyailmiahlist"],
    ["kemahasiswaan","kemahasiswaan","kemahasiswaan",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","kemahasiswaanlist"],
    ["kesehatan_mahasiswa","kesehatan_mahasiswa","kesehatan mahasiswa",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","kesehatanmahasiswalist"],
    ["mahasiswa","mahasiswa","mahasiswa",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","mahasiswalist"],
    ["mata_kuliah","mata_kuliah","mata kuliah",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","matakuliahlist"],
    ["pembimbingan","pembimbingan","pembimbingan",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","pembimbinganlist"],
    ["penyakit","penyakit","penyakit",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","penyakitlist"],
    ["semester_antara","semester_antara","semester antara",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","semesterantaralist"],
    ["tahun_akademik","tahun_akademik","tahun akademik",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","tahunakademiklist"],
    ["ujian_tahap_bersama","ujian_tahap_bersama","ujian tahap bersama",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","ujiantahapbersamalist"],
    ["dashboard.php","dashboard2","Dashboard",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","dashboard2"]];
$USER_LEVEL_TABLES_2 = [["breadcrumblinksaddsp","breadcrumblinksaddsp","System - Breadcrumb Links - Add",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","breadcrumblinksaddsp"],
						["breadcrumblinkschecksp","breadcrumblinkschecksp","System - Breadcrumb Links - Check",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","breadcrumblinkschecksp"],
						["breadcrumblinksdeletesp","breadcrumblinksdeletesp","System - Breadcrumb Links - Delete",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","breadcrumblinksdeletesp"],
						["breadcrumblinksmovesp","breadcrumblinksmovesp","System - Breadcrumb Links - Move",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","breadcrumblinksmovesp"],
						["loadhelponline","loadhelponline","System - Load Help Online",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","loadhelponline"],
						["loadaboutus","loadaboutus","System - Load About Us",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","loadaboutus"],
						["loadtermsconditions","loadtermsconditions","System - Load Terms and Conditions",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","loadtermsconditions"],
						["printtermsconditions","printtermsconditions","System - Print Terms and Conditions",true,"{0043A1E5-239B-4C96-BCBF-CDBFE8DDD409}","printtermsconditions"]];
$USER_LEVEL_TABLES = array_merge($USER_LEVEL_TABLES_1, $USER_LEVEL_TABLES_2);
// End of modification by Masino Sinaga, September 17, 2023
