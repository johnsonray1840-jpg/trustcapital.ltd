<?php

namespace App\Constants;

class FileInfo
{
    public function fileInfo()
    {
        $data['withdrawVerify'] = [
            'path' => 'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      => 'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      => 'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/default.png',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/logo_icon',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/extensions',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/images/user/profile',
            'size'      => '350x300',
        ];
        $data['userSignature'] = [
            'path'      => 'assets/images/user/signature',
            'size'      => '100x50',
        ];
        $data['adminProfile'] = [
            'path'      => 'assets/admin/images/profile',
            'size'      => '400x400',
        ];
        $data['push'] = [
            'path'      => 'assets/images/push_notification',
        ];
        $data['maintenance'] = [
            'path'      => 'assets/images/maintenance',
            'size'      => '660x325',
        ];
        $data['language'] = [
            'path' => 'assets/images/language',
            'size' => '50x50'
        ];
        $data['gateway'] = [
            'path' => 'assets/images/gateway',
            'size' => ''
        ];
        $data['withdrawMethod'] = [
            'path' => 'assets/images/withdraw_method',
            'size' => ''
        ];
        
        // REMOVED DUPLICATES AND FIXED projectDocuments
        $data['projectDocuments'] = [
            'path' => 'assets/files/project_documents',
            'size' => '5120', // 5MB
        ];

        $data['projectGallery'] = [
            'path'      => 'assets/images/project/gallery',
            'size'      => '840x450'
        ];
        $data['location'] = [
            'path'      => 'assets/images/location',
            'size'      => '305x395'
        ];
        
        $data['pushConfig'] = [
            'path'      => 'assets/admin',
        ];
        
        $data['founder'] = [
    'path' => 'assets/images/founder',
    'size' => '400x400',
];
        
        // REMOVED THESE DUPLICATE ENTRIES:
        // $data['withdrawVerify'] = [...]
        // $data['propertyGallery'] = [...]
        // $data['location'] = [...]
        // $data['projectDocuments'] = [...]
        // $data['pushConfig'] = [...]
        
        return $data; // ONLY ONE RETURN STATEMENT
    }
}