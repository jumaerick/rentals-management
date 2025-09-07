@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])

@formField('multi_select', [

    'name' => 'sectors',

    'label' => 'Sectors',

    'min' => 1,

    'max' => 2,

    'options' => [

        [

            'value' => 'arts',

            'label' => 'Arts & Culture'

        ],

        [

            'value' => 'finance',

            'label' => 'Banking & Finance'

        ],

        [

            'value' => 'civic',

            'label' => 'Civic & Public'

        ],

        [

            'value' => 'design',

            'label' => 'Design & Architecture'

        ],

        [

            'value' => 'education',

            'label' => 'Education'

        ]

    ]

])
    @formField('select', [
        'name' => 'admin_role',
        'label' => 'Administrative Role',
        'options'=>collect($adminRoleList),
    ])

    @formField('date_picker', [
        'name' => 'published_at',
        'label' => 'Publish date',
    ])
@endsection
