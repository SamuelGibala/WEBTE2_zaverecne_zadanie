<?php
function parseLatexFile($filename) {
    // 1. Load the LaTeX file
    $content = file_get_contents($filename);

    // 2. Define regular expressions
    $taskRegex = '/\\\\begin\{task\}(.*?)\\\\includegraphics\{(.*?)\}.*?\\\\end\{task\}/s';
    $solutionRegex = '/\\\\begin\{equation\*?\}(.*?)\\\\end\{equation\*?\}/s';

    // 3. Get all matches
    preg_match_all($taskRegex, $content, $taskMatches);
    preg_match_all($solutionRegex, $content, $solutionMatches);

    // Clean up the matches
    $tasks = array_map('trim', $taskMatches[1]);
    $imgs = array_map('trim', $taskMatches[2]);
    $equations = array_map('trim', $solutionMatches[1]);
    $imgs = removeEmptyElements($imgs);
    if (count($imgs) > 0) {
        $imgs = parsePaths($imgs);
    }
    echo json_encode($imgs) . PHP_EOL;
    // 4. Return the results
    return [
        'tasks' => $tasks,
        'images' => $imgs,
        'equations' => $equations
    ];
}

function parsePaths($paths) {
    $parsedArray = array();

    foreach ($paths as $path) {
        $parts = explode('/', $path);
        $object = end($parts);
        $parsedArray[] = $object;
    }

    return $parsedArray;
}

function removeEmptyElements($array) {
    $result = array();

    foreach ($array as $value) {
        if (trim($value) !== "") {
            $result[] = $value;
        }
    }

    return $result;
}

function getRandomTask($filename){
    $countFiles = count($filename);
    echo $countFiles . PHP_EOL;
    $random = rand(0,$countFiles-1);
    echo $random . PHP_EOL;
    $file_name = $filename[$random];
    $file_name = "./zadania/testy/" . $file_name;
    echo $file_name . PHP_EOL;
    $tasks = parseLatexFile($file_name);
    $tasksCount = count($tasks['tasks']);
    echo $tasksCount . PHP_EOL;
    $task_num = rand(0,$tasksCount-1);
    echo $task_num . PHP_EOL;
    echo $tasks['tasks'][$task_num] . PHP_EOL;
    echo ($tasks['images'][$task_num]==null) . PHP_EOL;
    echo $tasks['equations'][$task_num] . PHP_EOL;
    return [
        'task' => $tasks['tasks'][$task_num],
        'image' => $tasks['images'][$task_num],
        'equation' => $tasks['equations'][$task_num]
    ];
}
