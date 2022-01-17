<?php

$new = [
    [
        'hashtag' => 'a7e87329b5eab8578f4f1098a152d6f4',
        'title' => 'Flower',
        'order' => 3,
    ],
    [
        'hashtag' => 'b24ce0cd392a5b0b8dedc66c25213594',
        'title' => 'Free',
        'order' => 4,
    ],
    [
        'hashtag' => 'e7d31fc0602fb2ede144d18cdffd816b',
        'title' => 'Ready',
        'order' => 1,
    ],
];
$keys = array_column($new, 'order');
array_multisort($keys, SORT_DESC, $new);

echo '<pre>';
    print_r($new);
echo '</pre>';


?>