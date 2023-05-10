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

    // 4. Return the results
    return [
        'tasks' => $tasks,
        'images' => $imgs,
        'equations' => $equations
    ];
}

function getRandomTask($filename){
    $tasks = parseLatexFile($filename);
    $tasksCount = count($tasks['tasks']);
    $task_num = rand(0,$tasksCount);
    return [
        'task' => $tasks['tasks'][$task_num],
        'image' => $tasks['images'][$task_num],
        'equation' => $tasks['equations'][$task_num]
    ];
}
