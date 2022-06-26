<?php

namespace App\Http\Controllers\Base\Acl;

use App\Http\Controllers\Controller;
use App\Models\Base\Acl\User;
use App\Rules\Mobile;
use App\Rules\Name;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $user = User::select('id', 'name', 'office_id', 'email', 'mobile')->findOrFail(Auth::id());
        return view('dashboard.base.user.profile', compact('user'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => ['required', 'min:6', 'max:16'],
            'present_address' => ['nullable', 'min:3', 'max:500', new Name()],
            'email' => ['nullable', 'email', Rule::unique(User::getTableName(), 'email')->ignore($user)],
            'new_password' => ['nullable', 'min:6', 'max:16', 'confirmed'],
            'mobile' => ['nullable', 'numeric', new Mobile()],
        ]);

        $email = $request->email ?? null;
        $user->mobile = $request->mobile;
        $currentPass = $request->current_password;
        $newPass = $request->new_password ?? null;

        if (!Hash::check($currentPass, $user->password)) {
            return response()->json([
                "message" => "The given data was invalid",
                "errors" => [
                    "current_password" => ["Current password does not match."],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($currentPass == $newPass) {
            return response()->json([
                "message" => "The given data was invalid",
                "errors" => [
                    "new_password" => ["New password is same as Current password"],
                ],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($email || $newPass) {
            if ($email) {
                $user->email = $email;
            }
            if ($newPass) {
                $user->password = bcrypt($newPass);
            }
            $user->save();
        }
        return response()->json([
            "success" => $user->name . "'s Profile has been successfully updated.",
        ]);
    }
}
