<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;

use App\Models\Resource;
use App\Models\ResourceTag;
use App\Models\Tag;

class ObjectDetection implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project_path;

    protected $image_path;

    protected $resource;

    protected $coco_names = [
        "человек", "велосипед", "автомобиль", "мотоцикл", "самолет",
        "автобус", "поезд", "грузовик", "лодка", "светофор",
        "пожарный гидрант", "дорожный знак", "стоп-знак",
        "парковочный счетчик", "скамейка", "птица", "кот", "собака",
        "лошадь", "овца", "корова", "слон", "медведь", "зебра", "жираф",
        "шляпа", "рюкзак", "зонтик", "обувь", "очки", "сумка", "галстук",
        "чемодан", "фрисби", "лыжи", "сноуборд", "спортивный мяч",
        "воздушный змей", "бейсбольная бита", "бейсбольная перчатка",
        "скейтборд", "серфборд", "теннисная ракетка", "бутылка", "тарелка",
        "бокал для вина", "чашка", "вилка", "нож", "ложка", "миска", "банан",
        "яблоко", "бутерброд", "апельсин", "брокколи", "морковь", "хот-дог",
        "пицца", "пончик", "торт", "стул", "диван", "горшок с растением",
        "кровать", "зеркало", "обеденный стол", "окно", "письменный стол",
        "туалет", "дверь", "телевизор", "ноутбук", "мышь", "пульт управления",
        "клавиатура", "мобильный телефон", "микроволновая печь", "духовка",
        "тостер", "раковина", "холодильник", "блендер", "книга", "часы", "ваза",
        "ножницы", "мягкая игрушка", "фен", "зубная щетка", "расческа"
    ];

    /**
     * Create a new job instance.
     */
    public function __construct($resource_id)
    {
        $this->project_path = base_path();
        $resource = Resource::find($resource_id);
        $this->image_path = $resource->path;
        $this->resource = $resource;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $script_path = 'storage\app\py_scripts\SSD_OD\main.py';
        $image_path = base_path('storage\\app\\public\\' . $this->image_path);
        $indexes = shell_exec("python {$script_path} {$image_path}");
        // Tag::create([
        //     'name' => json_encode($indexes)
        // ]);
        preg_match_all('/\d+/', $indexes, $matches);

        // Получаем массив чисел из строки      
        $numbers = $matches[0];

        // Преобразуем числа из строки в числа
        $indexes = array_map('intval', $numbers);
        $count = count($indexes);
        // Проходим по каждому индексу из $indexes и добавляем соответствующее слово в массив $words
        foreach ($indexes as $index) {
            // Если индекс есть в словаре, добавляем соответствующее слово в массив $words
            if (isset($this->coco_names[$index])) {
                $tag = Tag::firstOrCreate([
                    'name' => $this->coco_names[$index]
                ]);
                $this->resource->tags()->attach($tag->id, ['resource_id' => $this->resource->id]);
            }
        }
        
        

    }
}
