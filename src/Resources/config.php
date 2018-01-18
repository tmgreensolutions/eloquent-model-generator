<?php

return [
    'namespace'       => 'App',
    'base_class_name' => \Illuminate\Database\Eloquent\Model::class,
    'output_path'     => null,
    'no_timestamps'   => null,
    'date_format'     => null,
    'connection'      => null,
    'db_types'        => [
        'Jsor\Doctrine\PostGIS\Types\RasterType'    => 'raster',
        'Jsor\Doctrine\PostGIS\Types\GeometryType'  => 'geometry',
        'Jsor\Doctrine\PostGIS\Types\GeographyType' => 'geography',
        '_int4'                                     => 'integer',
    ],
];