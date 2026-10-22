<?php
declare(strict_types=1);

function practical13_students(): array
{
    $students = [
        ['Aarav Sharma', 'CSE', 'active'],
        ['Aditi Mehta', 'IT', 'active'],
        ['Ananya Patel', 'CE', 'active'],
        ['Arjun Nair', 'CSE', 'active'],
        ['Diya Shah', 'IT', 'active'],
        ['Ishaan Verma', 'CE', 'active'],
        ['Kabir Rao', 'CSE', 'active'],
        ['Kiara Desai', 'IT', 'active'],
        ['Mira Iyer', 'CE', 'active'],
        ['Neel Joshi', 'CSE', 'active'],
        ['Nisha Kapoor', 'IT', 'active'],
        ['Rohan Gupta', 'CE', 'active'],
        ['Sana Khan', 'CSE', 'active'],
        ['Tara Menon', 'IT', 'active'],
        ['Vihaan Reddy', 'CE', 'active'],
        ['Zoya Ali', 'CSE', 'active'],
        ['Dev Malhotra', 'IT', 'active'],
        ['Ira Kulkarni', 'CE', 'active'],
        ['Reyansh Sethi', 'CSE', 'active'],
        ['Myra Fernandes', 'IT', 'active'],
        ['Advait Bose', 'CE', 'active'],
        ['Pari Chawla', 'CSE', 'active'],
        ['Kian Thomas', 'IT', 'inactive'],
        ['Riya Banerjee', 'CE', 'inactive'],
    ];

    $records = [];
    foreach ($students as $index => [$name, $department, $status]) {
        $nameParts = explode(' ', strtolower($name));
        $emailName = implode('.', $nameParts);
        $records[] = [
            'id' => sprintf('STU-2026-%03d', $index + 1),
            'name' => $name,
            'email' => $emailName . '@campusly.demo',
            'department' => $department,
            'status' => $status,
        ];
    }

    return $records;
}
