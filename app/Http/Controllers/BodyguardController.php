<?php

namespace App\Http\Controllers;

use App\Models\Bodyguard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BodyguardController extends Controller
{
    public function editProfile()
    {
        $user = auth()->user();
        abort_unless($user->role === 'bodyguard', 403);

        $bodyguard = $user->bodyguard;
        abort_if(!$bodyguard, 404);

        return view('bodyguards.edit-profile', compact('bodyguard'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        abort_unless($user->role === 'bodyguard', 403);

        $bodyguard = $user->bodyguard;

        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'avatar'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'height'           => ['required', 'integer', 'min:100', 'max:250'],
            'weight'           => ['required', 'integer', 'min:40', 'max:200'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'daily_rate'       => ['required', 'numeric', 'min:10000'],
        ]);

        $user->name = $validated['name'];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        $bodyguard->update([
            'height'           => $validated['height'],
            'weight'           => $validated['weight'],
            'experience_years' => $validated['experience_years'],
            'daily_rate'       => $validated['daily_rate'],
        ]);

        return redirect()->route('bodyguard.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }


    public function registerForm(): View
    {
        return view('bodyguards.register');
    }

    public function registerStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ktp_number'       => ['required', 'string', 'max:20', 'unique:bodyguards,ktp_number'],
            'dob'              => ['required', 'date', 'before:-17 years'],
            'height'           => ['required', 'integer', 'min:100', 'max:250'],
            'weight'           => ['required', 'integer', 'min:40', 'max:200'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'daily_rate'       => ['required', 'numeric', 'min:10000'],
        ]);

        $user = $request->user();

        $user->bodyguard()->create([
            'ktp_number'       => $validated['ktp_number'],
            'dob'              => $validated['dob'],
            'height'           => $validated['height'],
            'weight'           => $validated['weight'],
            'experience_years' => $validated['experience_years'],
            'daily_rate'       => $validated['daily_rate'],
            'is_verified'      => false,
        ]);

        $user->update(['role' => 'bodyguard']);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran bodyguard berhasil! Profil Anda sedang menunggu verifikasi admin.');
    }

    public function index(Request $request)
    {
        $query = Bodyguard::with('user')->where('is_verified', true);

        if ($request->filled('min_rate')) {
            $query->where('daily_rate', '>=', $request->min_rate);
        }
        if ($request->filled('max_rate')) {
            $query->where('daily_rate', '<=', $request->max_rate);
        }
        if ($request->filled('min_experience')) {
            $query->where('experience_years', '>=', $request->min_experience);
        }
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $bodyguards = $query->orderBy('experience_years', 'desc')->paginate(9);

        return view('bodyguards.index', compact('bodyguards'));
    }

    public function show(Bodyguard $bodyguard)
    {
        if (!$bodyguard->is_verified) {
            abort(404);
        }
        $bodyguard->load('user');
        return view('bodyguards.show', compact('bodyguard'));
    }
}
