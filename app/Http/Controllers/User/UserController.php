<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\Mail\UserCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends ApiController
{

  public function __construct()
  {
    $this->middleware('auth:api')->except(['store', 'verify', 'resend']);
    $this->middleware('client.credentials')->only(['store', 'resend']);
    $this->middleware('transform.input:' . UserResource::class)->only(['store', 'update']);
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $usuarios = User::all();
    return $this->showAll($usuarios);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Reglas de validación
    $rules = [
      'name'      => 'required',
      'email'     => 'required|email|unique:users',
      'password'  => 'required|min:6|confirmed'
    ];
    // Validamos los campos
    $this->validate($request, $rules);
    // Creamos la variable con los datos que llegan de la solicitud
    $campos = $request->all();
    // Modificamos los valores para que un usuario no altere los datos
    $campos['password'] = Hash::make($request->password);
    $campos['verified'] = User::USUARIO_NO_VERIFICADO;
    $campos['verification_token'] = User::generarVerificationToken();
    $campos['admin'] = User::USUARIO_REGULAR;
    // Creamos el usuario
    $usuario = User::create($campos);
    // Retornamos la respuesta al cliente
    return $this->showOne($usuario, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    return $this->showOne($user, 200);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    // Reglas de validación
    $rules = [
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'min:6|confirmed',
      'admin' => 'in:' . User::USUARIO_ADMINISTRADOR . ',' . User::USUARIO_REGULAR,
    ];

    $this->validate($request, $rules);

    if ($request->has('name')) {
      $user->name = $request->name;
    }

    if ($request->has('email') && $user->email != $request->email) {
      $user->verified = User::USUARIO_NO_VERIFICADO;
      $user->verification_token = User::generarVerificationToken();
      $user->email = $request->email;
    }

    if ($request->has('password')) {
      $user->password = Hash::make($request->password);
    }

    if ($request->has('admin')) {
      if (!$user->esVerificado()) {
        return $this->errorResponse('Unicamente los usuarios verificados pueden camnbiar su valor de administrador', 409);
      }
      $user->admin = $request->admin;
    }

    if (!$user->isDirty()) {
      return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 422);
    }

    $user->save();
    return $this->showOne($user, 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    $user->delete();
    return $this->showOne($user, 200);
  }

  public function verify($token)
  {
    $user = User::where('verification_token', $token)->firstOrFail();

    $user->verified = User::USUARIO_VERIFICADO;
    $user->verification_token = null;

    $user->save();

    return $this->showMessage('La cuenta ha sido verificada', 201);
  }

  public function resend(User $user)
  {
    if ($user->esVerificado()) {
      return $this->errorResponse('ESte usuario ya ha sido verificado', 409);
    }

    retry(5, function () use ($user) {
      Mail::to($user->email)->send(new UserCreated($user));
    }, 100);

    return $this->showMessage('El correo de verificación se ha reenviado');
  }
}
