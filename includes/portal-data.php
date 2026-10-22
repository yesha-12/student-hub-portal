<?php
declare(strict_types=1);

function campusly_events(): array
{
    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'events.json';
    if (is_file($path)) {
        $events = json_decode((string) file_get_contents($path), true);
        if (is_array($events)) {
            return $events;
        }
        throw new RuntimeException('The campus events data could not be read.');
    }

    return [
        [
            'id' => 'welcome-week',
            'title' => 'Welcome week social',
            'category' => 'Community',
            'date' => date('Y-m-d', strtotime('+3 days')),
            'time' => '3:00 PM',
            'location' => 'Student commons',
            'description' => 'Meet fellow students, explore campus clubs, and kick off the semester together.',
        ],
        [
            'id' => 'study-jam',
            'title' => 'Library study jam',
            'category' => 'Academic',
            'date' => date('Y-m-d', strtotime('+6 days')),
            'time' => '5:30 PM',
            'location' => 'Central library',
            'description' => 'Settle in for a focused group study session with quiet zones and peer support.',
        ],
        [
            'id' => 'green-campus',
            'title' => 'Green campus volunteer day',
            'category' => 'Volunteer',
            'date' => date('Y-m-d', strtotime('+10 days')),
            'time' => '9:00 AM',
            'location' => 'North courtyard',
            'description' => 'Help care for shared campus spaces and meet students passionate about sustainability.',
        ],
    ];
}
