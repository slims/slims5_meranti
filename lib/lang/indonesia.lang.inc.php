<?php
/* Arie Nugraha - 2008
Hendro Wicaksono - 2008
Wardiyono - 2008 */
/* INDONESIA language */

/* COMMON */
define('lang_sys_common_data_not_exists', 'ERROR! Data tidak ditemukan!');
define('lang_sys_common_unauthorized', 'Anda tidak memiliki wewenang untuk masuk ke bagian ini!');
define('lang_sys_common_no_privilege', 'Anda tidak memiliki hak untuk mengakses ke bagian ini');
define('lang_sys_common_timeout', 'Sesi login anda telah habis. Harap lakukan login kembali');
define('lang_sys_common_welcome', 'Selamat datang di automasi perpustakaan, saat ini anda login sebagai ');
define('lang_sys_common_overdue', 'Terdapat <strong>{num_overdue}</strong> anggota perpustakaan terlambat mengembalikan koleksi. Cek modul <b>Sirkulasi</b> pada bagian <b>Keterlambatan</b> untuk lebih detil');
define('lang_sys_common_gd_not_loaded', 'Extension <strong>PHP GD</strong> belum terinstall. Pastikan PHP GD terinstall atau aplikasi tidak dapat membuat thumbnail image dan membuat barcode');
define('lang_sys_common_gd_freetype_not_loaded', 'Dukungan <strong>Freetype</strong> pada PHP GD belum ada. Bangun atau install ulang PHP GD dengan dukungan Freetype atau aplikasi tidak dapat membuat barcode.');
define('lang_sys_common_imagedir_unwritable', 'Direktori <strong>Images</strong> dan direktori-direktori di bawahnya tidak dapat ditulis. Pastikan direktori-direktori ini bisa ditulis atau aplikasi tidak dapat mengunggah gambar dan membuat barcode.');
define('lang_sys_common_uploaddir_unwritable', 'Direktori <strong>Upload File</strong> dan direktori-direktori di bawahnya tidak dapat ditulis. Pastikan direktori-direktori ini bisa ditulis atau aplikasi tidak bisa mengunggah file, membuat report dan backup.');
define('lang_sys_common_repodir_unwritable', 'Direktori <strong>Repository</strong> dan direktori-direktori di bawahnya tidak dapat ditulis. Pastikan direktori-direktori ini bisa ditulis atau aplikasi tidak bisa mengunggah file attachment untuk data bibliografi.');
define('lang_sys_common_dompdfdir_unwritable', 'Direktori <strong>{dompdf_libdir}</strong> tidak dapat ditulis. Pastikan direktori ini bisa ditulis atau aplikasi tidak dapat membuat file PDF.');
define('lang_sys_common_mysqldump_not_found', 'Letak program <strong>mysqldump</strong> tidak ditemukan! Periksa kembali file konfigurasi aplikasi atau anda tidak dapat melakukan backup.');
define('lang_sys_common_tools', 'Peralatan');
define('lang_sys_common_confirm_delete_selected', 'Anda Yakin Akan MENGHAPUS Data Terpilih?');
define('lang_sys_common_button_delete_selected', 'Hapus Data Terpilih');
define('lang_sys_common_holiday_set_error', 'Maksimum 6 hari bisa di-set sebagai hari libur!');
define('lang_sys_common_language_select', 'Select Language');
define('lang_sys_common_no_privilage', 'Anda tidak punya hak akses ke bagian ini!');
define('lang_sys_common_year', 'Tahun');
define('lang_sys_common_month', 'Bulan');
define('lang_sys_common_date', 'Tanggal');
# template
define('lang_template_topmenu_1','Beranda depan');
define('lang_template_topmenu_2','Info Perpustakaan');
define('lang_template_topmenu_3','Bantuan pencarian');
define('lang_template_topmenu_4','LOGIN Pustakawan');
define('lang_template_simple_search','Pencarian Sederhana');
define('lang_template_adv_search','Pencarian Spesifik');
# login and logout
define('lang_sys_login_javastatus','Browser anda tidak mendukung Javascript atau Javascript tidak diaktifkan. Aplikasi tidak dapat dijalankan tanpa Javascript!');
define('lang_sys_login_alert', 'Lengkapi username dan password dengan benar');
define('lang_sys_login_alert_ok', 'Selamat datang di automasi perpustakaan, ');
define('lang_sys_login_alert_fail', 'Username atau Password salah. ANDA TIDAK BERHAK MELANJUTKAN');
define('lang_sys_logout_alert', 'Anda telah keluar dari sistem automasi perpustakaan');
# system module submenu
define('lang_sys_mod', 'Sistem');
define('lang_sys_configuration', 'Konfigurasi Sistem');
define('lang_sys_configuration_titletag', 'Konfigurasi Global Aplikasi');
define('lang_sys_configuration_description', 'Mengatur konfigurasi global aplikasi sesuai kebutuhan');
define('lang_sys_modules', 'Modul');
define('lang_sys_modules_titletag', 'Konfigurasi Modul Aplikasi');
define('lang_sys_modules_new_add', 'Data Modul Baru');
define('lang_sys_modules_list', 'Daftar Modul');
define('lang_sys_user', 'Pengguna Aplikasi');
define('lang_sys_user_titletag', 'Pengelolaan Data Pengguna Aplikasi/Staf Perpustakaan');
define('lang_sys_user_new_add', 'Data Staf Baru');
define('lang_sys_user_list', 'Daftar Staf');
define('lang_sys_group', 'Kelompok Pengguna');
define('lang_sys_group_titletag', 'Pengelolaan Data Kelompok Pengguna Aplikasi');
define('lang_sys_group_new_add', 'Data Kelompok Baru');
define('lang_sys_group_list', 'Daftar Kelompok');
define('lang_sys_holiday', 'Hari Libur');
define('lang_sys_holiday_titletag', 'Konfigurasi Hari Libur');
define('lang_sys_barcodes', 'Pembuat Barcode');
define('lang_sys_barcodes_titletag', 'Pembuat Barcode');
define('lang_sys_barcodes_description', 'Ketik teks Barcode dalam kotak di bawah ini dan klik');
define('lang_sys_syslog', 'Log Sistem');
define('lang_sys_syslog_titletag', 'Lihat Sistem Log Aplikasi');
define('lang_sys_backup', 'Salinan Pangkalan Data');
define('lang_sys_backup_titletag', 'Membuat Salinan Pangkalan Data Aplikasi');
define('lang_sys_backup_new_add', 'Mulai Salinan Baru');
define('lang_sys_content', 'Konten');
define('lang_sys_content_titletag', 'Manajemen Konten');
# form
define('lang_sys_common_form_save', 'Simpan');
define('lang_sys_common_form_update', 'Perbaharui');
define('lang_sys_common_form_cancel', 'Batal');
define('lang_sys_common_form_delete', 'Hapus Rekod');
define('lang_sys_common_form_search', 'Pencarian'); /* proposed */
define('lang_sys_common_form_search_field', 'Pencarian'); /* proposed */
define('lang_sys_common_form_save_change', 'Simpan'); /* proposed */
define('lang_sys_common_form_report','Unduh Laporan');
# datagrid form
define('lang_sys_common_form_checkbox_all', 'Cek Semua');
define('lang_sys_common_form_uncheckbox_all', 'Hilangkan Cek');
define('lang_sys_common_form_delete_selected', 'Hapus Data Terpilih');
define('lang_sys_common_form_confirm_delete', 'Apakah anda yakin akan menghapus data-data terpilih?');
define('lang_sys_common_edit_titletag', 'Klik disini untuk detail atau perbaharuan rekod terkait');
# display search data
define('lang_sys_common_search_result_info', 'Ditemukan  <strong>{result->num_rows}</strong> dari pencarian anda melalui kata kunci');
define('lang_sys_common_paging_first', 'Hal. Pertama');
define('lang_sys_common_paging_last', 'Hal. Akhir');
define('lang_sys_common_paging_prev', 'Sebelumnya');
define('lang_sys_common_paging_next', 'Berikutnya');
# application user form
define('lang_sys_user_field_login_username', 'Nama Untuk Login');
define('lang_sys_user_field_realname', 'Nama Sebenarnya');
define('lang_sys_user_field_password', 'Sandi Login');
define('lang_sys_user_field_password_confirm', 'Konfirmasi Sandi Login');
# content form
define('lang_sys_content_field_title', 'Judul Konten');
define('lang_sys_content_field_path', 'Path (Harus unik)');
define('lang_sys_content_field_desc', 'Deskripsi Konten');
define('lang_sys_content_new_add', 'Add New Content');
define('lang_sys_content_list', 'Content List');
define('lang_sys_content_alert_noempty', 'Judul atau Path tidak boleh dikosongkan!');
define('lang_sys_content_common_last_update', 'Konten terakhir di-update ');
define('lang_sys_content_common_edit_info', 'Anda akan mengubah data konten ');
define('lang_sys_content_alert_save_ok', 'Data Konten berhasil disimpan');
define('lang_sys_content_alert_save_fail', 'Data Konten GAGAL disimpan!');
define('lang_sys_content_alert_update_ok', 'Data Konten berhasil diupdate');
define('lang_sys_content_alert_update_fail', 'Data Konten GAGAL diupdate!');

/* Global Configuration */
define('lang_sys_conf_alert_save', 'Konfigurasi telah disimpan. Perbaharui informasi terbaru');
define('lang_sys_conf_form_button_save', 'Simpan konfigurasi');
define('lang_sys_conf_form_field_library', 'Nama Perpustakaan');
define('lang_sys_conf_form_field_library_subname', 'Nama Perpustakaan Tambahan');
define('lang_sys_conf_form_field_public_template', 'Template publik');
define('lang_sys_conf_form_field_admin_template', 'Template administrasi');
define('lang_sys_conf_form_field_language', 'Bahasa pengantar');
define('lang_sys_conf_form_field_opac_result', 'Jumlah koleksi yang ditampilkan hasil pencarian OPAC');
define('lang_sys_conf_form_field_quick_return', 'Pengembalian Kilat');
define('lang_sys_conf_form_field_limit_overide', 'Mengabaikan batas pinjam');
define('lang_sys_conf_form_field_opac_xml', 'Detail OPAC XML');
define('lang_sys_conf_form_field_xml_result', 'Hasil OPAC dalam XML');
define('lang_sys_conf_form_field_xml_file', 'Unduh file hasil pencarian OPAC');
define('lang_sys_conf_form_option_enable', 'Dimungkinkan');
define('lang_sys_conf_form_option_disable', 'Tidak mungkin');
define('lang_sys_conf_form_option_allow', 'Diijinkan');
define('lang_sys_conf_form_option_forbid', 'Dilarang');
define('lang_sys_conf_form_field_session', 'Timeout Sesi Login');
define('lang_sys_conf_form_field_promote_titles', 'Tampilkan Judul Terpilih di Homepage');

/* Module Configuration */
define('lang_sys_conf_module_alert_noempty', 'Nama dan path tidak boleh kosong');
define('lang_sys_conf_module_alert_save_ok', 'Data Modul Baru Berhasil Disimpan');
define('lang_sys_conf_module_alert_save_fail', 'Data Modul GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_module_alert_update_ok', 'Data Modul Berhasil Diperbaharui');
define('lang_sys_conf_module_alert_update_fail', 'Data Modul GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_module_alert_not_exist', 'Error! Data Modul tidak ditemukan!');
define('lang_sys_conf_module_common_edit_info', 'Anda akan meng-edit data modul');
define('lang_sys_conf_module_common_alert_delete_success', 'Semua Data Berhasil Dihapus');
define('lang_sys_conf_module_common_alert_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_module_common_alert_delete_group_ok', 'Kelompok pengguna berhasil dihapus');
define('lang_sys_conf_module_common_alert_delete_group_fail', 'Kelompok pengguna GAGAL dihapus');
define('lang_sys_conf_module_field_name', 'Nama Modul');
define('lang_sys_conf_module_field_path', 'Modul Path');
define('lang_sys_conf_module_field_description', 'Deskripsi Modul');

/* User Configuration */
define('lang_sys_conf_user_alert_noempty', 'Nama Lengkap dan Nama Login tidak boleh kosong');
define('lang_sys_conf_user_alert_forbid', 'Login Pengguna atau Nama Lengkap tidak bisa digunakan!');
define('lang_sys_conf_user_alert_nopassword', 'Password tidak boleh kosong!');
define('lang_sys_conf_user_alert_nomatch', 'Password dan Konfirmasinya tidak cocok. Pastikan penggunaan huruf besar dan kecil yang sesuai!');
define('lang_sys_conf_user_alert_save_ok', 'Pengguna Baru Berhasil Disimpan');
define('lang_sys_conf_user_alert_save_fail', 'Data Pengguna Baru GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_user_alert_update_ok', 'Data Pengguna Berhasil Diperbaharui');
define('lang_sys_conf_user_alert_update_fail', 'Data Pengguna GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_user_alert_not_exist', 'Error! Data Pengguna tidak ditemukan!');
define('lang_sys_conf_user_common_edit_info', 'Anda akan meng-edit data pengguna');
define('lang_sys_conf_user_common_last_update', 'Terakhir diperbaharui ');
define('lang_sys_conf_user_common_info_1', 'Biarkan kotak Password kosong jika tidak ingin mengubahnya');
define('lang_sys_conf_user_common_alert_delete_success', 'Semua Data Berhasil Dihapus');
define('lang_sys_conf_user_common_alert_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_user_common_alert_delete_record_ok', 'Rekod Pengguna berhasil dihapus');
define('lang_sys_conf_user_common_alert_delete_record_fail', 'Rekod Pengguna GAGAL dihapus');
define('lang_sys_conf_user_field_login_name', 'Login Pengguna');
define('lang_sys_conf_user_field_real', 'Nama Pengguna');
define('lang_sys_conf_user_field_group', 'Kelompok');
define('lang_sys_conf_user_field_password_1', 'Password');
define('lang_sys_conf_user_field_password_2', 'Konfirmasi Password');
define('lang_sys_conf_user_field_password_3', 'Password Baru');
define('lang_sys_conf_user_field_password_4', 'Konfirmasi Password Baru');
define('lang_sys_conf_user_field_last_login', 'Login terakhir');

/* Group Configuration */
define('lang_sys_conf_group_alert_noempty', 'Nama Kelompok tidak boleh kosong');
define('lang_sys_conf_group_alert_save_ok', 'Kelompok Baru Berhasil Disimpan');
define('lang_sys_conf_group_alert_save_fail', 'Data Kelompok GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_group_alert_update_ok', 'Data Kelompok Berhasil Diperbaharui');
define('lang_sys_conf_group_alert_update_fail', 'Data Kelompok GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_group_alert_not_exist', 'Error! Data Kelompok tidak ditemukan!');
define('lang_sys_conf_group_common_edit_info', 'Anda akan meng-edit data kelompok');
define('lang_sys_conf_group_common_last_update', 'Terakhir diperbaharui ');
define('lang_sys_conf_group_common_alert_delete_success', 'Semua Data Berhasil Dihapus');
define('lang_sys_conf_group_common_alert_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_group_common_alert_delete_record_ok', 'Rekod Kelompok berhasil dihapus');
define('lang_sys_conf_group_common_alert_delete_record_fail', 'Rekod Kelompok GAGAL dihapus');
define('lang_sys_conf_group_field_name', 'Nama Kelompok');
define('lang_sys_conf_group_field_privileges', 'Hak Istimewa');
define('lang_sys_conf_group_privileges_modul_name', 'Nama Modul');
define('lang_sys_conf_group_privileges_modul_read', 'Baca');
define('lang_sys_conf_group_privileges_modul_write', 'Ubah');

/* Holiday Configuration */
define('lang_sys_holiday_set_day', 'Hari Libur');
define('lang_sys_holiday_add_day', 'Tambah Hari Libur Khusus Baru');
define('lang_sys_holiday_list', 'Daftar Libur Khusus');
define('lang_sys_conf_holiday_alert_noempty', 'Deskripi hari libur tidak boleh kosong');
define('lang_sys_conf_holiday_alert_save_ok', 'Libur Khusus Baru Berhasil Disimpan');
define('lang_sys_conf_holiday_alert_save_fail', 'Libur Khusus Baru GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_holiday_alert_update_ok', 'Libur Khusus Berhasil Diperbaharui');
define('lang_sys_conf_holiday_alert_update_fail', 'Libur Khusus GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_holiday_alert_not_exist', 'Error! Hari libur tidak ditemukan!');
define('lang_sys_conf_holiday_alert_set_ok', 'Set hari libur berhasil disimpan');
define('lang_sys_conf_holiday_common_edit_info', 'Anda akan meng-edit hari libur');
define('lang_sys_conf_holiday_common_alert_delete_success', 'Semua Data Berhasil Dihapus');
define('lang_sys_conf_holiday_common_alert_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_sys_conf_holiday_common_alert_delete_record_ok', 'Hari libur berhasil dihapus');
define('lang_sys_conf_holiday_common_alert_delete_record_fail', 'Hari libur GAGAL dihapus');
define('lang_sys_conf_holiday_form_save', 'Set Hari Libur');
define('lang_sys_conf_holiday_field_date_day', 'Tanggal Libur');
define('lang_sys_conf_holiday_field_date_day_end', 'Tanggal Libur Akhir');
define('lang_sys_conf_holiday_field_description', 'Keterangan');
define('lang_sys_conf_holiday_field_day_name', 'Hari');
define('lang_sys_conf_holiday_field_day_1', 'Senin');
define('lang_sys_conf_holiday_field_day_2', 'Selasa');
define('lang_sys_conf_holiday_field_day_3', 'Rabu');
define('lang_sys_conf_holiday_field_day_4', 'Kamis');
define('lang_sys_conf_holiday_field_day_5', 'Jumat');
define('lang_sys_conf_holiday_field_day_6', 'Sabtu');
define('lang_sys_conf_holiday_field_day_7', 'Minggu');

/* Barcode Generator */
define('lang_sys_conf_barcode_alert_print_fail', 'GAGAL mencetak Barcode!');
define('lang_sys_conf_barcode_alert_print_ok', 'Pencetakan Barcode selesai');
define('lang_sys_conf_barcode_button_print', 'Cetak Barcode');
define('lang_sys_conf_barcode_field_size', 'Ukuran Barcode');
define('lang_sys_conf_barcode_field_option_1', 'Kecil');
define('lang_sys_conf_barcode_field_option_2', 'Sedang');
define('lang_sys_conf_barcode_field_option_3', 'Besar');

/* Log System */
define('lang_sys_conf_log_field_time', 'Waktu');
define('lang_sys_conf_log_field_location', 'Lokasi');
define('lang_sys_conf_log_field_message', 'Catatan Pesan');

/* OPAC */
define('lang_opac_search_result', 'Hasil Pencarian');
define('lang_opac_info', 'Web Online Public Access Catalog - Gunakan fasilitas pencarian untuk mempercepat anda menemukan data katalog');
define('lang_opac_rec_detail', 'Detail Rekod');
define('lang_opac_page_info', 'Saat ini anda berada pada halaman <strong>{page}</strong> dari total <strong>{total_pages}</strong> halaman');
define('lang_opac_search_result_info', 'Ditemukan  <strong>{biblio_list->num_rows}</strong> dari pencarian anda melalui kata kunci');
define('lang_opac_back_prev', 'Kembali ke sebelumnya');

/* DEFAULT MODULE */
define('lang_mod_default_home_panel', 'Panel');
define('lang_mod_default_home_user_profile', 'Ubah Profil User');
define('lang_mod_default_home_user_profile_titletag', 'Ubah Profil dan Password User Aktif');

/* BIBLIOGRAPHIC MODULE */
# submenu
define('lang_mod_biblio', 'Katalog');
define('lang_mod_biblio_list', 'Daftar Katalog');
define('lang_mod_biblio_list_titletag', 'Daftar Data Katalog');
define('lang_mod_biblio_add', 'Tambah Katalog Baru');
define('lang_mod_biblio_add_titletag', 'Menambahkan Data Katalog Baru');
define('lang_mod_biblio_item', 'Koleksi');
define('lang_mod_biblio_item_list', 'Daftar Koleksi');
define('lang_mod_biblio_item_list_titletag', 'Daftar Koleksi Perpustakaan');
define('lang_mod_biblio_item_checkout', 'Daftar Koleksi Keluar');
define('lang_mod_biblio_item_checkout_titletag', 'Daftar Koleksi Perpustakaan Yang Sedang Dipinjam');
define('lang_mod_biblio_tools', 'Peralatan');
define('lang_mod_biblio_tools_z3950', 'Layanan Z3950');
define('lang_mod_biblio_tools_z3950_titletag', 'Ambil Data Bibliografi/Katalog dari layanan Z3950');
define('lang_mod_biblio_tools_label_print', 'Pencetakan Label');
define('lang_mod_biblio_tools_label_print_titletag', 'Pencetakan Label Dokumen');
define('lang_mod_biblio_tools_label_print_select', 'Cetak Data Terpilih');
define('lang_mod_biblio_tools_label_print_clear', 'Batalkan Antrian Pencetakan');
define('lang_mod_biblio_tools_item_barcode', 'Cetak Barcode Koleksi');
define('lang_mod_biblio_tools_item_barcode_titletag', 'Cetak Barcode Koleksi');
define('lang_mod_biblio_tools_item_barcode_print_select', 'Cetak Data Terpilih');
define('lang_mod_biblio_tools_item_barcode_clear', 'Batalkan Antrian Pencetakan');
define('lang_mod_biblio_tools_export', 'Ekspor Data');
define('lang_mod_biblio_tools_export_titletag', 'Ekspor Data Bibliografi ke Format CSV');
define('lang_mod_biblio_tools_import', 'Impor Data');
define('lang_mod_biblio_tools_import_titletag', 'Impor Data Bibliografi dari file CSV');
# bibliography form fields
define('lang_mod_biblio_field_title', 'Judul');
define('lang_mod_biblio_field_edition', 'Edisi');
define('lang_mod_biblio_field_specific_detail', 'Detil Spesifik');
define('lang_mod_biblio_field_items', 'Data Koleksi');
define('lang_mod_biblio_field_no_item', 'Tidak ada item untuk judul ini');
define('lang_mod_biblio_link_item_add', 'Tambah Data Koleksi');
define('lang_mod_biblio_field_authors', 'Pengarang');
define('lang_mod_biblio_link_author_add', 'Tambah Data Pengarang');
define('lang_mod_biblio_link_author_search', 'Klik disini untuk mencari dokumen lain dari pengarang ini');
define('lang_mod_biblio_field_gmd', 'Bentuk Media');
define('lang_mod_biblio_field_isbn', 'ISBN/ISSN');
define('lang_mod_biblio_field_class', 'Klasifikasi');
define('lang_mod_biblio_field_publisher', 'Penerbit');
define('lang_mod_biblio_field_no_publisher', 'Belum ada penerbit');
define('lang_mod_biblio_field_publish_year', 'Tahun Terbit');
define('lang_mod_biblio_field_publish_place', 'Tempat Terbit');
define('lang_mod_biblio_field_no_publish_place', 'Belum ada tempat terbit');
define('lang_mod_biblio_field_collation', 'Kolasi');
define('lang_mod_biblio_field_series', 'Judul Seri');
define('lang_mod_biblio_field_call_number', 'No. Panggil');
define('lang_mod_biblio_field_topic', 'Subyek/Subjek');
define('lang_mod_biblio_link_topic_add', 'Tambah Data Subyek/Subjek');
define('lang_mod_biblio_link_topic_search', 'Klik disini untuk mencari dokumen lain dengan subjek ini');
define('lang_mod_biblio_field_lang', 'Bahasa');
define('lang_mod_biblio_field_notes', 'Catatan');
define('lang_mod_biblio_field_image', 'Gambar Sampul');
define('lang_mod_biblio_field_image_nothing', 'Tidak ada gambar sampul');
define('lang_mod_biblio_field_attachment', 'Lampiran');
define('lang_mod_biblio_field_attachment_nothing', 'Tidak Ada Berkas Terlampir');
define('lang_mod_biblio_field_availability', 'Ketersediaan');
define('lang_mod_biblio_field_hide_opac', 'Tidak ditampilkan di OPAC');
define('lang_mod_biblio_field_promote', 'Promosikan Ke Beranda');
# bibliography common
define('lang_mod_biblio_common_form_print_queue', 'Tambahkan Dalam Antrian');
define('lang_mod_biblio_common_print_queue_confirm', 'Cetak dalam antrian pencetakan?');
define('lang_mod_biblio_common_print_cleared', 'Antrian pencetakan dihapus!');
define('lang_mod_biblio_common_print_no_data', 'Tidak ada data untuk dicetak!');
define('lang_mod_biblio_common_print_no_add_queue', 'Item terpilih TIDAK TERMASUK dalam antrian cetak. Hanya {max_print} dapat dicetak sekaligus');
define('lang_mod_biblio_alert_print_add_ok', 'Item terpilih ditambahkan dalam antrian pencetakan');
define('lang_mod_biblio_alert_title_empty', 'Judul harus diisi');
define('lang_mod_biblio_alert_failed_to_save', 'Data bibliografi GAGAL disimpan. Hubungi System Administrator untuk pemecahan');
define('lang_mod_biblio_alert_failed_to_update', 'Data bibliografi GAGAL diperbaharui. Hubungi System Administrator untuk pemecahan');
define('lang_mod_biblio_alert_new_added', 'Data baru bibliografi berhasil disimpan');
define('lang_mod_biblio_alert_updated_ok', 'Data bibliografi berhasil diperbaharui');
define('lang_mod_biblio_alert_image_uploaded', 'Citra/Berkas Gambar Berhasil Diunggah');
define('lang_mod_biblio_alert_image_not_uploaded', 'Citra/Berkas Gambar GAGAL Diunggah');
define('lang_mod_biblio_alert_attach_uploaded', 'Lampiran Berkas Berhasil Diunggah');
define('lang_mod_biblio_alert_attach_not_uploaded', 'Lampiran Berkas GAGAL Diunggah');
define('lang_mod_biblio_common_not_exists','ERROR! Data terpilih tidak ditemukan');
define('lang_mod_biblio_common_edit_message', 'Anda akan mengubah data biblio');
define('lang_mod_biblio_common_last_update', 'Perubahan terakhir ');
define('lang_mod_biblio_alert_list_not_deleted', 'Daftar data berikut tidak bisa dihapus : ');
define('lang_mod_biblio_alert_data_selected_deleted', 'Seluruh Data Berhasil Dihapus');
define('lang_mod_biblio_alert_data_selected_not_deleted', 'Sebagian Atau Seluruh Data GAGAL Dihapus!\nHubungi System Administrator untuk pemecahan');
define('lang_mod_biblio_alert_data_have_item', 'Judul ini tidak bisa dihapus karena masih memiliki {biblio_item} item. Hapus item terlebih dahulu');
define('lang_mod_biblio_alert_data_deleted', 'Cantuman Berhasil Dihapus');
define('lang_mod_biblio_alert_data_not_deleted', 'Cantuman GAGAL dihapus');
# item form fields
define('lang_mod_biblio_item_field_title', 'Judul');
define('lang_mod_biblio_item_field_itemcode', 'Kode');
define('lang_mod_biblio_item_field_inventory', 'Kode Inventaris');
define('lang_mod_biblio_item_field_location', 'Lokasi');
define('lang_mod_biblio_item_field_site', 'Lokasi Rak');
define('lang_mod_biblio_item_field_ctype', 'Tipe Koleksi');
define('lang_mod_biblio_item_field_item_status', 'Status Koleksi');
define('lang_mod_biblio_item_field_order_number', 'No. Pemesanan');
define('lang_mod_biblio_item_field_order_date', 'Tanggal Pemesanan');
define('lang_mod_biblio_item_field_received_date', 'Tanggal Penerimaan');
define('lang_mod_biblio_item_field_supplier', 'Penyedia');
define('lang_mod_biblio_item_field_item_source', 'Sumber Perolehan');
define('lang_mod_biblio_item_field_invoice', 'Faktur');
define('lang_mod_biblio_item_field_invoice_date', 'Tanggal Faktur');
define('lang_mod_biblio_item_field_price', 'Harga');
# item
define('lang_mod_biblio_item_common_opac_status_1', 'Perpustakaan memiliki {copy} kopi dan SELURUHNYA sedang dipinjamkan');
define('lang_mod_biblio_item_common_opac_status_2', 'Perpustakaan memiliki {copy} kopi dari judul ini');
define('lang_mod_biblio_item_common_opac_status_3', 'bisa dipinjam');
define('lang_mod_biblio_item_common_opac_status_4', 'sedang dipinjam');
define('lang_mod_biblio_item_common_location_status_1', 'kopi terdapat di');
define('lang_mod_biblio_item_alert_collection_title', 'Judul koleksi harus dilengkapi!');
define('lang_mod_biblio_item_alert_item_code', 'Kode Item tidak boleh kosong!');
define('lang_mod_biblio_item_alert_new_saved', 'Data Item baru berhasil disimpan');
define('lang_mod_biblio_item_alert_updated','Data Item berhasil diperbaharui');
define('lang_mod_biblio_item_alert_not_saved', 'Data Item GAGAL disimpan. Mohon hubungi System Administrator');
define('lang_mod_biblio_item_alert_delete_fail_on_loan', 'Data Item tidak bisa dihapus karena masih dipinjam anggota');
define('lang_mod_biblio_item_alert_delete_item_data_success', 'Seluruh data terkait berhasil dihapus');
define('lang_mod_biblio_item_alert_delete_item_data_failed', 'Hanya SEBAGIAN atau GAGAL menghapus data terkait!\nMohon hubungi System Administrator');
define('lang_mod_biblio_item_common_edit_message', 'Anda akan memperbaharui data Item');
define('lang_mod_biblio_item_common_last_update', 'Terakhir diubah');
define('lang_mod_biblio_item_common_delete_success', 'Item Data berhasil dihapus');
define('lang_mod_biblio_item_common_delete_failed', 'Item Data GAGAL dihapus');
define('lang_mod_biblio_item_alert_remove_success', 'Item berhasil hapus!');
define('lang_mod_biblio_item_alert_remove_failed', 'Item GAGAL hapus!');
# file attached
define('lang_mod_biblio_file_delete_success', 'Berkas {file_d[0]} dihapus');
define('lang_mod_biblio_file_delete_fail', 'Berkas {file_d[0]} TIDAK BISA dihapus');
# export
define('lang_mod_biblio_export_header', 'Fasilitas Eksport');
define('lang_mod_biblio_export_header_text', 'Eksport data bibliografi data kedalam berkas CSV');
define('lang_mod_biblio_export_form_field_separator', 'Pemisah antar ruas*');
define('lang_mod_biblio_export_form_field_enclosed', 'Pengapit ruas/teks*');
define('lang_mod_biblio_export_form_field_rec_separator', 'Pemisah cantuman/rekod');
define('lang_mod_biblio_export_form_field_rec_to_export', 'Jumlah rekod akan diekspor (0 untuk semua rekod)');
define('lang_mod_biblio_export_form_field_rec_start', 'Awal no rekod');
define('lang_mod_biblio_export_form_button_start', 'Mulai Ekspor data');
define('lang_mod_biblio_export_alert_all_field', 'Ruas penting (bertanda *) harus diisi dengan benar!');
define('lang_mod_biblio_export_alert_err_query', 'Error dalam query di database. Ekspor GAGAL!');
define('lang_mod_biblio_export_alert_no_record', 'Belum ada data dalam tabel bibliografi di database. Ekspor GAGAL!');
# import
define('lang_mod_biblio_import_header', 'Fasiltas Import');
define('lang_mod_biblio_import_header_text', 'Import data bibiliogrfi dari berkas CVS. Lihat panduan tentang format penulisan dan urutan ruas dalam berkas CVS atau kunjungi <a href="http://senayan.diknas.go.id" target="_blank">Situs Resmi</a>');
define('lang_mod_biblio_import_form_field_file_input', 'Berkas yang di impor*');
define('lang_mod_biblio_import_file_input_require', 'Tentukan file yang akan diimpor!');
define('lang_mod_biblio_import_form_field_separator', 'Pemisah antar ruas*');
define('lang_mod_biblio_import_form_field_enclosed', 'Pengapit ruas/teks*');
define('lang_mod_biblio_import_form_field_rec_to_export', 'Jumlah rekod akan diimpor (0 untuk semua rekod)');
define('lang_mod_biblio_import_form_field_rec_start', 'Awal no rekod');
define('lang_mod_biblio_import_form_button_start', 'Mulai Import');
define('lang_mod_biblio_import_alert_all_field', 'Ruas penting (bertanda *) harus diisi dengan benar!');
define('lang_mod_biblio_import_alert_err_size', 'Impor GAGAL! Jenis berkas tidak sesuai atau ukuran lebih dari ');
define('lang_mod_biblio_alert_field_author_removed', 'Penanggung Jawab/Author dihapus!');
define('lang_mod_biblio_alert_field_author_session_removed', 'Penanggung Jawab/Author berhasil dihapus!');
# pop-ups
# author
define('lang_mod_biblio_author_update_ok', 'Pengarang berhasil diperbaharui!');
define('lang_mod_biblio_author_added_ok', 'Pengarang berhasil ditambahkan!');
define('lang_mod_biblio_author_added_fail', 'Pengarang GAGAL Ditambahkan. Hubungi System Administrator');
define('lang_mod_biblio_author_form_name', 'Nama Pengarang');
define('lang_mod_biblio_author_form_search', 'Ketik untuk mencari pengarang atau menambah baru');
define('lang_mod_biblio_author_insert_to_biblio', 'Sisipkan Dalam Bibliografi');
# topic
define('lang_mod_biblio_topic_update_ok', 'Subyek berhasil diperbaharui!');
define('lang_mod_biblio_topic_added_ok', 'Subyek berhasil ditambahkan!');
define('lang_mod_biblio_topic_added_fail', 'Subyek GAGAL Ditambahkan. Hubungi System Administrator');
define('lang_mod_biblio_topic_form_title', 'Tambahkan Subyek');
define('lang_mod_biblio_topic_form_keyword', 'Kata kunci');
define('lang_mod_biblio_topic_form_search', 'Ketik untuk mencari topik atau menambah baru');
define('lang_mod_biblio_topic_insert_to_biblio', 'Sisipkan Dalam Bibliografi');

/* CIRCULATION MODULE */
# submenu
define('lang_mod_circ', 'Sirkulasi');
define('lang_mod_circ_start', 'Mulai Transaksi');
define('lang_mod_circ_start_titletag', 'Mulai Proses Transaksi Sirkulasi');
define('lang_mod_circ_quick_return', 'Pengembalian Cepat');
define('lang_mod_circ_quick_return_titletag', 'Pengembalian Cepat Koleksi');
define('lang_mod_circ_quick_return_msg1', 'Masukan nomor Kode Item dengan menggunakan keyboard atau barcode reader');
define('lang_mod_circ_loan_rules', 'Aturan Peminjaman');
define('lang_mod_circ_loan_rules_titletag', 'Lihat dan Memodifikasi Aturan Peminjaman');
define('lang_mod_circ_loan_rules_add', 'Tambah Aturan Peminjaman');
define('lang_mod_circ_loan_rules_list', 'Daftar Aturan Peminjaman');
define('lang_mod_circ_transaction_history', 'Sejarah Peminjaman');
define('lang_mod_circ_transaction_history_titletag', 'Sejarah Peminjaman');
define('lang_mod_circ_overdues', 'Keterlambatan');
define('lang_mod_circ_overdues_titletag', 'Daftar Anggota yang Memiliki Keterlambatan');
# common
define('lang_mod_circ_common_welcome', 'SIRKULASI - Masukkan nomor anggota untuk mulai transaksi dengan keyboard atau pemindai');
define('lang_mod_circ_common_loan_not_saved', 'ERROR! Data peminjaman tidak dapat masuk ke dalam database');
define('lang_mod_circ_common_trans_finish', 'Transaksi sirkulasi dengan anggota {member_id} telah selesai');
define('lang_mod_circ_common_error_unregistered_member', ' tidak terdaftar (tidak diregistrasi dalam database) ');
define('lang_mod_circ_common_error_expired_membership', 'Masa Keanggotaan sudah habis');
define('lang_mod_circ_common_error_pending_membership', 'Keanggotaan saat ini sedang di-pending, transaksi peminjaman tidak bisa dilakukan.');
define('lang_mod_circ_common_return_confirmation', 'Yakin akan mengembalikan koleksi ini');
define('lang_mod_circ_common_extend_confirmation', 'Yakin akan memperpanjang koleksi');
define('lang_mod_circ_common_overdued_for_1', 'TERLAMBAT selama');
define('lang_mod_circ_common_overdued_for_2', 'hari dengan jumlah denda');
define('lang_mod_circ_common_loan_confirmation', 'Tutup/Selesaikan Transaksi?');
define('lang_mod_circ_common_finished_loan_confirmation', 'Transaksi Selesai');
define('lang_mod_circ_common_fines_inserted', 'Denda keterlambatan telah masuk ke dalam database');
define('lang_mod_circ_common_fines_alert_01', 'Deskripsi Denda dan Debet tidak boleh kosong');
define('lang_mod_circ_common_fines_alert_02', 'Nilai Kredit harus sama atau lebih rendah dibanding Debet');
define('lang_mod_circ_common_alert_error_limit_reach', 'Jumlah peminjaman sudah maksimal!');
define('lang_mod_circ_common_alert_extended_success', 'Peminjaman diperpanjang');
define('lang_mod_circ_common_overide_confirmation', 'Anda mau menganulir ketentuan ini?');
define('lang_mod_circ_alert_on_resereved', 'PERHATIAN! Item ini telah direservasi oleh anggota yang lain');
define('lang_mod_circ_alert_item_not_registered', 'Item ini tidak terdaftar dalam pangkalan data');
define('lang_mod_circ_alert_item_not_available', 'Item tidak dipinjamkan untuk saat ini');
define('lang_mod_circ_alert_member_expired', 'DILARANG meminjam! Keanggotaan sudah habis!');
define('lang_mod_circ_alert_member_pending', 'DILARANG meminjam! Keanggotaan sedang ditunda untuk sementara!');
define('lang_mod_circ_alert_not_for_loan', 'Item tidak dipinjamkan!');
define('lang_mod_circ_alert_item_remove_from_session', 'Item {removeID} dihapus dari session');
define('lang_mod_circ_common_item_already_return', 'Item ini sudah dikembalikan atau tidak terdaftar pada tabel peminjaman');
define('lang_mod_circ_common_return_overdue', 'TERLAMBAT {overdueDays} hari dengan denda sebesar '); /* see common_overdued_for_1 & 2 */
define('lang_mod_circ_common_item_return_ok', ' sudah dikembalikan pada ');
define('lang_mod_circ_reserve', 'Reservasi');
define('lang_mod_circ_reserve_alert_nod_data', 'TIDAK ADA DATA yang dipilih untuk reservasi!');
define('lang_mod_circ_reserve_alert_forbidden', 'Tidak bisa mereservasi. Item tidak untuk dipinjamkan!');
define('lang_mod_circ_reserve_alert_success', 'Reservasi ditambahkan');
define('lang_mod_circ_reserve_alert_after_return', 'Koleksi {itemCode} saat ini sedang dalam reservasi oleh anggota {member}');
define('lang_mod_circ_reserve_alert_available', 'Item untuk judul ini sudah tersedia atau sudah dipinjam oleh yang bersangkutan!');
define('lang_mod_circ_reserve_alert_removed', 'Reservasi dihapus');
define('lang_mod_circ_reserve_alert_reach_limit', 'Tidak bisa menambahkan data reservasi karena sudah mencapai batas maksimum reservasi');
define('lang_mod_circ_fines_alert_removed', 'Data denda dihapus');
# transaction form
define('lang_mod_circ_field_member_id', 'No Anggota');
define('lang_mod_circ_field_member_name', 'Nama Anggota');
define('lang_mod_circ_field_member_email', 'Email Anggota');
define('lang_mod_circ_field_register_date', 'Tanggal Registrasi');
define('lang_mod_circ_field_member_type', 'Tipe Keanggotaan');
define('lang_mod_circ_field_expiry_date', 'Berlaku Hingga');
define('lang_mod_circ_button_loans', 'Peminjaman');
define('lang_mod_circ_button_current_loans', 'Sedang Dipinjam');
define('lang_mod_circ_button_reserve', 'Reservasi');
define('lang_mod_circ_button_fines', 'Denda');
define('lang_mod_circ_button_loan_history', 'Sejarah Peminjaman');
define('lang_mod_circ_button_finish_transaction', 'Selesai Transaksi');
define('lang_mod_circ_tblheader_return', 'Kembali');
define('lang_mod_circ_tblheader_extend', 'Perpanjang');
define('lang_mod_circ_tblheader_item_code', 'Kode Koleksi');
define('lang_mod_circ_tblheader_title', 'Judul');
define('lang_mod_circ_tblheader_loan_date', 'Tanggal Pinjam');
define('lang_mod_circ_tblheader_due_date', 'Tanggal Harus Kembali');
define('lang_mod_circ_tblheader_returned_date', 'Tanggal Dikembalikan');
define('lang_mod_circ_tblheader_remove', 'Hapus');
define('lang_mod_circ_tblheader_reserve_date', 'Tanggal Reservasi');
define('lang_mod_circ_tblheader_add_new_fines', 'Tambah Denda');
define('lang_mod_circ_tblheader_fines_list', 'Daftar Denda');
define('lang_mod_circ_tblheader_view_balanced_overdue', 'Denda Yang sudah Lunas');
define('lang_mod_circ_loan_field_insert_barcode', 'Masukkan Kode Barkod');
define('lang_mod_circ_loan_button_loan', 'Pinjam');
define('lang_mod_circ_reserve_field_search_collection', 'Cari Koleksi');
define('lang_mod_circ_reserve_button_add_reserve', 'Tambah Reservasi');
define('lang_mod_circ_return_titletext_return', 'Kembalikan Koleksi ini');
define('lang_mod_circ_return_alttext_return', 'Kembali');
define('lang_mod_circ_return_no_return_history_data', 'Belum ada yang dikembalikan');
define('lang_mod_circ_extend_alttext_no_extend', 'Tidak Boleh Perpanjang Peminjaman');
define('lang_mod_circ_extend_titletext_extend', 'Perpanjang Peminjaman untuk Koleksi ini');
define('lang_mod_circ_extend_alttext_extend', 'Perpanjang Peminjaman');
define('lang_mod_circ_extend_renewal_flag', 'Peminjaman Diperpanjang');
define('lang_mod_circ_extend_noextend_confirmation', 'Masa Peminjaman koleksi TIDAK BISA diperpanjang. Telah dipesan oleh anggota lain');
# fines
define('lang_mod_circ_fines_alert_new_added', 'Data Denda Berhasil Disimpan');
define('lang_mod_circ_fines_alert_fail_to_save', 'Data Denda GAGAL Disimpan. Hubungi System Administrator Untuk Pemecahannya');
define('lang_mod_circ_fines_alert_required_data', 'Deskripsi/Nama Denda dan jumlah Debet tidak boleh kosong');
define('lang_mod_circ_fines_alert_balance_data', 'Nilai Kredit tidak boleh lebih besar dari Debet');
define('lang_mod_circ_fines_alert_updated', 'Data Denda Berhasil Diperbaharui');
define('lang_mod_circ_fines_alert_not_updated', 'Data Denda GAGAL Diperbaharui. Hubungi System Administrator Untuk Pemecahannya');
define('lang_mod_circ_fines_alert_not_exists', 'Error! Data denda tidak ditemukan!');
define('lang_mod_circ_fines_common_info', 'Anda akan memperbaharui data denda : ');
# form
define('lang_mod_circ_fines_field_date', 'Tanggal Denda');
define('lang_mod_circ_fines_field_description', 'Deskripsi/Nama');
define('lang_mod_circ_fines_field_debit', 'Debet');
define('lang_mod_circ_fines_field_credit', 'Kredit');
# loan rules
define('lang_mod_circ_loan_rules_alert_add_ok', 'Aturan Peminjaman Baru Berhasil Disimpan');
define('lang_mod_circ_loan_rules_alert_add_fail', 'Aturan Peminjaman GAGAL Disimpan. Hubungi System Administrator Untuk Pemecahannya');
# form loan rules
define('lang_mod_circ_loan_rules_field_member_type', 'Jenis Anggota');
define('lang_mod_circ_loan_rules_field_collection_type', 'Jenis Koleksi');
define('lang_mod_circ_loan_rules_field_gmd', 'GMD');
define('lang_mod_circ_loan_rules_field_loan_limit', 'Batas Peminjaman');
define('lang_mod_circ_loan_rules_field_loan_period', 'Periode Peminjaman');
define('lang_mod_circ_loan_rules_field_reborrow_limit', 'Batas Peminjaman Kembali');
define('lang_mod_circ_loan_rules_field_fines', 'Denda Harian');
# common loan rules
define('lang_mod_circ_loan_rules_alert_updated_ok', 'Aturan Peminjaman Berhasil Diperbaharui');
define('lang_mod_circ_loan_rules_alert_updated_fail', 'Aturan Peminjaman GAGAL Diperbaharui. Hubungi System Administrator Untuk Pemecahannya');
define('lang_mod_circ_loan_rules_alert_not_exist', 'Error! Data Peraturan Peminjaman tidak ditemukan!');
define('lang_mod_circ_loan_rules_common_edit_info', 'Anda akan memperbaharui aturan peminjaman : ');
define('lang_mod_circ_loan_rules_common_last_update', 'Terakhir diperbaharui ');
define('lang_mod_circ_loan_rules_alert_all_deleted', 'Semua Data Berhasil Dihapus');
define('lang_mod_circ_loan_rules_alert_not_all_deleted', 'Sebagian Atau Semua Peraturan GAGAL Dihapus.!\nHubungi System Administrator Untuk Pemecahannya');
define('lang_mod_circ_loan_rules_alert_deleted', 'Peraturan Peminjaman Berhasil Dihapus');
define('lang_mod_circ_loan_rules_alert_not_deleted', 'Peraturan Peminjaman GAGAL Dihapus');
# overdue loan
define('lang_mod_circ_loan_overdue_tblheader', 'Anggota Dengan Keterlambatan');
# quick return
define('lang_mod_circ_loan_quick_return_disable', 'Pengembalian cepat tidak tersedia');
define('lang_mod_circ_loan_quick_return_form_item_id', 'Item ID');
define('lang_mod_circ_loan_quick_return_form_button', 'Dikembalikan');
# reserve list
define('lang_mod_circ_loan_reserve_status', 'TERSEDIA');
define('lang_mod_circ_loan_reserve_confirm_delete', 'Anda yakin untuk menghapus reservasi dari');
define('lang_mod_circ_loan_reserve_expired', 'SUDAH EXPIRED');

/* MEMBERSHIP MODULE */
# submenu
define('lang_mod_membership', 'Keanggotaan');
define('lang_mod_membership_view_member_list', 'Lihat Daftar Anggota');
define('lang_mod_membership_view_member_list_titletag', 'Lihat Daftar Anggota Perpustakaan');
define('lang_mod_membership_add_new_member', 'Tambah Anggota');
define('lang_mod_membership_add_new_member_titletag', 'Tambah Data Anggota Perpustakaan');
define('lang_mod_membership_member_type', 'Tipe Anggota');
define('lang_mod_membership_member_type_titletag', 'Lihat dan modifikasi tipe anggota');
define('lang_mod_membership_member_type_new_add', 'Tambah Tipe Anggota Baru');
define('lang_mod_membership_member_type_list', 'Daftar Tipe Anggota');
define('lang_mod_membership_member_list', 'Daftar Anggota');
define('lang_mod_membership_view_expired_member', 'Lihat Anggota yang Expired');
define('lang_mod_membership_tools', 'Alat Bantu');
define('lang_mod_membership_import_data', 'Impor Data');
define('lang_mod_membership_import_data_titletag', 'Impor Data Anggota dari file CSV');
define('lang_mod_membership_import_data_description', 'Fasilitas Impor data anggota dari berkas CSV');
define('lang_mod_membership_export_data', 'Expor Data');
define('lang_mod_membership_export_data_titletag', 'Ekspor Data Anggota ke CSV file');
define('lang_mod_membership_export_data_description', 'Fasilitas Ekspor data anggota dalam berkas CSV');
define('lang_mod_membership_search', 'Pencarian Anggota');
define('lang_mod_membership_search_button', 'Pencarian');
define('lang_mod_membership_card_generator_titletag', 'Cetak Kartu Anggota');
define('lang_mod_membership_card_generator', 'Kartu Anggota');
# common
define('lang_mod_membership_common_error_no_id_name', 'ID dan Nama Anggota tidak boleh kosong');
define('lang_mod_membership_common_member_data_saved', 'Data Anggota Baru Berhasil Disimpan');
define('lang_mod_membership_common_image_upload_success', 'Unggah Gambar Berhasil');
define('lang_mod_membership_common_image_upload_error', 'Unggah Gambar Gagal');
define('lang_mod_membership_common_error_fail_to_save_member_data', 'Data anggota gagal di-simpan/update. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_membership_common_error_member_data_not_exist', 'ERROR! Data dicari tidak ada');
define('lang_mod_membership_common_error_membership_expired', 'Keanggotaan telah expired');
define('lang_mod_membership_common_member_data_updated', 'Data Anggota Berhasil diperbarui');
define('lang_mod_membership_button_save', 'Simpan');
define('lang_mod_membership_common_maximum', 'Maksimum');
define('lang_mod_membership_common_edit_message', 'Anda akan meng-edit data anggota');
define('lang_mod_membership_common_last_update', 'Terakhir di-update');
define('lang_mod_membership_common_alert_no_delete_member_data', 'Data anggota dibawah tidak bisa dihapus karena masih memiliki koleksi yang belum dikembalikan');
define('lang_mod_membership_common_alert_no_delete_member_data_1', 'Data anggota');
define('lang_mod_membership_common_alert_no_delete_member_data_2', 'tidak bisa dihapus karena masih memiliki');
define('lang_mod_membership_common_alert_no_delete_member_data_3', 'pinjaman yang belum dikembalikan');
define('lang_mod_membership_common_member_data_deleted_success', 'Data Anggota Berhasil Dihapus');
define('lang_mod_membership_common_member_data_deleted_failed', 'Data Anggota gagal dihapus');
define('lang_mod_membership_common_expired_member_list', 'Daftar Anggota yang Expired');
define('lang_mod_membership_common_found_text_1', 'Ditemukan');
define('lang_mod_membership_common_found_text_2', 'dari kata kunci');
define('lang_mod_membership_common_alert_delete_member_data_success', 'Data berhasil dihapus');
define('lang_mod_membership_common_alert_delete_member_data_failed', 'Sebagian atau semua data gagal dihapus!\nHubungi admin sistem untuk pemecahannya');
# form
define('lang_mod_membership_field_extend_membership', 'Perpanjang Keanggotaan');
define('lang_mod_membership_field_extend', 'Perpanjang');
define('lang_mod_membership_field_member_id', 'ID Anggota');
define('lang_mod_membership_field_name', 'Nama Anggota');
define('lang_mod_membership_field_birth_date', 'Tanggal Lahir');
define('lang_mod_membership_field_institution', 'Institusi');
define('lang_mod_membership_field_membership_type', 'Tipe Keanggotaan');
define('lang_mod_membership_field_gender', 'Jenis Kelamin');
define('lang_mod_membership_field_gender_opt1', 'Laki-laki');
define('lang_mod_membership_field_gender_opt2', 'Perempuan');
define('lang_mod_membership_field_email', 'E-mail');
define('lang_mod_membership_field_address', 'Alamat');
define('lang_mod_membership_field_postal_code', 'Kode Pos');
define('lang_mod_membership_field_phone_number', 'Nomor Telepon');
define('lang_mod_membership_field_fax_number', 'Nomor Faks');
define('lang_mod_membership_field_personal_id', 'Nomor ID Personal');
define('lang_mod_membership_field_notes', 'Catatan');
define('lang_mod_membership_field_photo', 'Foto');
define('lang_mod_membership_field_member_since', 'Anggota Sejak');
define('lang_mod_membership_field_register_date', 'Tanggal Registrasi');
define('lang_mod_membership_field_expiry_date', 'Tanggal Expiry');
define('lang_mod_membership_field_pending', 'Tunda Keanggotaan');
# member type form
define('lang_mod_member_type_alert_name_noempty', 'Tipe Keanggotaan Tidak Boleh Kosong');
define('lang_mod_member_type_alert_data_not_exist', 'ERROR! Data Tipe Keanggotaan tidak ditemukan');
define('lang_mod_member_type_common_edit_message', 'Anda akan meng-edit data tipe keanggotaan');
define('lang_mod_member_type_common_last_update', 'Terakhir diperbaharui');
define('lang_mod_member_type_common_member_type_saved', 'Tipe Keanggotaan Baru Berhasil Disimpan');
define('lang_mod_member_type_common_member_type_updated', 'Tipe Keanggotaan Berhasil Diperbaharui');
define('lang_mod_member_type_common_fail_to_save_member_type', 'Data Tipe Keanggotaan GAGAL Disimpan/Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_member_type_field_name', 'Tipe Keanggotaan');
define('lang_mod_member_type_field_periode', 'Masa Keanggotaan (Dalam Hari)');
define('lang_mod_circ_field_loan_limit', 'Jumlah Pinjaman');
define('lang_mod_circ_field_loan_periode', 'Lama Peminjaman (Dalam Hari)');
define('lang_mod_circ_field_reserve', 'Reservasi');
define('lang_mod_circ_field_reserve_limit', 'Jumlah Reservasi');
define('lang_mod_circ_field_reborrow_limit', 'Kali Perpanjangan');
define('lang_mod_circ_field_fine_each_day', 'Denda Per Hari');
define('lang_mod_circ_field_grace_periode', 'Toleransi Keterlambatan');
# import membership
define('lang_mod_member_import_file_noempty', 'Nama File Import Harus Dilengkapi!');
define('lang_mod_member_import_alert_required_noempty', 'Kotak isian bertanda * harus diisi dengan benar!');
define('lang_mod_member_import_alert_fail', 'GAGAL diunggah! Jenis berkas tidak sesuai atau ukurannya lebih besar dari');
define('lang_mod_member_import_info_record_uploaded',  'rekod berhasil disisipkan dalam data anggota dari total rekod');
define('lang_mod_member_import_field_file', 'Berkas Untuk Diimpor');
define('lang_mod_member_import_field_field_separator', 'Pemisah Antar Ruas');
define('lang_mod_member_import_field_field_enclosed', 'Batas Awal-Akhir Ruas');
define('lang_mod_member_import_field_record_number', 'Jumlah rekod yang di impor (0 untuk semua rekod)');
define('lang_mod_member_import_field_record_offset', 'Mulai dari rekod ke');
define('lang_mod_member_import_button_start', 'Impor Sekarang');
# export membership
# export membership
define('lang_mod_member_export_alert_required_noempty', 'Kotak isian yang dibutukan (bertanda *) harus diisi dengan benar!');
define('lang_mod_member_export_alert_fail', 'Tabel keanggotaan dalam pangkalan data belum memiliki rekod. Ekspor GAGAL!');
define('lang_mod_member_export_alert_query_fail', 'Error pada query ke pangkalan data. Ekspor GAGAL!');
define('lang_mod_member_export_field_field_separator', 'Pemisah Antar Ruas');
define('lang_mod_member_export_field_field_enclosed', 'Batas Awal-Akhir Ruas');
define('lang_mod_member_export_field_record_number', 'Jumlah rekod yang di ekspor (0 untuk semua rekod)');
define('lang_mod_member_export_field_record_offset', 'Mulai dari rekod ke');
define('lang_mod_member_export_field_record_separator', 'Batas Pemisah Rekod');
define('lang_mod_member_export_button_start', 'Ekspor Sekarang');

/* MASTER FILE MODULE */
# submenu
define('lang_mod_masterfile_authority_files', 'Daftar Terkendali');
define('lang_mod_masterfile_lookup_files', 'Daftar Referensi');
define('lang_mod_masterfile_gmd', 'GMD');
define('lang_mod_masterfile_gmd_titletag', 'Format Fisik Dokumen');
define('lang_mod_masterfile_gmd_new_add', 'GMD Baru');
define('lang_mod_masterfile_gmd_list', 'Daftar GMD');
define('lang_mod_masterfile_publisher', 'Penerbit');
define('lang_mod_masterfile_publisher_titletag', 'Penerbit Dokumen');
define('lang_mod_masterfile_publisher_new_add', 'Tambah Penerbit Baru');
define('lang_mod_masterfile_publisher_list', 'Daftar Penerbit');
define('lang_mod_masterfile_supplier', 'Penyuplai/Agen');
define('lang_mod_masterfile_supplier_titletag', 'Penyuplai Koleksi');
define('lang_mod_masterfile_supplier_new_add', 'Tambah Penyuplai/Agen');
define('lang_mod_masterfile_supplier_list', 'Daftar Penyuplai/Agen');
define('lang_mod_masterfile_author', 'Pengarang');
define('lang_mod_masterfile_author_titletag', 'Pengarang Dokumen');
define('lang_mod_masterfile_author_new_add', 'Pengarang Baru');
define('lang_mod_masterfile_author_list', 'Daftar Pengarang ');
define('lang_mod_masterfile_topic', 'Subyek');
define('lang_mod_masterfile_topic_titletag', 'Subyek Dokumen');
define('lang_mod_masterfile_topic_new_add', 'Tambah Subyek Baru');
define('lang_mod_masterfile_topic_type', 'Tipe Subyek');
define('lang_mod_masterfile_topic_list', 'Daftar Subyek');
define('lang_mod_masterfile_location', 'Lokasi');
define('lang_mod_masterfile_location_titletag', 'Lokasi Koleksi');
define('lang_mod_masterfile_location_new_add', 'Lokasi Koleksi Baru');
define('lang_mod_masterfile_location_list', 'Daftar Lokasi');
define('lang_mod_masterfile_place', 'Tempat');
define('lang_mod_masterfile_place_titletag', 'Nama-nama Tempat');
define('lang_mod_masterfile_place_new_add', 'Nama Tempat Baru');
define('lang_mod_masterfile_place_list', 'Daftar Tempat');
define('lang_mod_masterfile_itemstatus', 'Status Koleksi');
define('lang_mod_masterfile_itemstatus_titletag', 'Status Koleksi');
define('lang_mod_masterfile_itemstatus_new_add', 'Tambah Status Koleksi Baru');
define('lang_mod_masterfile_itemstatus_list', 'Daftar Status Koleksi');
define('lang_mod_masterfile_colltype', 'Tipe Koleksi');
define('lang_mod_masterfile_colltype_titletag', 'Tipe Koleksi');
define('lang_mod_masterfile_colltype_new_add', 'Tambah Tipe Koleksi Baru');
define('lang_mod_masterfile_colltype_list', 'Daftar Tipe Koleksi');
define('lang_mod_masterfile_lang', 'Bahasa Dok.');
define('lang_mod_masterfile_lang_titletag', 'Bahasa Konten Dokumen');
define('lang_mod_masterfile_lang_new_add', 'Tambah Bahasa');
define('lang_mod_masterfile_lang_list', 'Daftar Bahasa');
define('lang_mod_masterfile_label', 'Label');
define('lang_mod_masterfile_label_titletag', 'Label');
define('lang_mod_masterfile_label_new_add', 'Tambah Label');
define('lang_mod_masterfile_label_list', 'Daftar Label');
define('lang_mod_masterfile_frequency', 'Kala Terbit');
define('lang_mod_masterfile_frequency_titletag', 'Kala Terbit');
define('lang_mod_masterfile_frequency_new_add', 'Tambah Kala Terbit');
define('lang_mod_masterfile_frequency_list', 'Daftar Kala Terbit');
# author master file
# common
define('lang_mod_masterfile_author_alert_name_noempty', 'Nama Pengarang tidak boleh kosong');
define('lang_mod_masterfile_author_alert_new_add_ok', 'Pengarang Baru Berhasil Disimpan');
define('lang_mod_masterfile_author_alert_add_fail', 'Data Pengarang GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_author_alert_update_ok', 'Data Pengarang Berhasil Diperbaharui');
define('lang_mod_masterfile_author_alert_update_fail', 'Data Pengarang GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_author_alert_not_exists', 'ERROR! Data Pengarang tidak ditemukan');
define('lang_mod_masterfile_author_common_edit_info', 'Anda akan meng-edit data pengarang : ');
define('lang_mod_masterfile_author_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_author_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_author_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_author_alert_delete_ok', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_author_form_field_name', 'Nama Pengarang');
define('lang_mod_masterfile_author_form_field_authority', 'Jenis Pengarang');
# collection type master file
# common
define('lang_mod_masterfile_colltype_alert_name_noempty', 'Tipe koleksi tidak boleh kosong');
define('lang_mod_masterfile_colltype_alert_new_add_ok', 'Data Baru Tipe Koleksi Berhasil Disimpan');
define('lang_mod_masterfile_colltype_alert_add_fail', 'Data tipe koleksi GAGAL disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_colltype_alert_update_ok', 'Data Tipe Koleksi Berhasil Diperbaharui');
define('lang_mod_masterfile_colltype_alert_update_fail', 'Data Tipe Koleksi GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_colltype_alert_not_exists', 'ERROR! Data Tipe Koleksi Tidak Ditemukan');
define('lang_mod_masterfile_colltype_common_edit_info', 'Anda akan meng-edit data tipe koleksi : ');
define('lang_mod_masterfile_colltype_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_colltype_alert_not_delete', 'Data berikut tidak bisa dihapus : \n');
define('lang_mod_masterfile_colltype_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_colltype_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_colltype_alert_has_item', 'Tipe koleksi {item_name} masih digunakan oleh {number_items} item');
define('lang_mod_masterfile_colltype_alert_inuse', 'Tipe Koleksi ini tidak bisa dihapus karena masih diguanakan oleh {item_d} items. Hapus data item terlebih dahulu');
define('lang_mod_masterfile_colltype_alert_delete_fail', 'Rekod GAGAL dihapus');
#form
define('lang_mod_masterfile_colltype_form_field_colltype', 'Tipe koleksi');
# language master file
# common
define('lang_mod_masterfile_lang_alert_name_noempty', 'Kode dan Nama Bahasa tidak boleh kosong');
define('lang_mod_masterfile_lang_alert_new_add_ok', 'Bahasa Baru Berhasil Disimpan');
define('lang_mod_masterfile_lang_alert_add_fail', 'Data Bahasa GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_lang_alert_update_ok', 'Data Bahasa Berhasil Diperbaharui');
define('lang_mod_masterfile_lang_alert_update_fail', 'Data Bahasa GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_lang_alert_not_exists', 'ERROR! Bahasa yang dipilih tidak ditemukan');
define('lang_mod_masterfile_lang_common_edit_info', 'Anda akan meng-edit data bahasa : ');
define('lang_mod_masterfile_lang_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_lang_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_lang_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_lang_alert_delete_ok', 'Rekod berhasil dihapus');
# form
define('lang_mod_masterfile_lang_form_field_lang_code', 'Kode Bahasa');
define('lang_mod_masterfile_lang_form_field_name', 'Bahasa');
# GMD master file
# common
define('lang_mod_masterfile_gmd_alert_name_noempty', 'Kode dan Nama GMD tidak boleh kosong');
define('lang_mod_masterfile_gmd_alert_new_add_ok', 'GMD Baru Berhasil Disimpan');
define('lang_mod_masterfile_gmd_alert_add_fail', 'Data GMD GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_gmd_alert_update_ok', 'Data GMD Berhasil Diperbaharui');
define('lang_mod_masterfile_gmd_alert_update_fail', 'Data GMD GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_gmd_alert_not_exists', 'ERROR! GMD terpilih tidak ditemukan');
define('lang_mod_masterfile_gmd_common_edit_info', 'Anda akan meng-edit data GMD');
define('lang_mod_masterfile_gmd_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_gmd_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_gmd_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_gmd_alert_delete_ok', 'Data GMD berhasil dihapus');
define('lang_mod_masterfile_gmd_alert_delete_fail', 'Rekod GAGAL dihapus');
#form
define('lang_mod_masterfile_gmd_form_field_gmd_code', 'Kode GMD');
define('lang_mod_masterfile_gmd_form_field_gmd_name', 'Nama GMD');
define('lang_mod_masterfile_gmd_form_field_gmd_icon', 'Icon GMD');
# Item status master file
# common
define('lang_mod_masterfile_itemstatus_alert_name_noempty', 'Kode dan Nama Status Koleksi tidak boleh kosong');
define('lang_mod_masterfile_itemstatus_alert_new_add_ok', 'Status Koleksi Yang Baru Berhasil Disimpan');
define('lang_mod_masterfile_itemstatus_alert_add_fail', 'Status Koleksi GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_itemstatus_alert_update_ok', 'Status Koleksi Berhasil Diperbaharui');
define('lang_mod_masterfile_itemstatus_alert_update_fail', 'Status Koleksi GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_itemstatus_alert_not_exists', 'ERROR! Status Koleksi terpilih tidak ditemukan');
define('lang_mod_masterfile_itemstatus_common_edit_info', 'Anda akan meng-edit data status koleksi');
define('lang_mod_masterfile_itemstatus_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_itemstatus_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_itemstatus_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_itemstatus_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_itemstatus_form_field_code', 'Kode Status Koleksi');
define('lang_mod_masterfile_itemstatus_form_field_name', 'Status Koleksi');
define('lang_mod_masterfile_itemstatus_form_field_rules', 'Peraturannya');
# location master file
# common
define('lang_mod_masterfile_location_alert_name_noempty', 'Kode Lokasi dan Nama tidak boleh kosong');
define('lang_mod_masterfile_location_alert_new_add_ok', 'Data Baru Lokasi Berhasil Disimpan');
define('lang_mod_masterfile_location_alert_add_fail', 'Data Lokasi GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_location_alert_update_ok', 'Data Lokasi Berhasil Diperbaharui');
define('lang_mod_masterfile_location_alert_update_fail', 'Data Lokasi GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_location_alert_not_exists', 'ERROR! Lokasi terpilih tidak ditemukan');
define('lang_mod_masterfile_location_common_edit_info', 'Anda akan meng-edit data lokasi : ');
define('lang_mod_masterfile_location_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_location_alert_not_delete', 'Data Berikut tidak berhasil dihapus');
define('lang_mod_masterfile_location_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_location_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_location_alert_has_item', 'Lokasi {item_name} masih digunakan oleh {number_items} item');
define('lang_mod_masterfile_location_alert_inuse', 'Data Lokasi ini GAGAL dihapus karena masih digunakan oleh {item_d} item dalam tabel\nHapus item terkait lebih dahulu');
define('lang_mod_masterfile_location_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_location_form_field_code', 'Kode Lokasi');
define('lang_mod_masterfile_location_form_field_name', 'Nama Lokasi');
# place of publication master file
# common
define('lang_mod_masterfile_place_alert_name_noempty', 'Nama Tempat tidak boleh kosong');
define('lang_mod_masterfile_place_alert_new_add_ok', 'Data Tempat Baru Berhasil Disimpan');
define('lang_mod_masterfile_place_alert_add_fail', 'Data Tempat GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_place_alert_update_ok', 'Data Tempat Berhasil Diperbaharui');
define('lang_mod_masterfile_place_alert_update_fail', 'Data Tempat Terbit GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_place_alert_not_exists', 'ERROR! Nama Tempat terpilih tidak ditemukan');
define('lang_mod_masterfile_place_common_edit_info', 'Anda akan mengedit data tempat');
define('lang_mod_masterfile_place_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_place_alert_not_delete', 'Data Tempat berikut tidak berhasil dihapus : \n');
define('lang_mod_masterfile_place_alert_all_delete_ok', 'Semua Data Berhasil Dihapus');
define('lang_mod_masterfile_place_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_place_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_place_form_field_name', 'Nama Tempat');
# publisher master file
# common
define('lang_mod_masterfile_publisher_alert_name_noempty', 'Nama Penerbit tidak boleh kosong');
define('lang_mod_masterfile_publisher_alert_new_add_ok', 'Data Penerbit Baru Berhasil Disimpan');
define('lang_mod_masterfile_publisher_alert_add_fail', 'Data Penerbit GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_publisher_alert_update_ok', 'Data Penerbit Berhasil Diperbahatui');
define('lang_mod_masterfile_publisher_alert_update_fail', 'Data PENERBIT GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_publisher_alert_not_exists', 'ERROR! Data Penerbit terpilih tidak ditemukan');
define('lang_mod_masterfile_publisher_common_edit_info', 'Anda akan meng-edit data penerbit');
define('lang_mod_masterfile_publisher_common_last_update', 'Perubahan terakhir ');
define('lang_mod_masterfile_publisher_alert_not_delete', 'Data berikut tidak dapat dihapus : \n');
define('lang_mod_masterfile_publisher_alert_all_delete_ok', 'Semua Data Terpilih Berhasil Dihapus');
define('lang_mod_masterfile_publisher_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_publisher_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_publisher_form_field_name', 'Nama Penerbit');
# supplier master file
# common
define('lang_mod_masterfile_supplier_alert_name_noempty', 'Nama Suplaiyer tidak boleh kosong');
define('lang_mod_masterfile_supplier_alert_new_add_ok', 'Data Suplaiyer Baru Berhasil Disimpan');
define('lang_mod_masterfile_supplier_alert_add_fail', 'Data Suplaiyer GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_supplier_alert_update_ok', 'Data Suplaiyer Berhasil Diperbaharui');
define('lang_mod_masterfile_supplier_alert_update_fail', 'Data Suplaiyer GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_supplier_alert_not_exists', 'ERROR! Data terpilih tidak ditemukan');
define('lang_mod_masterfile_supplier_common_edit_info', 'Anda akan meng-edit data Suplaiyer data');
define('lang_mod_masterfile_supplier_common_last_update', 'Perubahan Terakhir ');
define('lang_mod_masterfile_supplier_alert_all_delete_ok', 'Semua Data Terpilih Berhasil Dihapus');
define('lang_mod_masterfile_supplier_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_supplier_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_supplier_form_field_name', 'Nama Suplaiyer');
define('lang_mod_masterfile_supplier_form_field_address', 'Alamat');
define('lang_mod_masterfile_supplier_form_field_contact', 'Kontak');
define('lang_mod_masterfile_supplier_form_field_phone', 'Nomor Telepon');
define('lang_mod_masterfile_supplier_form_field_fax', 'Nomor Faks');
define('lang_mod_masterfile_supplier_form_field_account', 'Nomor Akun');
# topic master file
# common
define('lang_mod_masterfile_topic_alert_name_noempty', 'Subyek tidak boleh kosong');
define('lang_mod_masterfile_topic_alert_new_add_ok', 'Subyek Baru Berhasil Disimpan');
define('lang_mod_masterfile_topic_alert_add_fail', 'Subyek GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_topic_alert_update_ok', 'Data Subyek Berhasil Diperbaharui');
define('lang_mod_masterfile_topic_alert_update_fail', 'Subyek GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_topic_alert_not_exists', 'ERROR! Data terpilih tidak ditemukan');
define('lang_mod_masterfile_topic_common_edit_info', 'Anda akan meng-edit data Subyek ');
define('lang_mod_masterfile_topic_common_last_update', 'Perubahan Terakhir ');
define('lang_mod_masterfile_topic_alert_all_delete_ok', 'Semua Data terpilih berhasil dihapus');
define('lang_mod_masterfile_topic_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_topic_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_topic_form_field_name', 'Subyek');
# label master file
# common
define('lang_mod_masterfile_label_alert_new_add_ok', 'Label Baru Berhasil Disimpan');
define('lang_mod_masterfile_label_alert_add_fail', 'Label GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_label_alert_update_ok', 'Data Label Berhasil Diperbaharui');
define('lang_mod_masterfile_label_alert_update_fail', 'Label GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_label_alert_not_exists', 'ERROR! Data terpilih tidak ditemukan');
define('lang_mod_masterfile_label_common_edit_info', 'Anda akan meng-edit data Label ');
define('lang_mod_masterfile_label_common_last_update', 'Perubahan Terakhir ');
define('lang_mod_masterfile_label_alert_all_delete_ok', 'Semua Data terpilih berhasil dihapus');
define('lang_mod_masterfile_label_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_label_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_label_form_field_label_name', 'Nama Label');
define('lang_mod_masterfile_label_form_field_label_desc', 'Deskripsi Label');
define('lang_mod_masterfile_label_form_field_label_image', 'Gambar Label');
# frequency
define('lang_mod_masterfile_frequency_alert_new_add_ok', 'Kala Terbit Baru Berhasil Disimpan');
define('lang_mod_masterfile_frequency_alert_add_fail', 'Kala Terbit GAGAL Disimpan. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_frequency_alert_update_ok', 'Data Kala Terbit Berhasil Diperbaharui');
define('lang_mod_masterfile_frequency_alert_update_fail', 'Kala Terbit GAGAL Diperbaharui. Hubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_frequency_alert_not_exists', 'ERROR! Data terpilih tidak ditemukan');
define('lang_mod_masterfile_frequency_common_edit_info', 'Anda akan meng-edit data Kala Terbit ');
define('lang_mod_masterfile_frequency_common_last_update', 'Perubahan Terakhir ');
define('lang_mod_masterfile_frequency_alert_all_delete_ok', 'Semua Data terpilih berhasil dihapus');
define('lang_mod_masterfile_frequency_alert_all_delete_fail', 'Sebagian atau semua data GAGAL dihapus!\nHubungi admin sistem untuk pemecahannya');
define('lang_mod_masterfile_frequency_alert_delete_fail', 'Rekod GAGAL dihapus');
# form
define('lang_mod_masterfile_frequency_form_field_frequency_name', 'Kala Terbit');
define('lang_mod_masterfile_frequency_form_field_frequency_lang', 'Bahasa');
define('lang_mod_masterfile_frequency_form_field_frequency_time_increment', 'Selang Waktu');
define('lang_mod_masterfile_frequency_form_field_frequency_unit', 'Satuan Waktu');

/* STOCK TAKE MODULE */
# common
define('lang_mod_stocktake_active_status', 'Dalam Proses');
define('lang_mod_stocktake_total', 'Jumlah Inventarisasi Total');
define('lang_mod_stocktake_lost_total', 'Jumlah Total Koleksi Hilang');
define('lang_mod_stocktake_exists_total', 'Jumlah Koleksi Yang Ada');
define('lang_mod_stocktake_loan_total', 'Jumlah Total Koleksi Dipinjam');
define('lang_mod_stocktake_participants', 'Pelaksana Inventarisasi');
define('lang_mod_stocktake_total_checked', 'Total Checked/Scanned Items');
define('lang_mod_stocktake_finish_confirmation', 'Anda yakin mengakhiri proses Inventarisasi Koleksi? Setelah diakhiri anda tidak bisa mengubah kembali data Inventarisasi');
define('lang_mod_stocktake_purge_lost', 'Buang Data Koleksi Hilang');
# submenu
define('lang_mod_stocktake', 'Inventarisasi Koleksi');
define('lang_mod_stocktake_status', 'Status');
define('lang_mod_stocktake_history', 'Rekaman Inventarisasi');
define('lang_mod_stocktake_history_titletag', 'Rekaman Inventarisasi Koleksi');
define('lang_mod_stocktake_current', 'Inventarisasi Aktif');
define('lang_mod_stocktake_current_titletag', 'Lihat Proses Inventarisasi Koleksi Aktif');
define('lang_mod_stocktake_report', 'Laporan Inventarisasi');
define('lang_mod_stocktake_report_titletag', 'Lihat Laporan Proses Inventarisasi Koleksi Aktif');
define('lang_mod_stocktake_init', 'Inisialisasi/Mulai');
define('lang_mod_stocktake_init_titletag', 'Memulai Proses Inventarisasi Koleksi Baru');
define('lang_mod_stocktake_finish', 'Selesaikan Inventarisasi');
define('lang_mod_stocktake_finish_titletag', 'Selesaikan Proses Inventarisasi Aktif');
define('lang_mod_stocktake_lost', 'Koleksi Hilang');
define('lang_mod_stocktake_lost_titletag', 'Daftar Koleksi Hilang pada Proses Inventarisasi Koleksi Aktif');
define('lang_mod_stocktake_log', 'Log Inventarisasi');
define('lang_mod_stocktake_log_titletag', 'Lihat Log dari Proses Inventarisasi Aktif');
define('lang_mod_stocktake_resync', 'Sinkronisasi Ulang');
define('lang_mod_stocktake_resync_titletag', 'Sinkronisasi ulang data bibliografi dengan proses inventarisasi aktif');
# initialization
define('lang_mod_stocktake_init_info', 'Sudah ada proses Inventarisasi Koleksi yang sedang berjalan!');
define('lang_mod_stocktake_init_alert_noempty', 'Nama/Kode Inventarisasi koleksi tidak boleh kosong!');
define('lang_mod_stocktake_init_alert_started', 'Inisialisasi Inventarisasi Koleksi Berhasil');
define('lang_mod_stocktake_init_alert_fail_start', 'GAGAL Inisialisasi Inventarisasi Koleksi.\nTidak ada item untuk di inventarisasi!');
define('lang_mod_stocktake_init_button_start', 'Inisialisasi Sekarang');
define('lang_mod_stocktake_init_field_name', 'Nama/Kode Inventariasi');
define('lang_mod_stocktake_init_field_GMD', 'GMD');
define('lang_mod_stocktake_init_field_colltype', 'Jenis Kolesksi');
define('lang_mod_stocktake_init_field_location', 'Lokasi');
define('lang_mod_stocktake_init_field_site', 'Lokasi Rak');
define('lang_mod_stocktake_init_field_classification', 'Klasifikasi');
define('lang_mod_stocktake_init_field_class_text', 'Pisahkan setiap kelas dengan tanda koma. Gunakan * sebagai wildcard');
define('lang_mod_stocktake_init_field_option_all', 'SEMUA');
define('lang_mod_stocktake_init_field_start_date', 'Tgl Mulai');
define('lang_mod_stocktake_init_field_end_date', 'Tgl Selesai');
define('lang_mod_stocktake_init_field_report_file', 'Laporan');
define('lang_mod_stocktake_init_field_user', 'Yang Meng-inisialisasi');
#report
define('lang_mod_stocktake_report_page_title', 'Laporan Inventarisasi Koleksi');
define('lang_mod_stocktake_report_not_initialize', 'BELUM ADA proses inventarisasi koleksi yang telah diinisialisasi!');
define('lang_mod_stocktake_report_no_process', 'TIDAK ADA proses inventarisasi yang sedang berjalan!');
define('lang_mod_stocktake_alert_process_finish', 'Proses Inventarisasi Koleksi Selesai!');

/* REPORTING MODULE */
# submenu
define('lang_mod_report', 'Pelaporan');
define('lang_mod_report_stat', 'Statistik Koleksi');
define('lang_mod_report_stat_titletag', 'Tampilkan statistik koleksi perpustakaan');
define('lang_mod_report_loan', 'Laporan Peminjaman');
define('lang_mod_report_loan_titletag', 'Tampilkan laporan peminjaman perpustakaan');
define('lang_mod_report_member', 'Laporan Anggota');
define('lang_mod_report_member_titletag', 'Tampilkan laporan keanggotaan perpustakaan');
# General Statistic
define('lang_mod_report_stat_page_head', 'Laporan Statistik Koleksi Perpustakaan');
define('lang_mod_report_stat_table_head', 'Statistik Koleksi');
define('lang_mod_report_stat_field_title', 'Total Judul');
define('lang_mod_report_stat_field_items', 'Total Item/Kopi');
define('lang_mod_report_stat_field_onloan', 'Total Item Dipinjam');
define('lang_mod_report_stat_field_available', 'Total Item Dalam Koleksi');
define('lang_mod_report_stat_field_by_gmd', 'Total Judul Menurut Media/GMD');
define('lang_mod_report_stat_field_by_colltype', 'Total Item Menurut Jenis Koleksi');
define('lang_mod_report_stat_field_title_topten', '10 Judul Terpopuler');
# Loan Statistic
define('lang_mod_report_loan_page_head', 'Laporan Peminjaman Perpustakaan');
define('lang_mod_report_loan_table_head', 'Statistik Peminjaman');
define('lang_mod_report_loan_field_total', 'Total Peminjaman');
define('lang_mod_report_loan_field_transaction', 'Total Transsaksi Peminjaman');
define('lang_mod_report_loan_field_perday', 'Rata-Rata Transaksi Per Hari');
define('lang_mod_report_loan_field_peak', 'Transaksi Tertinggi Dalam Sehari');
define('lang_mod_report_loan_field_member_with_loan', 'Anggota Yang Meminjam');
define('lang_mod_report_loan_field_member_no_loan', 'Anggota Belum Pernah Meminjam');
define('lang_mod_report_loan_field_overdue', 'Total Peminjaman Terlambat');
define('lang_mod_report_loan_field_by_gmd', 'Total Judul Menurut Media/GMD');
define('lang_mod_report_loan_field_by_colltype', 'Total Item Menurut Jenis Koleksi');
# Member Statistic
define('lang_mod_report_member_page_head', 'Laporan Keanggotaan Perpustakaan');
define('lang_mod_report_member_table_head', 'Statistik Keanggotaan');
define('lang_mod_report_member_field_registered', 'Total Anggota Terdaftar');
define('lang_mod_report_member_field_active', 'Total Anggota Yang Aktif');
define('lang_mod_report_member_field_active_topten', '10 Anggota Paling Aktif');
define('lang_mod_report_member_field_by_type', 'Jumlah Anggota Menurut Jenis Keanggotaan');
define('lang_mod_report_member_field_expired', 'Total Keanggotaan Kedaluarsa');

/* SERIAL CONTROL MODULE */
# submenu
define('lang_mod_serial', 'Terbitan Berseri');
define('lang_mod_serial_subscription', 'Berlangganan');
define('lang_mod_serial_subscription_titletag', 'Data Berlangganan Terbitan Berseri');
define('lang_mod_serial_kardex', 'Kardesk');
define('lang_mod_serial_kardex_titletag', 'Data Kardesk');
# subcription menu
define('lang_mod_serial_subscription_add', 'Tambah Data Berlangganan');
define('lang_mod_serial_subscription_list', 'Lihat Data Berlangganan');
# kardex menu
define('lang_mod_serial_kardex_add', 'Tambahkan Kardex');
define('lang_mod_serial_kardex_view', 'Lihat Data Kardex');
# fields
define('lang_mod_serial_field_date_start', 'Mulai Berlangganan');
define('lang_mod_serial_field_exemplar', 'Eksemplar Yang Diharapkan');
define('lang_mod_serial_field_period', 'Nama Periode Langganan');
define('lang_mod_serial_field_notes', 'Catatan');
define('lang_mod_serial_kardex_field_date_expected', 'Tgl. Harus Terima');
define('lang_mod_serial_kardex_field_date_received', 'Tgl. Diterima');
define('lang_mod_serial_kardex_field_seq_number', 'Nomor Urut');
define('lang_mod_serial_kardex_field_notes', 'Catatan');
# messages
define('lang_mod_circ_common_serial_alert_01', 'Error memasukan data berlangganan, Tanggal berlangganan harus diisikan!');
define('lang_mod_serial_subscription_alert_delete_ok', 'Data Langganan berhasil dihapus');
define('lang_mod_serial_subscription_alert_delete_failed', 'Data Langganan GAGAL dihapus!');
define('lang_mod_serial_alert_02', 'Data Kardeks tersimpan!');
define('lang_mod_serial_alert_03', 'Data Kardeks berhasil dihapus!');
define('lang_mod_serial_alert_new_added', 'Data Berlangganan baru berhasil disimpan');
define('lang_mod_serial_alert_fail_to_save', 'Data Berlangganan GAGAL disimpan. Harap hubungi Administrator sistem');
define('lang_mod_serial_alert_updated', 'Data Berlangganan berhasil diperbarui');
define('lang_mod_serial_alert_not_updated', 'Data Berlangganan GAGAL diperbarui. Harap hubungi Administrator sistem');
define('lang_mod_serial_alert_not_exists', 'Error! Data Berlangganan tidak ditemukan!');
define('lang_mod_serial_common_info', 'Anda akan Mengubah data Berlangganan  : ');
?>
