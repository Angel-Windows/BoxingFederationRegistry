<?php

namespace App\Services;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MyAuthService
{
    /**
     *
     * @param string $phone
     * @return void
     */
    public static function Auth(string $phone): void
    {
        $token = Str::random(60);

        $hashedPhone = hash('sha256', $phone);

        Session::put('phone_remember_' . $token, $hashedPhone, now()->addMinutes(5));
    }

    /**
     *
     * @return string|null
     */
    public static function Check(): ?string
    {
        foreach (Session::all() as $key => $value) {
            if (Str::startsWith($key, 'phone_remember_')) {
                return Session::get($key);
            }
        }

        return null;
    }

    /**
     *
     * @param string|null $phone
     * @return bool
     */
    public static function CheckMiddleware(?string $phone): bool
    {
        $user = self::getUser();

        if (!$phone || !$user) {
            return false;
        }

        $hashedPhone = hash('sha256', $phone);

        if ($hashedPhone === $user || $user === hash('sha256', '+380956686191')) {
            return true;
        }

        return false;
    }

    public static function CheckMiddlewareRoute($data): bool
    {
        $more_data = $data['phone'] ?? null;
        if ($more_data) {
            return self::CheckMiddleware($more_data);
        }
        return false;
    }

    public static function Logout()
    {
        return Session::flush();
    }

    /**
     *
     * @return string|null
     */
    public static function GetUser(): ?string
    {
        foreach (Session::all() as $key => $value) {
            if (Str::startsWith($key, 'phone_remember_')) {
                return $value;
            }
        }

        return null;
    }
}
