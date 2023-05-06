<?php

namespace App\Services\Auth;

use App\Entities\NotificationEntities;
use App\Entities\RoleEntities;
use App\Helpers\ResponseHelper;
use App\Repository\Auth\AuthRepoInterface;
use App\Repository\Notifications\NotificationRepoInterface;
use App\Repository\Users\UserRepoInterface;
use App\Validators\AuthValidator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthService implements AuthServiceInterface
{
    private AuthValidator $authValidator;
    private AuthRepoInterface $authRepo;

    private UserRepoInterface $userRepo;

    private NotificationRepoInterface $notificationRepo;

    public function __construct(AuthValidator     $authValidator, AuthRepoInterface $authRepo,
                                UserRepoInterface $userRepo, NotificationRepoInterface $notificationRepo)
    {
        $this->authValidator = $authValidator;
        $this->authRepo = $authRepo;
        $this->userRepo = $userRepo;
        $this->notificationRepo = $notificationRepo;
    }

    public function register($request): array
    {
        $validator = $this->authValidator->validateRegisterInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $fullName = $request->input('full_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $role = RoleEntities::GUEST_ROLE;

            $userId = $this->authRepo->registerUser($fullName, $email, $password, $role);

            $notificationData = [
                $userId,
                'Selamat datang di aplikasi',
                'Halo, ' . $fullName . ' Selamat datang di mafia education, pilih kelas yang kamu inginkan dan mulai belajar sekarang',
                NotificationEntities::TYPE_GENERAL
            ];

            $this->notificationRepo->createUserNotification(...$notificationData);

            DB::commit();
            return ResponseHelper::success('Berhasil mendaftarkan user');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function login($request): array
    {
        $validator = $this->authValidator->validateLoginInput($request);

        if ($validator) return $validator;

        DB::beginTransaction();
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = $this->authRepo->getUserByEmail($email);

            if (!$user) return ResponseHelper::success('Akun kamu telah dinonaktifkan sementara, Silahkan hubungi admin untuk mengaktifkan kembali');

            if (!Hash::check($password, $user->password)) return ResponseHelper::error(
                'Email atau password salah',
                null,
                ResponseAlias::HTTP_UNAUTHORIZED
            );

            $userData = $this->userRepo->getUserDetailByUserId($user->id);

            $token = $user->createToken('auth_token')->plainTextToken;

            $data = [
                'token' => $token,
                'user' => $userData
            ];

            DB::commit();
            return ResponseHelper::success('Berhasil login', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function logout($request): array
    {
        DB::beginTransaction();
        try {
            $request->user()->currentAccessToken()->delete();

            DB::commit();
            return ResponseHelper::success('Berhasil logout');
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::serverError($e->getMessage());
        }
    }

    public function getUser($request): array
    {
        try {
            $userId = $request->user()->id;
            $userData = $this->userRepo->getUserDetailByUserId($userId);
            return ResponseHelper::success('Berhasil mengambil data user', $userData);
        } catch (\Exception $e) {
            return ResponseHelper::serverError($e->getMessage());
        }
    }
}