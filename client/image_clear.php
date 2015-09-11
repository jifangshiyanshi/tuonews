<?php

\herosphp\core\Loader::import('tasks.ImageTask', IMPORT_CLIENT);
$task = new \tasks\ImageTask();
$task->run();
