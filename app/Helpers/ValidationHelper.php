<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ValidationHelper
{
    const  VALIDATION_MESSAGES = [
        'password.exists' => ':attribute atau password salah',
        'email.exists' => 'email atau password salah',
        'subject_name.unique' => 'mata pelajaran sudah terdaftar',
        '*.required' => ':attribute tidak boleh kosong',
        '*.string' => ':attribute tidak valid',
        '*.exists' => ':attribute tidak terdaftar',
        '*.unique' => ':attribute sudah terdaftar',
        '*.min' => ':attribute minimal :min karakter',
        '*.max' => ':attribute maksimal :max karakter',
        '*.numeric' => ':attribute harus berupa angka',
        '*.email' => ':attribute harus berupa email',
        '*.date' => ':attribute harus berupa tanggal',
        '*.date_format' => ':attribute harus berupa tanggal dengan format :format',
        '*.in' => ':attribute harus berupa salah satu dari :values',
        '*.mimes' => ':attribute harus berupa file dengan tipe :values',
        '*.image' => ':attribute harus berupa gambar',
        '*.dimensions' => ':attribute harus berupa gambar dengan dimensi :width x :height',
        '*.regex' => ':attribute tidak valid',
        '*.confirmed' => ':attribute tidak sama dengan konfirmasi :attribute',
        '*.after' => ':attribute harus berupa tanggal setelah :date',
        '*.before' => ':attribute harus berupa tanggal sebelum :date',
        '*.after_or_equal' => ':attribute harus berupa tanggal setelah atau sama dengan :date',
        '*.before_or_equal' => ':attribute harus berupa tanggal sebelum atau sama dengan :date',
        '*.different' => ':attribute harus berupa nilai yang berbeda dengan :other',
        '*.digits' => ':attribute harus berupa angka dengan panjang :digits digit',
        '*.digits_between' => ':attribute harus berupa angka dengan panjang antara :min dan :max digit',
        '*.distinct' => ':attribute tidak boleh memiliki nilai yang sama',
        '*.file' => ':attribute harus berupa file',
        '*.filled' => ':attribute harus diisi',
        '*.gt' => ':attribute harus berupa angka yang lebih besar dari :value',
        '*.gte' => ':attribute harus berupa angka yang lebih besar atau sama dengan :value',
        '*.lt' => ':attribute harus berupa angka yang lebih kecil dari :value',
        '*.lte' => ':attribute harus berupa angka yang lebih kecil atau sama dengan :value',
        '*.not_in' => ':attribute tidak boleh berupa salah satu dari :values',
        '*.not_regex' => ':attribute tidak valid',
        '*.present' => ':attribute harus ada',
        '*.required_if' => ':attribute tidak boleh kosong jika :other adalah :value',
        '*.required_unless' => ':attribute tidak boleh kosong kecuali :other adalah :values',
        '*.required_with' => ':attribute tidak boleh kosong jika :values ada',
        '*.required_with_all' => ':attribute tidak boleh kosong jika :values ada',
        '*.required_without' => ':attribute tidak boleh kosong jika :values tidak ada',
        '*.required_without_all' => ':attribute tidak boleh kosong jika :values tidak ada',
        '*.same' => ':attribute harus sama dengan :other',
        '*.size' => ':attribute harus berupa angka dengan panjang :size digit',
        '*.timezone' => ':attribute harus berupa zona waktu yang valid',
        '*.url' => ':attribute harus berupa URL yang valid',
        '*.alpha' => ':attribute harus berupa huruf',
        '*.alpha_dash' => ':attribute harus berupa huruf, angka, strip, dan garis bawah',
        '*.alpha_num' => ':attribute harus berupa huruf dan angka',
        '*.array' => ':attribute harus berupa array',
        '*.boolean' => ':attribute harus berupa boolean',
    ];

    public function getValidationResponse($validator): bool|array
    {
        if ($validator->fails()) {
            return ResponseHelper::error(
                $validator->errors()->first(),
                $validator->errors(),
                ResponseAlias::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return false;
    }
}
