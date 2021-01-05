<?php

return [
    /*
     * Default table attributes when generating the table.
     */
    'table' => [
        'class' => 'bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs dataTable dtr-inline',
        'id'    => 'crudTable',
    ],

    /*
     * Default condition to determine if a parameter is a callback or not.
     * Callbacks needs to start by those terms or they will be casted to string.
     */    
    'callback' => ['$', '$.', 'function'],

    /*
     * Html builder script template.
     */
    'script' => 'datatables::script',

    /*
     * Html builder script template for DataTables Editor integration.
     */
    'editor' => 'datatables::editor',
];
