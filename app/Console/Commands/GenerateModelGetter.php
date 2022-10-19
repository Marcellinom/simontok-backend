<?php

namespace App\Console\Commands;

use Barryvdh\Reflection\DocBlock;
use Barryvdh\Reflection\DocBlock\Serializer as DocBlockSerializer;
use File;
use Illuminate\Console\Command;
use ReflectionClass;
use function app_path;
use function explode;
use function preg_replace;
use function scandir;
use function str_replace;
use function strtolower;
use function substr;

class GenerateModelGetter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate model getter by column name and type';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \ReflectionException
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        // loop semua model dalam App/Models
        foreach (scandir(app_path('Models')) as $class) {
            if ($class === '.' || $class === '..' || $class === 'Shared') continue;
            $reflection_class = new ReflectionClass($class_name = substr('App\\Models\\'.$class, 0, -4));
            $php_docs = new DocBlock($reflection_class, new DocBlock\Context($reflection_class->getNamespaceName()));

            // loop untuk menghapus getter lama
            foreach ($php_docs->getTags() as $tag) {
                if ($tag instanceof DocBlock\Tag\MethodTag) {
                    // getMethodName jadi get_method_name
                    $method_name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $tag->getMethodName()));
                    $action = explode('_', $method_name, 2)[0];

                    if ($action === 'get' or $action === 'is' or $action === 'set') $php_docs->deleteTag($tag);
                }
            }
            // loop properties untuk menambah getter dan setter baru
            foreach ($class_name::ATTRIBUTES as $atr => $type) {
                $cammelCaseMethod = str_replace('_', '', ucwords($atr, '_'));
                $type = explode('|', $type);
                // getter
                $method = $type[0] === 'bool' ? "is$cammelCaseMethod" : "get$cammelCaseMethod";
                $php_docs->appendTag(DocBlock\Tag::createInstance("@method $type[0] $method()", $php_docs));

                // setter
                $method = "set$cammelCaseMethod";
                $param = isset($type[1]) ? "$$atr = $type[1]" : "$$atr";
                $php_docs->appendTag(DocBlock\Tag::createInstance("@method void $method($type[0] $param)", $php_docs));
            }
            // nulis docs barunya
            $content = File::get($reflection_class->getFileName());
            $serializer = new DocBlockSerializer();
            $new_doc = $serializer->getDocComment($php_docs);
            $content = str_replace($reflection_class->getDocComment(), $new_doc, $content);
            File::put($reflection_class->getFileName(), $content);
        }
        return Command::SUCCESS;
    }
}
