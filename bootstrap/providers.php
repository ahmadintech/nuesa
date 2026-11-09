<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;
use Barryvdh\DomPDF\ServiceProvider as DomPDFServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    DomPDFServiceProvider::class,
    PermissionServiceProvider::class,
];
