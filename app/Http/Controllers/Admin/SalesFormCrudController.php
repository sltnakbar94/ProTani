<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SalesFormRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use App\Models\SalesForm;
use App\Jobs\ProcessResizeFormImage;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use App\User;
use Auth;
use Illuminate\Http\Request;
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
        $this->crud->enableExportButtons();

         $this->crud->addColumn([
            'name' => 'user_id',
            'label' => 'Nama Surveyor',
            'type' => 'relationship',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => 'App\Models\User'
        ]);

        $this->crud->addColumn([
            'name' => 'surveyor_phone_number',
            'label' => 'No.Tlp Surveyor',
            'type' => 'relationship',
            'entity' => 'user',
            'attribute' => 'phone',
            'model' => 'App\Models\User'
        ]);

        $this->crud->addColumn([
            'name' => 'survey_date',
            'type' => 'date',
            'label' => 'Tanggal Survey'
        ]);

        $this->crud->addColumn([
            'name' => 'farmer_name',
            'label' => "Nama Pelaku Utama",
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'id_address',
            'label' => "Jalan",
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'rt',
            'label' => "RT",
            'type' => 'number'
        ]);

        $this->crud->addColumn([
            'name' => 'rw',
            'label' => "RW",
            'type' => 'number'
        ]);

        $this->crud->addColumn([
            'name' => 'village_id',
            'label' => "Kel/Desa",
            'type' => 'relationship',
            'entity' => 'village',
            'attribute' => 'name',
            'model' => 'App\Models\Village'
        ]);

        $this->crud->addColumn([
            'name' => 'district_id',
            'label' => "Kec",
            'type' => 'relationship',
            'entity' => 'district',
            'attribute' => 'name',
            'model' => 'App\Models\District'
        ]);

        $this->crud->addColumn([
            'name' => 'regency_id',
            'label' => "Kab/Kota",
            'type' => 'relationship',
            'entity' => 'regency',
            'attribute' => 'name',
            'model' => 'App\Models\Regency'
        ]);

        $this->crud->addColumn([
            'name' => 'province_id',
            'label' => "Provinsi",
            'type' => 'relationship',
            'entity' => 'province',
            'attribute' => 'name',
            'model' => 'App\Models\Province'
        ]);

        $this->crud->addColumn([
            'name' => 'id_number',
            'label' => "NIK",
            'type' => 'number',
        ]);

        $this->crud->addColumn([
            'name' => 'phone_number',
            'label' => "Nomor HP Petani",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'site_address',
            'label' => "Alamat Kolam",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'rt_pool',
            'label' => "RT Kolam",
            'type' => 'number',
        ]);

        $this->crud->addColumn([
            'name' => 'rw_pool',
            'label' => "RW Kolam",
            'type' => 'number',
        ]);

        $this->crud->addColumn([
            'name'     => 'pool_village_id',
            'label'    => 'Kel/Desa Lokasi Kolam',
            'type'     => 'text',
        ]);

        // $this->crud->addColumn([
        //     'name'     => 'pool_village_id',
        //     'label'    => 'Kel/Desa Lokasi Kolam',
        //     'type'     => 'closure',
        //     'function' => function($entry) {
        //         if (!empty($entry->pool_village_id)) {
        //             return Village::find($entry->pool_village_id)->name;
        //         } else {
        //             return "-";
        //         }
        //     }
        // ],);

        $this->crud->addColumn([
            'name'     => 'pool_district_id',
            'label'    => 'Kec Lokasi Kolam',
            'type'     => 'closure',
            'function' => function($entry) {
                if (!empty($entry->pool_district_id)) {
                    return District::find($entry->pool_district_id)->name;
                } else {
                    return "-";
                }
            }
        ],);

        $this->crud->addColumn([
            'name'     => 'pool_regency_id',
            'label'    => 'Kab/Kota Lokasi Kolam',
            'type'     => 'closure',
            'function' => function($entry) {
                if (!empty($entry->pool_regency_id)) {
                    return Regency::find($entry->pool_regency_id)->name;
                } else {
                    return "-";
                }
            }
        ],);

        $this->crud->addColumn([
            'name'     => 'pool_province_id',
            'label'    => 'Provinsi Lokasi Kolam',
            'type'     => 'closure',
            'function' => function($entry) {
                if (!empty($entry->pool_province_id)) {
                    return Province::find($entry->pool_province_id)->name;
                } else {
                    return "-";
                }

            }
        ],);

        // $this->crud->addColumn([
        //     'name'     => 'pool_district_id',
        //     'label'    => 'Kec Lokasi Kolam',
        //     'type'     => 'text',
        // ]);

        // $this->crud->addColumn([
        //     'name'     => 'pool_regency_id',
        //     'label'    => 'Kab/Kota Lokasi Kolam',
        //     'type'     => 'text',
        // ]);

        // $this->crud->addColumn([
        //     'name'     => 'pool_province_id',
        //     'label'    => 'Provinsi Lokasi Kolam',
        //     'type'     => 'text',
        //     ]);

        $this->crud->addColumn([
                'name' => 'pokdakan_name',
                'label' => "Nama Kelompok Pembudidaya Ikan(POKDAKAN)",
                'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'position_in_organization',
            'label' => "Posisi Dikelompok",
            'type' => 'text',
        ]);

         $this->crud->addColumn([
            'name' => 'lenght_effort',
            'label' => "Lama Usaha",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_type',
            'label' => "Jenis Ikan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'pool_area',
            'label' => "Luas Lahan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'pool_type',
            'label' => "Jenis Kolam",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_mantaince_period',
            'label' => "Masa Pemeliharaan Ikan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'yields',
            'label' => "Hasil Panen/Kg",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_sell_to',
            'label' => "Penjualan Hasil Ikan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_food_brand',
            'label' => "Merk Pakan Ikan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_food_type',
            'label' => "Tipe Pakan Ikan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_food_retrieval_system',
            'label' => "Sistem Pengambilan Pakan Ikan",
            'type' => 'text',
        ]);

        $this->crud->addColumn([
            'name' => 'fish_food_price',
            'label' => "Harga Pakan Ikan/Kg",
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'fish_food_needs',
            'label' => "Kebutuhan Pakan/Siklus",
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'payment_method',
            'label' => 'Sistem Pembayaran Pakan Ikan',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'source_fund' ,
            'label' => 'Sumber Modal Usaha',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'fish_seed_source' ,
            'label' => 'Asal Benih Ikan',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'harvest_cost' ,
            'label' => 'Biaya Panen',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'harvest_method',
            'label' => 'Proses Panen',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'description',
            'label' => "Catatan",
            'type' => 'textarea',
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
        $this->crud->removeSaveActions(['save_and_preview','save_and_edit']);

        $this->crud->addField([
            'name' => 'user_id',
            'type' => 'hidden',
            'value' => Auth::id()
        ]);

        $this->crud->addField([
            'name' => 'surveyor_phone_number',
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
            'label'           => "Nama Pelaku Utama",
            'type'            => 'text',
        ]);

        $this->crud->addField([
            'name'            => 'id_address',
            'label'           => "Jalan",
            'type'            => 'text',
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
            'label'           => "Kota/Kab",
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

        // $this->crud->addField([
        //     'name'            => 'village_id',
        //     'label'           => "Kel/Desa",
        //     'type'            => 'select2_from_ajax',
        //     'entity'          => 'village',
        //     'attribute'       => 'name',
        //     'placeholder'     => 'Pilih Kelurahan',
        //     'minimum_input_length' => 0,
        //     'data_source'     => url('api/village'),
        //     'model'           => 'App\Models\Village',
        //     'dependencies'    => ['district_id'] ,
        //     'include_all_form_fields' => true,
        // ]);

        $this->crud->addField([
            'name'            => 'village_id',
            'label'           => "Kel/Desa",
            'type'            => 'text',
            // 'entity'          => 'village',
            // 'attribute'       => 'name',
            // 'placeholder'     => 'Pilih Kelurahan',
            // 'minimum_input_length' => 0,
            // 'data_source'     => url('api/village'),
            // 'model'           => 'App\Models\Village',
            // 'dependencies'    => ['district_id'] ,
            // 'include_all_form_fields' => true,
        ]);

        $this->crud->addField([
            'name'            => 'id_number',
            'label'           => "NIK",
            'type'            => 'number',
        ]);

        $this->crud->addField([
            'name'            => 'phone_number',
            'label'           => "Nomor HP Petani",
            'type'            => 'text',
            'hint'            => '08XXXXXXXXXX',
        ]);

        $this->crud->addField([
            'name'            => 'site_address',
            'label'           => "Alamat Kolam",
            'type'            => 'text',
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
            'data_source'     => url('api/province2'),
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
            'data_source'     => url('api/regency2'),
            'model'           => 'App\Models\Regency',
            'dependencies'    => ['pool_province_id'],
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
            'data_source'     => url('api/district2'),
            'model'           => 'App\Models\District',
            'dependencies'    => ['pool_regency_id'] ,
            'include_all_form_fields' => true,
        ]);

        // $this->crud->addField([
        //     'name'            => 'pool_village_id',
        //     'label'           => "Kel/Desa Alamat Kolam",
        //     'type'            => 'select2_from_ajax',
        //     'entity'          => 'village',
        //     'attribute'       => 'name',
        //     'placeholder'     => 'Pilih Kelurahan',
        //     'minimum_input_length' => 0,
        //     'data_source'     => url('api/village2'),
        //     'model'           => 'App\Models\Village',
        //     'dependencies'    => ['pool_district_id'] ,
        //     'include_all_form_fields' => true,
        // ]);

        // $this->crud->addField([
        //     'name'            => 'pool_province_id',
        //     'label'           => "Provinsi Alamat Kolam",
        //     'type'            => 'text',
        // ]);

        // $this->crud->addField([
        //     'name'            => 'pool_regency_id',
        //     'label'           => "Kota/Kab Alamat Kolam",
        //     'type'            => 'text',
        // ]);

        // $this->crud->addField([
        //     'name'            => 'pool_district_id',
        //     'label'           => "Kecamatan Alamat Kolam",
        //     'type'            => 'text',
        // ]);

        $this->crud->addField([
            'name'            => 'pool_village_id',
            'label'           => "Kel/Desa Alamat Kolam",
            'type'            => 'text',
        ]);

        $this->crud->addField([
            'name'            => 'pool_qty',
            'label'           => "Jumlah Kolam",
            'type'            => 'number',
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
            'label'           => "Lama Usaha",
            'type'            => 'select_from_array',
            'options'         => [
                "0-1 Tahun" =>"0-1 Tahun" ,
                "1-5 Tahun" =>"1-5 Tahun" ,
                ">5 Tahun" => ">5 Tahun"
            ]
        ]);

        $this->crud->addField([
                'name'        => 'fish_type',
                'label'       => "Jenis Ikan",
                'type'        => 'select2_from_array',
                'options'     => [
                    'Nila' => 'Nila',
                    'Lele' => 'Lele',
                    'Gurame' => 'Gurame',
                    'Emas' => 'Emas',
                    'Koi' => 'Koi',
                    'Bawal' => 'Bawal',
                    'Baster' => 'Baster',
                    'Lain-Lain' => 'Lain-Lain'
                ],
                'allows_null' => false,
                'allows_multiple' => true
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
                '1000m-1HA' => '1000m-1HA',
                '>1HA' => '>1HA',
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
            'label'           => "Hasil Panen/Kg",
            'type'            => 'select_from_array',
            'options'         => [
                '100-250kg' => '100-250kg' ,
                '250-500kg' => '250-500kg' ,
                '500-750kg' => '500-750kg' ,
                '750-1000kg'=> '750-1000kg',
                '> 1 Ton'  => '> 1 Ton',
                'Lain-Lain'  => 'Lain-Lain'
            ]
        ]);

        $this->crud->addField([
            'name'            => 'fish_sell_to',
            'label'           => 'Penjualan Hasil Ikan' ,
            'type'            => 'select_from_array' ,
            'options'         => [
                'Perusahaan' => 'Perusahaan' ,
                'Tengkulak'  => 'Tengkulak' ,
                'Masyarakat Sekitar' => 'Masyarakat Sekitar' ,
                'Lain-Lain '  => 'Lain-Lain'
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
                'Lain-Lain'      => 'Lain-Lain'
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
                '>3mm'        => '>3mm'
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
                '5.000-10.000'    => '5.000-10.000',
                '10.000-12.000'   =>  '10.000-12.000',
                '> 12000'       => '> 12.000',
                'Lain-Lain' => 'Lain-Lain'
            ]
        ]);

        $this->crud->addField([
            'name'           => 'fish_food_needs',
            'label'          => "Kebutuhan Pakan/Siklus",
            'type'           => 'select_from_array' ,
            'options'        => [
                '100-250kg' => '100-250kg',
                '250-500kg' => '250-500kg',
                '500-1000kg'=> '500-1000kg',
                '> 1 Ton'   => '> 1 Ton'
            ]
        ]);

        $this->crud->addField([
            'name'          => 'payment_method',
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
                'Lain-Lain'    => 'Lain-Lain'
            ]
        ]);

        $this->crud->addField([
            'name'      => 'fish_seed_source' ,
            'label'     => 'Asal Benih Ikan',
            'type'      => 'select_from_array',
            'options'   => [
                'Lokal/Sukabumi'  => 'Lokal/Sukabumi' ,
                'Luar Sukabumi' => 'Luar Sukabumi' ,
                'Lain-Lain'    => 'Lain-lain'
            ]
        ]);

        $this->crud->addField([
            'name'      => 'harvest_cost' ,
            'label'     => 'Biaya Panen',
            'type'      => 'select_from_array' ,
            'options'   => [
                '<1.000.000'           => '<1.000.000' ,
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
                'Lain-Lain'        => 'Lain-lain'
            ]
        ]);

        $this->crud->addField([
            'name'            => 'description',
            'label'           => "Catatan",
            'type'            => 'textarea',
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

    public function store(Request $request)
    {
        // dd($request->all());
        $data = new SalesForm();
        $data->user_id = $request->user_id;
        $data->surveyor_phone_number = $request->surveyor_phone_number;
        $data->survey_date = $request->survey_date;
        $data->farmer_name = $request->farmer_name;
        $data->id_address = $request->id_address;
        $data->rt = $request->rt;
        $data->rw = $request->rw;
        $data->province_id = $request->province_id;
        $data->regency_id = $request->regency_id;
        $data->district_id = $request->district_id;
        $data->village_id = $request->village_id;
        $data->id_number = $request->id_number;
        $data->phone_number = $request->phone_number;
        $data->site_address = $request->site_address;
        $data->rt_pool = $request->rt_pool;
        $data->rw_pool = $request->rw_pool;
        $data->pool_province_id = $request->pool_province_id;
        $data->pool_regency_id = $request->pool_regency_id;
        $data->pool_district_id = $request->pool_district_id;
        $data->pool_village_id = $request->pool_village_id;
        $data->pool_qty = $request->pool_qty;
        $data->pokdakan_name = $request->pokdakan_name;
        $data->position_in_organization = $request->position_in_organization;
        $data->lenght_effort = $request->lenght_effort;
        $data->fish_type = $request->fish_type;
        $data->pool_area = $request->pool_area;
        $data->pool_type = $request->pool_type;
        $data->fish_mantaince_period = $request->fish_mantaince_period;
        $data->yields = $request->yields;
        $data->fish_sell_to = $request->fish_sell_to;
        $data->fish_food_brand = $request->fish_food_brand;
        $data->fish_food_type = $request->fish_food_type;
        $data->fish_food_retrieval_system = $request->fish_food_retrieval_system;
        $data->fish_food_price = $request->fish_food_price;
        $data->fish_food_needs = $request->fish_food_needs;
        $data->payment_method = $request->payment_method;
        $data->source_fund = $request->source_fund;
        $data->fish_seed_source = $request->fish_seed_source;
        $data->harvest_cost = $request->harvest_cost;
        $data->harvest_method = $request->harvest_method;
        $data->description = $request->description;
        // dd($request->all());
        $data->save();
        return redirect(backpack_url('salesform'));

    }
}
