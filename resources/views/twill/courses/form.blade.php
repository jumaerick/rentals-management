@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
    ])

<x-twill::multi-select
    name="domain_experience_id"
    label="Domain Field"
    :options="$domains"
    :selected="$selectedDomainIds"
/>


    <x-twill::multi-select
        name="skill_level_id"
        label="Skill Level"
        :options="$skillsLevels"
        :selected="$item->skill_level_id ?? []"
    />

    <x-twill::multi-select
        name="interest_id"
        label="Topics of Interest"
        :options="$interests"
        :selected="$item->interest_id ?? []"
    />

    <x-twill::multi-select
        name="learning_goal_id"
        label="Learning Goals"
        :options="$learningGoals"
        :selected="$item->learning_goal_id ?? []"
    />
@endsection
