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
        self::Logout();

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
    public static function CheckMiddleware(?string $phone = null, $class_name = null, $id = null): bool
    {
        if (!env('IS_REGISTER')) {
            return true;
        }

        $user = self::getUser();


        if (!$phone && $user){
            return true;
        }

        if ($class_name && $id){
            $register_ids = Session::get('register_ids')[$class_name];
            if (in_array($id, $register_ids)){
                return true;
            }
        }


        if (!$phone || !$user) {
            return false;
        }

        $hashedPhone = hash('sha256', $phone);

        return $hashedPhone === $user ;
//        return $hashedPhone === $user || $user === hash('sha256', '+380956686191');
    }

    public static function CheckMiddlewareRoute($data): bool
    {
        $more_data = $data['phone'] ?? null;
        $class_name = $data['class_name'] ?? null;
        $id = $data['id'] ?? null;
        if ($more_data) {
            return self::CheckMiddleware($more_data, $class_name, $id);
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
