<?php

namespace App\Services\Subjects;

use Illuminate\Http\Request;

interface SubjectServiceInterface
{
    public function getAllSubjects(Request $request): array;

    public function addNewSubject(Request $request): array;

    public function updateSubject(Request $request, int $subjectId): array;

    public function deleteSubject(int $subjectId): array;

    public function getActiveSubjects(): array;
}
