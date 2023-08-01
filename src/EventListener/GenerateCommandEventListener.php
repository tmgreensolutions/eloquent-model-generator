<?php

namespace Krlove\EloquentModelGenerator\EventListener;

use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use Illuminate\Console\Events\CommandStarting;
use Jsor\Doctrine\PostGIS\Types\GeographyType;
use Jsor\Doctrine\PostGIS\Types\GeometryType;
use Krlove\EloquentModelGenerator\TypeRegistry;

class GenerateCommandEventListener
{
    private const SUPPORTED_COMMANDS = [
        'krlove:generate:model',
        'krlove:generate:models',
    ];

    public function __construct(private TypeRegistry $typeRegistry) {
        Type::addType('cInt4', IntegerType::class);
        Type::addType('cRaster', StringType::class);
        Type::addType('cGeometry', GeometryType::class);
        Type::addType('cGeography', GeographyType::class);
    }

    public function handle(CommandStarting $event): void
    {
        if (!in_array($event->command, self::SUPPORTED_COMMANDS)) {
            return;
        }

        $userTypes = config('eloquent_model_generator.db_types', []);
        foreach ($userTypes as $type => $value) {
            $this->typeRegistry->registerType($type, $value);
        }
    }
}