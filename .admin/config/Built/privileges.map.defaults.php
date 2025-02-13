<?php

/**
 *  Defaults action to privileges mapping
 */

return [
    "action" =>
    [
        "list" => 'r',
        "view" => 'r',
        "create" => 'a',
        "update" => 'w',
        "delete" => 'd',
        "file" => 'a',
        "upload" => 'a'
    ],
    "exclude" => [
        "/",
        "Authy/auth",
        "Authy/reset",
        "Authy/login",
        "Authy/logout",
        "GuiManager"
    ]

];
