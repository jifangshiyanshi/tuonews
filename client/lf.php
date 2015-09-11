<?php

\herosphp\core\Loader::import('tasks.LFTask', IMPORT_CLIENT);
$task = new \tasks\LFTask();
$task->run();