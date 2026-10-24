<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Route middleware. Forms: 'auth', 'guest', 'can:permission.slug'.
 */
final class Middleware
{
    public static function apply(string $rule): void
    {
        [$name, $arg] = array_pad(explode(':', $rule, 2), 2, null);

        match ($name) {
            'auth'  => self::auth(),
            'guest' => self::guest(),
            'can'   => self::can((string)$arg),
            default => null,
        };
    }

    private static function auth(): void
    {
        if (Auth::check()) {
            // A temporary password must be replaced before anything else.
            if (Auth::mustChangePassword() && !str_starts_with(Request::path(), '/admin/password')
                && Request::path() !== '/admin/logout') {
                Flash::warning('Please choose a new password before continuing.');
                View::redirect('admin/password');
            }
            return;
        }
        if (Session::pull('_expired')) {
            Flash::warning('Your session expired due to inactivity. Please sign in again.');
        } else {
            Flash::info('Please sign in to continue.');
        }
        View::redirect('admin/login');
    }

    private static function guest(): void
    {
        if (Auth::check()) {
            View::redirect('admin');
        }
    }

    private static function can(string $permission): void
    {
        self::auth();
        if (Auth::can($permission)) {
            return;
        }
        Audit::log('access.denied', null, null, 'Missing permission: ' . $permission);
        self::forbidden();
    }

    private static function forbidden(): void
    {
        http_response_code(403);
        View::render('errors/error', [
            'code'    => 403,
            'message' => 'You are not authorised to view this page.',
        ], 'admin');
        exit;
    }
}
