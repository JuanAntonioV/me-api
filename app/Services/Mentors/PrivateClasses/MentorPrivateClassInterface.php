<?php

namespace App\Services\Mentors\PrivateClasses;

use Illuminate\Http\Request;

interface MentorPrivateClassInterface
{
    public function getMentorPrivateClasses(Request $request): array;

    public function addMentorPrivateClass(Request $request): array;

    public function editMentorPrivateClass(int $privateClassId, Request $request): array;

    public function changeMentorPrivateClassStatus(int $privateClassId, Request $request): array;

    public function deleteMentorPrivateClass(int $privateClassId): array;

    public function getMentorPrivateClassDetails(int $privateClassId): array;
}
