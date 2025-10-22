<?php 

namespace App\Service;

use App\Models\Course;

class RecommendationEngine
{
    public function recommendCourses($user)
    {
        $courses = Course::with(['domainFields', 'skillLevelFields', 'interestFields', 'learningGoalFields'])->get();
        $recommendations = [];

        foreach ($courses as $course) {
            $score = 0;
            $reasons = [];
// dd($user->interestFields);
            // Domain overlap
            $sharedDomains = $course->domainFields->pluck('id')->intersect($user->domainFields->pluck('id'));
            if ($sharedDomains->isNotEmpty()) {
                $score += $sharedDomains->count() * 2; // domains are important
                $reasons[] = 'similar domain(s)';
            }

            // Interest overlap
            $sharedInterests = $course->interestFields->pluck('id')->intersect($user->interestFields->pluck('id'));
            if ($sharedInterests->isNotEmpty()) {
                $score += $sharedInterests->count() * 1.5;
                $reasons[] = 'matches your interest';
            }

            // Learning goal overlap
            $sharedGoals = $course->learningGoalFields->pluck('id')->intersect($user->learningGoalFields->pluck('id'));
            if ($sharedGoals->isNotEmpty()) {
                $score += $sharedGoals->count();
                $reasons[] = 'fits your learning goals';
            }

            //Skill level (assuming single)
            $sharedSkills = $course->skillLevelFields->pluck('id')->intersect($user->skillLevelFields->pluck('id'));
            if ($sharedSkills->isNotEmpty()) {
                $score += $sharedSkills->count();
                $reasons[] = 'fits your skill levels';
            }

            if ($score > 0) {
                $recommendations[] = [
                    'course' => $course,
                    'score' => $score,
                    'reasons' => implode(', ', $reasons),
                ];
            }
        }

        // Sort by score descending

        usort($recommendations, fn($a, $b) => $b['score'] <=> $a['score']);
        // Filter out recommendations with less than 2 reasons
        $recommendations = array_filter($recommendations, function($recommendation) {
            return count(explode(',', $recommendation['reasons'])) >= 2;
        });

        // dd($recommendations);
        return $recommendations;
    }
}