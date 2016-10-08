<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

class EloquentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:eloquent {name : Eloquent name} {--model= : (Optional) Model name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create eloquent for model';
    
    protected $eloquentPath = 'app/Eloquents';
    private $modelPath = 'App\Models\\';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $content = '';
        $name = $this->argument('name');
        $modelName = $this->option('model');
        $eloquentPath = sprintf('%s/%s.php', trim($this->eloquentPath, '/'), $name);
        
        if($name){
            $content = $this->getContent($name, $modelName);
        }
        if(!File::isFile($eloquentPath)){
            $this->setContent($eloquentPath, $content);
        }else{
            $overideConfirm = $this->ask('Eloquent is existing, Are you sure want to override it? (y/n)');
            $yes = ['y', 'yes'];
            if(in_array(strtolower($overideConfirm), $yes)){
                $this->setContent($eloquentPath, $content);
            }
        }
    }
    
    protected function setContent($path, $content){
        File::put($path, $content);
        $this->info('Create eloquent succed');
    }
    
    protected function getContent($name, $model){
        $content = '<?php
            
                    namespace App\Eloquents;
                    
                    use App\Eloquents\BaseEloquent;
                    use Illuminate\Validation\ValidationException;
                    
                    class '.$name.' extends BaseEloquent {
                        
                        protected $model;
                        
                        public function __construct(\\'.$this->modelPath.$model.' $model) {
                            $this->model = $model;
                        }
                        
                    }';
        return $content;
    }
}
