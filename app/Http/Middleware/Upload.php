<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use Closure;
class Upload
{
    public function handle($request, Closure $next)
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        }

        config([
            'filesystems.default'                                               => (UtilityFacades::getsettings('storage_type') != '') ? UtilityFacades::getsettings('storage_type') : 'local',
            'filesystems.disks.s3.key'                                          => UtilityFacades::getsettings('s3_key'),
            'filesystems.disks.s3.secret'                                       => UtilityFacades::getsettings('s3_secret'),
            'filesystems.disks.s3.region'                                       => UtilityFacades::getsettings('s3_region'),
            'filesystems.disks.s3.bucket'                                       => UtilityFacades::getsettings('s3_bucket'),
            'filesystems.disks.s3.url'                                          => UtilityFacades::getsettings('s3_url'),
            'filesystems.disks.s3.endpoint'                                     => UtilityFacades::getsettings('s3_endpoint'),

            'filesystems.disks.wasabi.key'                                      => UtilityFacades::getsettings('wasabi_key'),
            'filesystems.disks.wasabi.secret'                                   => UtilityFacades::getsettings('wasabi_secret'),
            'filesystems.disks.wasabi.region'                                   => UtilityFacades::getsettings('wasabi_region'),
            'filesystems.disks.wasabi.bucket'                                   => UtilityFacades::getsettings('wasabi_bucket'),
            'filesystems.disks.wasabi.endpoint'                                 => UtilityFacades::getsettings('wasabi_root'),
        ]);
        return $next($request);
    }
}
