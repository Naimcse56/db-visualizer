<?php

namespace Naimul\DbVisualizer\Repositories;

use Illuminate\Support\Facades\File;

class ModelRepository
{
    /**
     * Get all models (App + Modules)
     */
    public function all()
    {
        return array_merge(
            $this->getAppModels(),
            $this->getModuleModels()
        );
    }

    /**
     * App\Models থেকে models load
     */
    protected function getAppModels()
    {
        $models = [];
        $path = app_path('Models');

        if (!is_dir($path)) {
            return [];
        }

        foreach (File::allFiles($path) as $file) {

            $class = $this->getClassFromFile($file, 'App\\Models');

            if ($class && class_exists($class)) {
                $models[] = $class;
            }
        }

        return $models;
    }

    /**
     * Modules থেকে models load (nwidart)
     */
    protected function getModuleModels()
    {
        $models = [];
        $modulesPath = base_path('Modules');

        if (!is_dir($modulesPath)) {
            return [];
        }

        $modules = scandir($modulesPath);

        foreach ($modules as $module) {

            if ($module === '.' || $module === '..') continue;

            $moduleBase = $modulesPath . DIRECTORY_SEPARATOR . $module;

            // Entities path
            $entitiesPath = $moduleBase . DIRECTORY_SEPARATOR . 'Entities';

            if (is_dir($entitiesPath)) {
                foreach (File::allFiles($entitiesPath) as $file) {

                    $class = $this->getClassFromFile(
                        $file,
                        "Modules\\{$module}\\Entities"
                    );

                    if ($class && class_exists($class)) {
                        $models[] = $class;
                    }
                }
            }

            // Optional: Models folder (some projects use it)
            $modelsPath = $moduleBase . DIRECTORY_SEPARATOR . 'Models';

            if (is_dir($modelsPath)) {
                foreach (File::allFiles($modelsPath) as $file) {

                    $class = $this->getClassFromFile(
                        $file,
                        "Modules\\{$module}\\Models"
                    );

                    if ($class && class_exists($class)) {
                        $models[] = $class;
                    }
                }
            }
        }

        return $models;
    }

    /**
     * Convert file → full class name
     */
    protected function getClassFromFile($file, $baseNamespace)
    {
        $filename = $file->getFilenameWithoutExtension();

        return $baseNamespace . '\\' . $filename;
    }
}