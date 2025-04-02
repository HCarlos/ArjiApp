<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest{

    public function authorize()
    {
        return true; // Cambiar a lógica de autorización si es necesario
    }

    public function rules()
    {
        return [
            'username' => [
                'required',
                'string',
                'min:4',
                'max:50',
                'unique:users,username,'.$this->id
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email,'.$this->id
            ],
            'password' => ['nullable', Password::min(8)],
            'curp' => [
                'required',
                'unique:users,curp,'.$this->id
            ],
            'genero' => 'required|in:0,1,2',
        ];
    }


//'fecha_nacimiento' => 'required|date|before:-18 years',

//    'regex:/^[A-Z][AEIOUX][A-Z]{2}\d{2}(0[1-9]|1[0-2])(0[1-9]|1\d|2\d|3[01])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d]\d$/',

//'domicilio.calle' => 'required|string|max:100',
//'domicilio.num_ext' => 'required|string|max:10',
//'domicilio.num_int' => 'nullable|string|max:10',
//'domicilio.colonia' => 'required|string|max:100',
//'domicilio.localidad' => 'required|string|max:100',
//'domicilio.municipio' => 'required|string|max:50',
//'domicilio.estado' => 'required|string|max:50',
//'domicilio.pais' => 'required|string|max:50',
//'domicilio.cp' => 'required|digits:5',
//'lugar_nacimiento' => 'required|string|max:100',
//'ocupacion' => 'required|string|max:100',
//'profesion' => 'required|string|max:100',
//'lugar_trabajo' => 'required|string|max:100'

//'emails' => 'nullable|array',
//'emails.*' => 'email',
//'celulares' => 'nullable|array',
//'celulares.*' => 'digits:10',
//'telefonos' => 'nullable|array',
//'telefonos.*' => 'digits:10',


//    public function messages()
//    {
//        return [
//            'curp.regex' => 'El formato de la CURP es inválido',
//            'fecha_nacimiento.before' => 'El usuario debe ser mayor de 18 años',
//            'domicilio.cp.digits' => 'El código postal debe tener 5 dígitos',
//        ];
//    }

    public function managed ($User) {

       if ($this->id <= 0) {
           $item = [
               'username' => trim($this->username),
               'password' => bcrypt(trim($this->username)),
               'email' => trim($this->email),
               'nombre' => strtoupper(trim($this->nombre)),
               'ap_paterno' => strtoupper(trim($this->ap_paterno)),
               'ap_materno' => strtoupper(trim($this->ap_materno)),
               'curp' => strtoupper(trim($this->curp)),
               'emails' => strtoupper(trim($this->emails)),
               'celulares' => strtoupper(trim($this->celulares)),
               'telefonos' => strtoupper(trim($this->telefonos)),
               'fecha_nacimiento' => $this->fecha_nacimiento ?? now(),
               'genero' => (int) ($this->genero ?? 0),
           ];
           $User = User::create($item);

           $User->user_adress()->create($this->user_adress);
           $User->user_data_extend()->create($this->user_data_extend);

       }else{

           $item = [
               'nombre' => strtoupper(trim($this->nombre)),
               'ap_paterno' => strtoupper(trim($this->ap_paterno)),
               'ap_materno' => strtoupper(trim($this->ap_materno)),
               'curp' => strtoupper(trim($this->curp)),
               'emails' => strtoupper(trim($this->emails)),
               'celulares' => strtoupper(trim($this->celulares)),
               'telefonos' => strtoupper(trim($this->telefonos)),
               'fecha_nacimiento' => $this->fecha_nacimiento ?? now(),
               'genero' => (int) ($this->genero ?? 0),
           ];

           $User->update($item);

           if ( $User->user_adress()->exists() ) {
               $User->user_adress()->update($this->user_adress);
               $User->user_data_extend()->update($this->user_data_extend);
           }else{
               $User->user_adress()->create($this->user_adress);
               $User->user_data_extend()->create($this->user_data_extend);
           }

       }
       return $User;
    }



}
