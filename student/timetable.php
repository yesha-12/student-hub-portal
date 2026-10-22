<?php
require_once __DIR__ . '/../includes/portal-auth.php';
require_portal_role('student');
$pageTitle = 'Weekly timetable';
$pageEyebrow = 'Plan your week';
$pageSubtitle = 'Use this sample timetable as a guide. Your official class schedule is managed by your department.';
$pageStats = [
    ['value' => 'Mon–Fri', 'label' => 'weekdays'],
    ['value' => 'Sample', 'label' => 'schedule view'],
    ['value' => 'Check', 'label' => 'with your department'],
];
$pageNotice = 'This is a sample schedule view. Confirm your current class times with your department before making plans.';
$pageCards = [
    ['title' => 'Course materials', 'description' => 'Open your learning resources and course guidance.', 'href' => 'student/material.php', 'label' => 'View materials'],
    ['title' => 'Student dashboard', 'description' => 'Return to your account and student hub links.', 'href' => 'student/dashboard.php', 'label' => 'Dashboard'],
];
$pagePrimaryAction = ['href' => 'student/dashboard.php', 'label' => 'Back to dashboard'];
$pageExtraFile = __DIR__ . '/../includes/timetable-view.php';
require __DIR__ . '/../includes/portal-page.php';
