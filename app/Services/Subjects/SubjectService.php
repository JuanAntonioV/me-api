<?php

namespace App\Services\Subjects;

use App\Helpers\ResponseHelper;
use App\Repository\Subjects\SubjectRepoInterface;
use App\Validators\SubjectValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectService implements SubjectServiceInterface
{
    protected SubjectRepoInterface $subjectRepo;

    protected SubjectValidator $subjectValidator;

    public function __construct(SubjectRepoInterface $subjectRepo, SubjectValidator $subjectValidator)
    {
        $this->subjectRepo = $subjectRepo;
        $this->subjectValidator = $subjectValidator;
    }

    public function getAllSubjects(Request $request): array
    {
        try {
            $search = $request->input('search');
            $subjects = $this->subjectRepo->getAllSubjects($search);

            if ($subjects->isEmpty()) return ResponseHelper::notFound('Mata pelajaran tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan semua mata pelajaran', $subjects);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function addNewSubject($request): array
    {
        $validator = $this->subjectValidator->validateAddSubjectInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $name = $request->input('subject_name');
            $description = $request->input('description');

            $this->subjectRepo->insertSubject($name, $description);

            DB::commit();
            return ResponseHelper::success('Berhasil menambahkan mata pelajaran baru');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function updateSubject($request, $subjectId): array
    {
        $validator = $this->subjectValidator->validateSubjectInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();

        try {
            $name = $request->input('subject_name');
            $description = $request->input('description');
            $status = $request->input('status');

            $subject = $this->subjectRepo->getSubjectById($subjectId);

            if (!$subject) return ResponseHelper::notFound('Mata pelajaran tidak ditemukan');

            $this->subjectRepo->updateSubject($subjectId, $name, $description, $status);

            DB::commit();
            return ResponseHelper::success('Berhasil mengubah mata pelajaran');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function deleteSubject($subjectId): array
    {

        DB::beginTransaction();
        try {
            $subject = $this->subjectRepo->getSubjectById($subjectId);

            if (!$subject) return ResponseHelper::notFound('Mata pelajaran tidak ditemukan');

            $this->subjectRepo->deleteSubject($subjectId);

            DB::commit();
            return ResponseHelper::success('Berhasil menghapus mata pelajaran');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getActiveSubjects(): array
    {
        try {
            $subjects = $this->subjectRepo->getActiveSubjects();

            if ($subjects->isEmpty()) return ResponseHelper::notFound('Mata pelajaran tidak ditemukan');

            return ResponseHelper::success('Berhasil mendapatkan semua mata pelajaran', $subjects);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}
