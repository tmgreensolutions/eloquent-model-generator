<?php

namespace Krlove\EloquentModelGenerator\Command;

use Illuminate\Console\Command;
use Illuminate\Database\DatabaseManager;
use Krlove\EloquentModelGenerator\Generator;
use Krlove\EloquentModelGenerator\Helper\Prefix;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Custom Type Definitions
 */
use Doctrine\DBAL\Types\Type;
use Jsor\Doctrine\PostGIS\Types\RasterType;
use Jsor\Doctrine\PostGIS\Types\GeometryType;
use Jsor\Doctrine\PostGIS\Types\GeographyType;

/**
 * Class GenerateModelCommand
 * @package Krlove\EloquentModelGenerator\Command
 */
class GenerateModelCommand extends Command
{
    use GenerateCommandTrait;

    protected $name = 'krlove:generate:model';

    public function __construct(private Generator $generator, private DatabaseManager $databaseManager)
    {
        parent::__construct();

        $this->generator = $generator;
        $this->appConfig = $appConfig;

        Type::addType('_int4', 'Doctrine\DBAL\Types\IntegerType');
        Type::addType('raster', 'Jsor\Doctrine\PostGIS\Types\RasterType');
        Type::addType('geometry', 'Jsor\Doctrine\PostGIS\Types\GeometryType');
        Type::addType('geography', 'Jsor\Doctrine\PostGIS\Types\GeographyType');
    }

    public function handle()
    {
        $config = $this->createConfig();
        $config->setClassName($this->argument('class-name'));
        Prefix::setPrefix($this->databaseManager->connection($config->getConnection())->getTablePrefix());

        $model = $this->generator->generateModel($config);
        $this->saveModel($model);

        $this->output->writeln(sprintf('Model %s generated', $model->getName()->getName()));
    }

    protected function getArguments()
    {
        return [
            ['class-name', InputArgument::REQUIRED, 'Model class name'],
        ];
    }

    protected function getOptions()
    {
        return $this->getCommonOptions();
    }
}
