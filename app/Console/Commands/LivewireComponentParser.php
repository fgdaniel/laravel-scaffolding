<?php

namespace App\Console\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use function Livewire\str;

class LivewireComponentParser
{
    protected $appPath;
    protected $viewPath;
    protected $component;
    protected $componentClass;
    protected $directories;

    public function __construct($classNamespace, $viewPath, $type, $rawCommand)
    {

		$this->type = $type;
        $this->baseClassNamespace = $classNamespace;
        $this->baseTestNamespace = 'Tests\Feature\Livewire';

        $classPath = static::generatePathFromNamespace($classNamespace);
        $testPath = static::generateTestPathFromNamespace($this->baseTestNamespace);

        $this->baseClassPath = rtrim($classPath, DIRECTORY_SEPARATOR).'/';
        $this->baseViewPath = rtrim($viewPath, DIRECTORY_SEPARATOR).'/';
        $this->baseTestPath = rtrim($testPath, DIRECTORY_SEPARATOR).'/';

        $directories = preg_split('/[.\/(\\\\)]+/', $rawCommand);

        $camelCase = str(array_pop($directories))->camel();
        $kebabCase = str($camelCase)->kebab();

        $this->component = $kebabCase;
        $this->componentClass = str($this->component)->studly();

        $this->directories = array_map([Str::class, 'studly'], $directories);
    }

    public function component()
    {
        return $this->component;
    }

    public function classPath()
    {
        return $this->baseClassPath.collect()
            ->concat($this->directories)
            ->push($this->classFile())
            ->implode('/');
    }

    public function relativeClassPath() : string
    {
        return str($this->classPath())->replaceFirst(base_path().DIRECTORY_SEPARATOR, '');
    }

    public function classFile()
    {
        return $this->componentClass.'.php';
    }

    public function classNamespace()
    {
        return empty($this->directories)
            ? $this->baseClassNamespace
            : $this->baseClassNamespace.'\\'.collect()
                ->concat($this->directories)
                ->map([Str::class, 'studly'])
                ->implode('\\');
    }

    public function className()
    {
        return $this->componentClass;
    }

    public function classContents($inline = false)
    {
        $stubName = $inline ? 'livewire.inline.stub' : 'livewire.stub';

        if(File::exists($stubPath = base_path('stubs/'.$stubName))) {
            $template = file_get_contents($stubPath);
        } else {
            $template = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.$stubName);
        }

        if ($inline) {
            $template = preg_replace('/\[quote\]/', $this->wisdomOfTheTao(), $template);
        }

        return preg_replace_array(
            ['/\[namespace\]/', '/\[class\]/', '/\[view\]/'],
            [$this->classNamespace(), $this->className(), $this->viewName()],
            $template
        );
    }

    public function viewPath()
    {
        return $this->baseViewPath.collect()
            ->concat($this->directories)
            ->map([Str::class, 'kebab'])
            ->push($this->viewFile())
            ->implode(DIRECTORY_SEPARATOR);
    }

    public function relativeViewPath() : string
    {
        return str($this->viewPath())->replaceFirst(base_path().'/', '');
    }

    public function viewFile()
    {
        return $this->component.'.blade.php';
    }

    public function viewName()
    {
		if($this->type == 'dash') {
			$collect = collect()
			->concat(explode('/',str($this->baseViewPath)->after(resource_path('dashboard/views'))))
			->filter()
			->concat($this->directories)
			->map([Str::class, 'kebab'])
			->push($this->component)
			->implode('.');
			return 'dashboard::' . $collect;
		} else {
			$collect = collect()
			->concat(explode('/',str($this->baseViewPath)->after(resource_path('frontend/views'))))
			->filter()
			->concat($this->directories)
			->map([Str::class, 'kebab'])
			->push($this->component)
			->implode('.');
			return $collect;
		}
    }

    public function viewContents()
    {
        if( ! File::exists($stubPath = base_path('stubs/livewire.view.stub'))) {
            $stubPath = __DIR__.DIRECTORY_SEPARATOR.'stubs\livewire.view.stub';
        }

        return preg_replace(
            '/\[quote\]/',
            $this->wisdomOfTheTao(),
            file_get_contents($stubPath)
        );
    }

    public function testNamespace()
    {
        return empty($this->directories)
            ? $this->baseTestNamespace
            : $this->baseTestNamespace.'\\'.collect()
                ->concat($this->directories)
                ->map([Str::class, 'studly'])
                ->implode('\\');
    }

    public function testClassName()
    {
        return $this->componentClass.'Test';
    }

    public function testFile()
    {
        return $this->componentClass.'Test.php';
    }

    public function testPath()
    {
        return $this->baseTestPath.collect()
        ->concat($this->directories)
        ->push($this->testFile())
        ->implode('/');
    }

    public function relativeTestPath() : string
    {
        return str($this->testPath())->replaceFirst(base_path().'/', '');
    }

    public function testContents()
    {
        $stubName = 'livewire.test.stub';

        if(File::exists($stubPath = base_path('stubs/'.$stubName))) {
            $template = file_get_contents($stubPath);
        } else {
            $template = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.$stubName);
        }

        return preg_replace_array(
            ['/\[testnamespace\]/', '/\[classwithnamespace\]/', '/\[testclass\]/', '/\[class\]/'],
            [$this->testNamespace(), $this->classNamespace() . '\\' . $this->className(), $this->testClassName(), $this->className()],
            $template
        );
    }

    public function wisdomOfTheTao()
    {
        return Arr::random([
			'Because she competes with no one, no one can compete with her.',
			'The best athlete wants his opponent at his best.',
			'Nothing in the world is as soft and yielding as water.',
			'Be like water.',
			'In work, do what you enjoy.',
			'Care about people\'s approval and you will be their prisoner.',
			'Do your work, then step back.',
			'Success is as dangerous as failure.',
			'The Master doesn\'t talk, he acts.',
			'A good traveler has no fixed plans and is not intent upon arriving.',
			'Knowing others is intelligence; knowing yourself is true wisdom.',
			'If your happiness depends on money, you will never be happy with yourself.',
			'If you look to others for fulfillment, you will never truly be fulfilled.',
			'To attain knowledge, add things every day; To attain wisdom, subtract things every day.',
			'Close your eyes. Count to one. That is how long forever feels.',
			'The whole world belongs to you.',
			'Stop trying to control.',
		]);
    }

    public static function generatePathFromNamespace($namespace)
    {
        $name = str($namespace)->finish('\\')->replaceFirst(app()->getNamespace(), '');
        return app('path').'/'.str_replace('\\', '/', $name);
    }

    public static function generateTestPathFromNamespace($namespace)
    {
        return str(base_path($namespace))
            ->replace('\\', '/', $namespace)
            ->replaceFirst('T', 't');
    }
}
