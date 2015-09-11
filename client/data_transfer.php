<?php

\herosphp\core\Loader::import('tasks.DataTransferTask', IMPORT_CLIENT);
$task = new \tasks\DataTransferTask();
$task->run();
