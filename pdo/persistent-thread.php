<?php

require __DIR__ . '/bootstrap.php';

if (!extension_loaded('pthreads')) {
    die("Extension pthreads is not loaded\n");
}

$threads = [];
$threadsCount = 2;

for ($i = 0; $i < $threadsCount; $i++) {
    $thread = new MyThread();
    $threads[] = $thread;
    $thread->start();
}

foreach ($threads as $thread) {
    $thread->join();
}

class MyThread extends \Thread
{
    public function run()
    {
        for ($j = 0; $j < 3; $j++) {
            $conn = getConnection();
            echo sprintf("Thread #%d connection ID: %d\n", $this->getThreadId(), $conn->getID());
        }
    }
}