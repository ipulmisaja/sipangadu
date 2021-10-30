<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ModelMakeCommand as Command;

class ModelMakeCommand extends Command
{
     /**
      * Mendapatkan default namespace dari class.
      *
      * @param string $rootNamespace
      * @return string
      */
      public function getDefaultNamespace($rootNamespace)
      {
         return "{$rootNamespace}\Models";
      }
}
