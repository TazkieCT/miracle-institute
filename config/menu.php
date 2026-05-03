<?php

return [

    'admin' => [

        [
            'name' => 'Dashboard',
            'route' => 'admin.dashboard',
            'permission' => null,
        ],

        [
            'name' => 'Users',
            'route' => 'admin.users',
            'permission' => 'manage_users',
        ],

        [
            'name' => 'Courses',
            'route' => 'admin.courses',
            'permission' => 'manage_courses',
        ],

        [
            'name' => 'Topics',
            'route' => 'admin.topics',
            'permission' => 'manage_topics',
        ],

        [
            'name' => 'Assessments',
            'route' => 'admin.assessments',
            'permission' => 'manage_assessments',
        ],

        [
            'name' => 'Certificates',
            'route' => 'admin.certificates',
            'permission' => 'manage_certificates',
        ],

        [
            'name' => 'Reports',
            'route' => 'admin.reports',
            'permission' => 'view_reports',
        ],
    ],

];