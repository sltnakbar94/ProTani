<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SalesFormRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use App\Models\SalesForm;
use App\Jobs\ProcessResizeFormImage;
use App\User;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

/**
 * Class SalesFormCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SalesFormCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\SalesForm::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/salesform');
        CRUD::setEntityNameStrings('Data', 'Tambah Data');
        // $this->crud->setShowView('order.show');
    }

    

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        

         $this->crud->addColumn([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => Auth::id()
        ]);

        $this->crud->addColumn([
            'name' => 'suveyor_phone_number',
            'type' => 'hidden',
            'value' => Auth::user()->phone
        ]);

        $this->crud->addColumn([
            'name' => 'survey_date',
            'type' => 'date',
            'label' => 'Tanggal Survey'
        ]);

        $this->crud->addColumn([
            'name'            => 'farmer_name',
            'label'           => "Nama pelaku utama",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'id_number',
            'label'           => "Nomor KTP",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'phone_number',
            'label'           => "Nomor HP Petani",
            'type'            => 'text',
            'hint'            => '08XXXXXXXXXX',
        ]);

        $this->crud->addColumn([
            'name'            => 'province_id',
            'label'           => "Provinsi",
            'type'            => 'select2_from_ajax',
            'entity'          => 'province',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Provinsi',
            'minimum_input_length' => 0,
            'data_source'     => url('api/province'),
            'model'           => 'App\Models\Province',
        ]);

        $this->crud->addColumn([
            'name'            => 'regency_id',
            'label'           => "Kota",
            'type'            => 'select2_from_ajax',
            'entity'          => 'regency',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kab/Kota',
            'minimum_input_length' => 0,
            'data_source'     => url('api/regency'),
            'model'           => 'App\Models\Regency',
            'dependencies'    => ['province_id'],
            'include_all_form_fields' => true,
        ]);

        $this->crud->addColumn([
            'name'            => 'district_id',
            'label'           => "Kecamatan",
            'type'            => 'select2_from_ajax',
            'entity'          => 'district',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kecamatan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/district'),
            'model'           => 'App\Models\District',
            'dependencies'    => ['regency_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addColumn([
            'name'            => 'village_id',
            'label'           => "Kel/Desa",
            'type'            => 'select2_from_ajax',
            'entity'          => 'village',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kelurahan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/village'),
            'model'           => 'App\Models\Village',
            'dependencies'    => ['district_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addColumn([
            'name'            => 'rt',
            'label'           => "RT",
            'type'            => 'number',
        ]);

        $this->crud->addColumn([
            'name'            => 'rw',
            'label'           => "RW",
            'type'            => 'number',
        ]);

        $this->crud->addColumn([
            'name'            => 'id_address',
            'label'           => "Alamat",
            'type'            => 'text',
        ]);

        // $this->crud->addColumn([
        //     'label' => "Foto",
        //     'name' => "idpict",
        //     'type' => 'image',
        //     'crop' => true, // set to true to allow cropping, false to disable
        //     'upload' => true,
        //     'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
        //     'disk'      => 'public', // in case you need to show images from a different disk
        //     // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        // ]);

        $this->crud->addColumn([
            'name'            => 'site_address',
            'label'           => "Alamat Kolam",
            'type'            => 'address_algolia',
        ]);

        $this->crud->addColumn([
            'name'            => 'rt_pool',
            'label'           => "RT",
            'type'            => 'number',
        ]);

        $this->crud->addColumn([
            'name'            => 'rw_pool',
            'label'           => "RW",
            'type'            => 'number',
        ]);
        
        $this->crud->addColumn([
            'name'            => 'pool_province_id',
            'label'           => "Provinsi Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'province',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Provinsi',
            'minimum_input_length' => 0,
            'data_source'     => url('api/province'),
            'model'           => 'App\Models\Province',
        ]);

        $this->crud->addColumn([
            'name'            => 'pool_regency_id',
            'label'           => "Kota Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'regency',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kab/Kota',
            'minimum_input_length' => 0,
            'data_source'     => url('api/regency'),
            'model'           => 'App\Models\Regency',
            'dependencies'    => ['province_id'],
            'include_all_form_fields' => true,
        ]);

        $this->crud->addColumn([
            'name'            => 'pool_district_id',
            'label'           => "Kecamatan Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'district',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kecamatan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/district'),
            'model'           => 'App\Models\District',
            'dependencies'    => ['regency_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addColumn([
            'name'            => 'pool_village_id',
            'label'           => "Kel/Desa Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'village',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kelurahan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/village'),
            'model'           => 'App\Models\Village',
            'dependencies'    => ['district_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addColumn([
            'name'            => 'pokdakan_name',
            'label'           => "Nama Kelompok Pembudidaya Ikan(POKDAKAN)",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'position_in_organization',
            'label'           => "Posisi Dikelompok",
            'type'            => 'text',
        ]);

         $this->crud->addColumn([
            'name'            => 'lenght_effort',
            'label'           => "Lama Usaha(Bulan)",
            'type'            => 'number',
        ]);

        $this->crud->addColumn([
            'name'            => 'fish_type',
            'label'           => "Jenis Ikan",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'pool_area',
            'label'           => "Luas Lahan",
            'type'            => 'number',
        ]);

        $this->crud->addColumn([
            'name'            => 'pool_type',
            'label'           => "Jenis Kolam",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'fish_mantaince_period',
            'label'           => "Masa Pemeliharaan Ikan",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'yields',
            'label'           => "Hasil Panen Ikan/Kg",
            'type'            => 'number',
        ]);

        $this->crud->addColumn([
            'name'            => 'fish_food_brand',
            'label'           => "Merk Pakan Ikan",
            'type'            => 'text',
        ]);
        
        $this->crud->addColumn([
            'name'            => 'fish_food_type',
            'label'           => "Tipe Pakan Ikan",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'            => 'fish_food_retrieval_system',
            'label'           => "Sistem Pengambilan Pakan Ikan",
            'type'            => 'text',
        ]);

        $this->crud->addColumn([
            'name'           => 'fish_food_price',
            'label'          => "Harga Pakan Ikan/Kg",
            'type'           => 'number'
        ]);

        $this->crud->addColumn([
            'name'           => 'fish_food_needs',
            'label'          => "Kebutuhan Pakan Ikan/Kg",
            'type'           => 'number'
        ]);

        $this->crud->addColumn([
            'name'          => 'food_fish_payment_method',
            'label'         => 'Sistem Pembayaran Pakan Ikan',
            'type'          => 'text'
        ]);

        $this->crud->addColumn([
            'name'      => 'source_fund' ,
            'label'     => 'Sumber Modal Usaha',
            'type'      => 'text'
        ]);

        $this->crud->addColumn([
            'name'      => 'fish_seed_source' ,
            'label'     => 'Asal Benih Ikan',
            'type'      => 'text'
        ]);

        $this->crud->addColumn([
            'name'      => 'harvest_cost' ,
            'label'     => 'Biaya Panen',
            'type'      => 'number'
        ]);

        $this->crud->addColumn([
            'name'      => 'harvest_method',
            'label'     => 'Proses panen',
            'type'      => 'text'
        ]);

        $this->crud->addColumn([
            'name'            => 'description',
            'label'           => "Catatan",
            'type'            => 'textarea',
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SalesFormRequest::class);
        $this->crud->removeSaveActions(['save_and_back','save_and_new','save_and_edit']);

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => Auth::id()
        ]);

        $this->crud->addField([
            'name' => 'suveyor_phone_number',
            'type' => 'hidden',
            'value' => Auth::user()->phone
        ]);

        $this->crud->addField([
            'name' => 'survey_date',
            'type' => 'date',
            'label' => 'Tanggal Survey'
        ]);

        $this->crud->addField([
            'name'            => 'farmer_name',
            'label'           => "Nama pelaku utama",
            'type'            => 'text',
        ]);

        $this->crud->addField([
            'name'            => 'id_number',
            'label'           => "Nomor KTP",
            'type'            => 'text',
        ]);

        $this->crud->addField([
            'name'            => 'phone_number',
            'label'           => "Nomor HP Petani",
            'type'            => 'text',
            'hint'            => '08XXXXXXXXXX',
        ]);

        $this->crud->addField([
            'name'            => 'province_id',
            'label'           => "Provinsi",
            'type'            => 'select2_from_ajax',
            'entity'          => 'province',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Provinsi',
            'minimum_input_length' => 0,
            'data_source'     => url('api/province'),
            'model'           => 'App\Models\Province',
        ]);

        $this->crud->addField([
            'name'            => 'regency_id',
            'label'           => "Kota",
            'type'            => 'select2_from_ajax',
            'entity'          => 'regency',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kab/Kota',
            'minimum_input_length' => 0,
            'data_source'     => url('api/regency'),
            'model'           => 'App\Models\Regency',
            'dependencies'    => ['province_id'],
            'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'district_id',
            'label'           => "Kecamatan",
            'type'            => 'select2_from_ajax',
            'entity'          => 'district',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kecamatan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/district'),
            'model'           => 'App\Models\District',
            'dependencies'    => ['regency_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'village_id',
            'label'           => "Kel/Desa",
            'type'            => 'select2_from_ajax',
            'entity'          => 'village',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kelurahan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/village'),
            'model'           => 'App\Models\Village',
            'dependencies'    => ['district_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'rt',
            'label'           => "RT",
            'type'            => 'number',
        ]);

        $this->crud->addField([
            'name'            => 'rw',
            'label'           => "RW",
            'type'            => 'number',
        ]);

        $this->crud->addField([
            'name'            => 'id_address',
            'label'           => "Alamat",
            'type'            => 'text',
        ]);

        // $this->crud->addField([
        //     'label' => "Foto",
        //     'name' => "idpict",
        //     'type' => 'image',
        //     'crop' => true, // set to true to allow cropping, false to disable
        //     'upload' => true,
        //     'aspect_ratio' => 2, // omit or set to 0 to allow any aspect ratio
        //     'disk'      => 'public', // in case you need to show images from a different disk
        //     // 'prefix'    => 'uploads/images/profile_pictures/' // in case your db value is only the file name (no path), you can use this to prepend your path to the image src (in HTML), before it's shown to the user;
        // ]);

        $this->crud->addField([
            'name'            => 'site_address',
            'label'           => "Alamat Kolam",
            'type'            => 'address_algolia',
        ]);

        $this->crud->addField([
            'name'            => 'rt_pool',
            'label'           => "RT",
            'type'            => 'number',
        ]);

        $this->crud->addField([
            'name'            => 'rw_pool',
            'label'           => "RW",
            'type'            => 'number',
        ]);
        
        $this->crud->addField([
            'name'            => 'pool_province_id',
            'label'           => "Provinsi Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'province',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Provinsi',
            'minimum_input_length' => 0,
            'data_source'     => url('api/province'),
            'model'           => 'App\Models\Province',
        ]);

        $this->crud->addField([
            'name'            => 'pool_regency_id',
            'label'           => "Kota Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'regency',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kab/Kota',
            'minimum_input_length' => 0,
            'data_source'     => url('api/regency'),
            'model'           => 'App\Models\Regency',
            'dependencies'    => ['province_id'],
            'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'pool_district_id',
            'label'           => "Kecamatan Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'district',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kecamatan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/district'),
            'model'           => 'App\Models\District',
            'dependencies'    => ['regency_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'pool_village_id',
            'label'           => "Kel/Desa Alamat Kolam",
            'type'            => 'select2_from_ajax',
            'entity'          => 'village',
            'attribute'       => 'name',
            'placeholder'     => 'Pilih Kelurahan',
            'minimum_input_length' => 0,
            'data_source'     => url('api/village'),
            'model'           => 'App\Models\Village',
            'dependencies'    => ['district_id'] ,
            'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'pokdakan_name',
            'label'           => "Nama Kelompok Pembudidaya Ikan(POKDAKAN)",
            'type'            => 'text',
        ]);

        $this->crud->addField([
            'name'            => 'position_in_organization',
            'label'           => "Posisi Dikelompok",
            'type'            => 'text',
        ]);

         $this->crud->addField([
            'name'            => 'lenght_effort',
            'label'           => "Lama Usaha(Bulan)",
            'type'            => 'select_from_array',
            'options'         => [
                "0-1 Tahun" =>"0-1 Tahun" ,
                "1-5 Tahun" =>"1-5 Tahun" ,
                "> dari 5 Tahun" => "> dari 5 Tahun"
            ]
        ]);

        $this->crud->addField([
            'name'            => 'fish_type',
            'label'           => "Jenis Ikan",
            'type'            => 'text',
        ]);

        $this->crud->addField([
            'name'            => 'pool_area',
            'label'           => "Luas Lahan",
            'type'            => 'select_from_array',
            'options'         => [
                '<50m' => '<50m',
                '50m-100m' => '50m-100m' ,
                '100m-500m' => '100m-500m',
                '500m-1000m' => '500m-1000m',
            ]
        ]);

        $this->crud->addField([
            'name'            => 'pool_type',
            'label'           => "Jenis Kolam",
            'type'            => 'select_from_array',
            'options'         => [
                'Air Tenang'  => 'Air Tenang' ,
                'Air Deras'   => 'Air Deras'
            ]
        ]);

        $this->crud->addField([
            'name'            => 'fish_mantaince_period',
            'label'           => "Masa Pemeliharaan Ikan",
            'type'            => 'select_from_array',
            'options'         => [
                '1-2 Bulan' => '1-2 Bulan',
                '2-3 Bulan' => '2-3 Bulan',
                '>3 Bulan' => '>3 Bulan'
            ]  
        ]);

        $this->crud->addField([
            'name'            => 'yields',
            'label'           => "Hasil Panen Ikan/Kg",
            'type'            => 'select_from_array',
            'options'         => [
                '100-250kg' => '100-250kg' ,
                '250-500kg' => '250-500kg' ,
                '500-750kg' => '500-750kg' ,
                '750-1000kg'=> '750-1000kg',
                '> 1 Ton'  => '> 1 Ton'   
            ]
        ]);

        $this->crud->addField([
            'name'            => '',
            'label'           => 'Penjualan Hasil Ikan' ,
            'type'            => 'select_from_array' ,
            'options'         => [
                'Perusahaan' => 'Perusahaan' ,
                'Tengkulak'  => 'Tengkulak' ,
                'Masyarakat Sekitar' => 'Masyarakat Sekitar' ,
                'Others '  => 'Lain-Lain'
            ]   
        ]);

        $this->crud->addField([
            'name'            => 'fish_food_brand',
            'label'           => "Merk Pakan Ikan",
            'type'            => 'select_from_array',
            'options'         => [
                'CP-POKPHAND' => 'CP-POKPHAND' ,
                'SINTA'       => 'SINTA' ,
                'M Sakti'     => 'M Sakti' ,
                'CARGILL'     => 'CARGILL' ,
                'JAPFA'       => 'JAPFA' ,
                'Others'      => 'Lain-Lain'
            ]
        ]);
        
        $this->crud->addField([
            'name'            => 'fish_food_type',
            'label'           => "Tipe Pakan Ikan",
            'type'            => 'select_from_array',
            'options'         => [
                'Tepung'       => 'Tepung'  ,
                'Crumble'      => 'Crumble' ,
                '1-2mm'        => '1-2mm' ,
                '2-3mm'        => '2-3mm',
                '> 3mm'        => '> 3mm'
            ]
        ]);

        $this->crud->addField([
            'name'            => 'fish_food_retrieval_system',
            'label'           => "Sistem Pengambilan Pakan Ikan",
            'type'            => 'select_from_array',
            'options'         => [
                'Diambil'   => 'Diambil' ,
                'Diantar'   => 'Diantar'
            ]
        ]);

        $this->crud->addField([
            'name'           => 'fish_food_price',
            'label'          => "Harga Pakan Ikan/Kg",
            'type'           => 'select_from_array' ,
            'options'        => [
                '5000-10000'    => '5.000-10.000',
                '10000-12000'   =>  '10.000-12.000',
                '> 12000'       => '> 12.000'
            ]
        ]);

        $this->crud->addField([
            'name'           => 'fish_food_needs',
            'label'          => "Kebutuhan Pakan / Siklus",
            'type'           => 'select_from_array' ,
            'options'        => [
                '100-250kg' => '100-250kg',
                '250-500kg' => '250-500kg',
                '500-1000kg'=> '500-1000kg',
                '> 1 Ton'   => '> 1 Ton'
            ]
        ]);

        $this->crud->addField([
            'name'          => 'food_fish_payment_method',
            'label'         => 'Sistem Pembayaran Pakan Ikan',
            'type'          => 'select_from_array' ,
            'options'       => [
                'Tunai'     =>'Tunai' ,
                'Konsinyasi'=>'Konsinyasi'
            ]
        ]);

        $this->crud->addField([
            'name'      => 'source_fund' ,
            'label'     => 'Sumber Modal Usaha',
            'type'      => 'select_from_array' ,
            'options'   => [
                'Sendiri'   => 'Sendiri' ,
                'Bank'      => 'Bank' ,
                'Koperasi'  => 'Koperasi' ,
                'Others'    => 'Lain-Lain'
            ]
        ]);

        $this->crud->addField([
            'name'      => 'fish_seed_source' ,
            'label'     => 'Asal Benih Ikan',
            'type'      => 'select_from_array',
            'options'   => [
                'Lokal'  => 'Lokal' ,
                'Luar Sukabumi' => 'Luar Sukabumi' ,
                'Others'    => 'Lain-lain'
            ]
        ]);

        $this->crud->addField([
            'name'      => 'harvest_cost' ,
            'label'     => 'Biaya Panen',
            'type'      => 'select_from_array' ,
            'options'   => [
                '< 1.000.000'           => '< 1.000.000' ,
                '1.000.000 - 5.000.000' => '1.000.000 - 5.000.000' ,
                '>5.000.000'            => '>5.000.000'
            ]
        ]);

        $this->crud->addField([
            'name'      => 'harvest_method',
            'label'     => 'Proses panen',
            'type'      => 'select_from_array',
            'options'   => [
                'Tradisional'   => 'Tradisional' ,
                'Tim Panen'     => 'Tim Panen' ,
                'Others'        => 'Lain-lain'
            ]
        ]);

        $this->crud->addField([
            'name'            => 'description',
            'label'           => "Catatan",
            'type'            => 'textarea',
        ]);

        $this->crud->addField([
            'name'            => 'pool_qty',
            'label'           => "Jumlah Kolam",
            'type'            => 'number',
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
