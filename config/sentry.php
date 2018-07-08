<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN', 'https://b8aa8a46e793436885598609749d6876:803fa5f399be4309926bafb0b9bc9a2f@sentry.io/1221084'),

    // capture release as git sha
    'release' => '', //trim(exec('git log --pretty="%h" -n1 HEAD')),

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    // Capture default user context
    'user_context' => false,
];
