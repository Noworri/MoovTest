<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use Closure;


class TwoFactorAuthentification
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
 
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required',
                'password' => 'required',
                'otp' => 'string'
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {

            $email = $request->input('email');
            $password = $request->input('password');
            $user = User::where('email', $email)->first();
            if ($user) {

                if (Hash::check($password, $user->password)) {

                    if ($user->two_factor_auth) {

                        if ($request->otp && $request->otp == $user->otp) {

                            return $next($request);
                        } else {


                            $otp = $this->generatePin();
                            $user->update(array('otp' => $otp));

                            // SEND OTP
                            $data = [
                                'email'  => $user->email,
                                'name' => $user->first_name,
                                'otp' => $otp
                            ];
                            $this->sendEmailWithSendgrid($data);


                            return response()->json(['status' => false, 'message' => 'otp_required',]);
                        }
                    } else {
                        return $next($request);
                    }
                } else {
                    // UNAUTHORIZE
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                 
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
    }


    public function generatePin()
    {
        $car = 5;
        $string = "";
        $chaine = "0123456789";
        srand((float)microtime() * 1000000);

        for ($i = 0; $i < $car; $i++) {
            $string .= $chaine[rand() % strlen($chaine)];
        }
        return $string;
    }

    public function sendEmailWithSendgrid($mailData) //FOR TWO FACTOR AUTH
    {

        $data = json_encode([
            'from' =>
            [
                'email' => 'contact@pals.africa',
            ],
            'personalizations' =>
            [
                [
                    'to' =>
                    [
                        [
                            'email' => $mailData['email'],
                        ],
                    ],
                    'dynamic_template_data' =>
                    [
                        'name' => $mailData['name'],
                        'otp' => $mailData['otp']

                    ],
                ],
            ],
            'template_id' => \config('app.SendGrid')["TWO_FACTOR_AUTH_EMAIL_TEMPLATE_ID"],
        ]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sendgrid.com/v3/mail/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . \config('app.SendGrid')["API_KEY"],
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}
