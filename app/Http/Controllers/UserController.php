<?php

namespace App\Http\Controllers;

use App\Helpers\Formatting;
use App\Http\Resources\UserResource;
use App\Models\KabKota;
use App\Models\LoginHistory;
use App\Models\Provinsi;
use App\Models\User;
use App\Services\UserServiceInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserServiceInterface $userServiceInterface){
        $this->userService = $userServiceInterface;
    }
    public function index()
    {
        try {
            $users = $this->userService->findByLevel(["master", "kabkota", "provinsi"]);
            $provinsi = Provinsi::all();
            $kabkota = KabKota::all();
            return view("user.index", [
                "users" => $users,
                "provinsi" => $provinsi,
                "kabkota" => $kabkota,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => "Line: ".$e->getLine(),
            ]);

            return redirect("/error$val");
        }
    }
    // Todo: login_at tidak sesuai
    public function loginHistories(){
        try {
            $logins = LoginHistory::all();

            return view("user.login_histories", [
                "data" => $logins
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => "Line: ".$e->getLine(),
            ]);

            return redirect("/error$val");
        }
    }
    public function form(Request $request)
    {
        try {
            $view = "layouts.form";
            $user = $this->userService->findById($request->query("Id") ?? "");
            $kabkota = KabKota::all();
            $formId1 = Uuid::uuid7();
            $formId2 = Uuid::uuid7();
            $formId3 = Uuid::uuid7();
            $formId4 = Uuid::uuid7();
            $formId5 = Uuid::uuid7();

            $optionsKabkota[] = [
                "id" => null,
                "is_selected" => true,
                "name" => "Pilih Tingkatan"
            ];
            $optionsLevel = [
                [
                    "id" => null,
                    "is_selected" => true,
                    "name" => "Pilih Tingkatan"
                ],
                [
                    "id" => "master",
                    "is_selected" => false,
                    "name" => "Master"
                ],
                [
                    "id" => "provinsi",
                    "is_selected" => false,
                    "name" => "Provinsi"
                ],
                [
                    "id" => "kabkota",
                    "is_selected" => false,
                    "name" => "Kabkota"
                ]
            ];
            foreach ($kabkota as $value) {
                $optionsKabkota[] = [
                    "id" => $value->id,
                    "is_selected" => false,
                    "name" => $value->name
                ];
            }
            $config = [
                "name" => "Create User",
                "button_helper" => [
                    "enable" => true,
                    "button_list" => [
                        [
                            "name" => "Kembali",
                            "icon" => "fa fa-arrow-left",
                            "route" => url()->previous(),
                        ],
                    ]
                ],
                "submit" => [
                    "type" => "input", // or "input"
                    "id" => Uuid::uuid7(),
                    "route" => route('user.store'),
                    "method" => "post",
                    "redirect" => route("user.index"),
                    "form_data" => [
                        [
                            "id" => $formId1,
                            "name" => "name",
                        ],
                        [
                            "id" => $formId2,
                            "name" => "username",
                        ],
                        [
                            "id" => $formId3,
                            "name" => "password",
                        ],
                        [
                            "id" => $formId4,
                            "name" => "code",
                        ],
                        [
                            "id" => $formId5,
                            "name" => "level",
                        ],
                    ],
                ],
                "form" => [
                    0 => [
                        "id" => $formId1,
                        "type" => "text",
                        "name" => "Nama",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => null,
                        ],
                    ],
                    1 => [
                        "id" => $formId2,
                        "type" => "text",
                        "name" => "Username",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => null,
                        ],
                    ],
                    2 => [
                        "id" => $formId3,
                        "type" => "text",
                        "name" => "Password",
                        "is_disabled" => false,
                        "for_submit" => false,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "data" => [
                            "value" => null,
                            "placeholder" => null,
                        ],
                    ],
                    3 => [
                        "id" => $formId4,
                        "type" => "select",
                        "name" => "Hak Akses Wilayah",
                        "is_disabled" => false,
                        "for_submit" => true,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => $optionsKabkota,
                    ],
                    4 => [
                        "id" => $formId5,
                        "type" => "select",
                        "name" => "Hak Akses Tingkatan",
                        "is_disabled" => false,
                        "for_submit" => true,
                        "fetch_data" => [
                            "is_fetching" => false,
                        ],
                        "options" => $optionsLevel
                    ],
                ],
            ];
            // Jika user yang dicari dari query parameter ada, ubah form tersebut dengan mengisi sesuai data user yang akan diupdate
            if ($user) {
                $config["name"] = "Update User: $user->name";
                $config["submit"]["route"] = route("user.store", ['Id' => $user->id]);
                $config["form"][0]["data"]["value"] = $user->name;
                $config["form"][1]["data"]["value"] = $user->username;
                $config["form"][2]["data"]["placeholder"] = "Kosongkan jika tidak ingin diganti";
                $config["form"][3]["data"]["value"] = $user->code;
                $config["form"][4]["data"]["value"] = $user->level;
            }
            return view($view, [
                // "data" => $data,
                "config" => $config,
            ]);
        } catch (Exception $e) {
            $val = Formatting::formatUrl([
                "code" => 500,
                "title" => $e->getMessage(),
                "message" => $e->getMessage(),
            ]);

            return redirect("/error$val");
        }
    }
    public function store(Request $request) // everything's work here
    {
        try {
            // default message & response code
            $message = null;
            $responseCode = 200;
            // make the validation
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "username" => "required|string",
                "password" => "string|nullable|min:6",
                "code" => "required|integer",
                "level" => "required|string",

            ]);
            // input user validation
            if ($validator->fails()) {
                $message = $validator->errors()->all();
                $responseCode = 500;
            } else {
                // regex: checking username pattern from user input
                if (preg_match('/^[a-zA-Z0-9]+$/', $request->username)) {
                    $user = $this->userService->findById($request->query("Id") ?? "");
                    if ($user) { // if user finded, update user data
                        $userPassword = $request->password;
                        // password not updating, if password from body response null
                        if (!$userPassword)
                            $userPassword = $user->password;
                        $user->name = $request->name;
                        $user->username = $request->username;
                        $user->password = $userPassword;
                        $user->code = $request->code;
                        $user->level = $request->level;
                        $user->save(); // save user
                        // set new message and response code
                        $message = "User diperbarui";
                    } else {
                        // creating new user
                        $message = $this->userService->createUser([
                            "name" => $request->name,
                            "username" => $request->username,
                            "password" => $request->password,
                            "code" => $request->code,
                        ]);
                    }
                } else { // else of regexp of username
                    $message = "username yang dibuat tidak diperbolehkan";
                    $responseCode = 400;
                }
            }
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                1062 => "Username sudah dipakai",
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $message = null;
            $responseCode = 200;
            $user = $this->userService->findById($id);
            if ($user->level == "master") {
                $responseCode = 403;
                $message = "User tidak dapat dihapus!";
            } else {
                if ($user) {
                    $user->delete();
                    $message = "User berhasil dihapus";
                }
            }
            return response()->json([
                "message" => $message,
            ], $responseCode);
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
    public function activeDeactive(Request $request)
    {
        try {
            $user = $this->userService->findById($request->query("Id"));
            if ($user) {
                $user->is_active = !$user->is_active;
                $user->save();
                return response()->json(["message" => "status user diperbarui"], 200);
            } else {
                return response()->json(["message" => "user tidak ditemukan"], 404);
            }
        } catch (QueryException $e) {
            $message = match ($e->errorInfo[1]) {
                default => $e->getMessage(),
            };
            return response()->json(["message" => $message], 500);
        }
    }
}
