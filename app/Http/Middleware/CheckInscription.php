<?php

namespace App\Http\Middleware;

use App\Enums\InscriptionStatus;
use App\Models\Inscription;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckInscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $eventId = $request->route('eventId');
        $userId = auth()->id();
        $dataUser = User::find(auth()->id());

        if ($dataUser->hasPermissionTo('admin')) {
            return $next($request);
        }

        $inscription = Inscription::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->where('status', InscriptionStatus::L->name)
            ->first();

        if (!$inscription) {
            throw new HttpException(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
