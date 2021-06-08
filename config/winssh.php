<?php

return [
    'host' => env('SSH_WIN_HOST'),
    'public_key' => env('SSH_WIN_PUB_KEY'),
    'password'=>env('SSH_WIN_PWD'),
    'command' => env('SSH_WIN_PY_EXE')
];
