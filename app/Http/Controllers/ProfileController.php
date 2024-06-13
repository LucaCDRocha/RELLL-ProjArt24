<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Trail;
use App\Models\Historic;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request): Response
    {
        if ($request->user()) {
            $historics = Historic::where('user_id', auth()->id())->with('trail')
            ->orderBy('updated_at', 'desc')
            ->get();
            $trailData = $historics->map(function ($historic) {
                return $historic->trail->load('img');
            });

            $myTrails = Trail::where('user_id', auth()->id())->get()->load('img');

            return Inertia::render('Profile/Show', [
                'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
                'status' => session('status'),
                'historics' => $trailData,
                'myTrails' => $myTrails
            ]);
        }
        return Inertia::render('Profile/Show');
    }

    /**
     * Display the user's profile edit form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Inertia::render('Profile/Partials/SuccessUpdate');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
