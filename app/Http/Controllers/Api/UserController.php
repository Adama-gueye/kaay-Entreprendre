<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     description="EndPoints pour utilisateur",
 *     version="1.0.0",
 *     title="Swagger Petstore"
 * )
 * 
 */
class UserController extends Controller
{
   

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Retourne liste des utilisateurs",
     *     @OA\Response(response="200", description="Successful operation")
     * )
     */
    public function listeUtilisteurs() {
        $user = Auth::user();
            
        if($user->role == 'admin'){
            $novices = User::whereHas('role', function ($query) {
                $query->where('nom', 'novice');
            })->get();
            $experimentes = User::whereHas('role', function ($query) {
                $query->where('nom', 'experimente');
            })->get();
            return response()->json(compact('experimentes','novices'),200);
        }
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/login",
     *     summary="Connexion entre l'utilisateur",
     *     @OA\Response(response="201", description="connexion succes"),
     *     @OA\Response(response="401", description="Identifiant incorect")
     * )
     */
     public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){

            return Response(['message' => $validator->errors()],401);
        }
   
        if(Auth::attempt($request->all())){

            $user = Auth::user(); 
    
            $success =  $user->createToken('MyApp')->plainTextToken; 
        
            return Response(['token' => $success],200);
        }

        return Response(['message' => 'email or password wrong'],401);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * 
     * @OA\Post(
     *     path="/api/user",
     *     summary="Connexion entre l'utilisateur",
     *     @OA\Response(response="201", description="connexion succes"),
     *     @OA\Response(response="401", description="Identifiant incorect")
     * )
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
     * create compte utilisateur
     */

     /**
     * 
     * @OA\Post(
     *     path="/api/register",
     *     summary="Création compte d'un utilisareur",
     *     @OA\Response(response="201", description="compte creer succes"),
     * )
     */
     public function createCompte(Request $request)
    {
            $request->validate([
                'nom' => ['required', 'string', 'max:30'],
                'prenom' => ['required', 'string', 'max:50'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'string', 'max:50'],
                'image' => ['required', 'string', 'max:255'],

                
            ]);
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
                'nom' => 'required',
                'prenom' => 'required',
                'image' => 'required'
            ]);
       
            if($validator->fails()){
    
                return Response(['message' => $validator->errors()],401);
            }
        $user = new User();
        if($request->file('image')){
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/images'), $filename);
            $user['image']= $filename;
        }
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role_id = $request->role_id;
        $user->save();
        return response()->json($user,201);
        
    }

    /**
     * Display the specified resource.
     */

    /**
     * 
     * @OA\Get(
     *     path="/api/logout",
     *     summary="Déconnexion utilisareur",
     *     @OA\Response(response="200", description="succes"),
     * )
     */
    public function logout(): Response
    {
        $user = Auth::user();

        $user->currentAccessToken()->delete();
        
        return Response(['data' => 'User Logout successfully.'],200);
    }

    
}
