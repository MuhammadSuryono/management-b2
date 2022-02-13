@component('mail::message')

Dear **Bapak/Ibu {{$data->nama}}**,


Password B2 anda sudah direset menjadi ***123456***.

Harap segera mengubah password tersebut dengan masuk ke aplikasi B2.

@component('mail::button', ['url' => 'https://mkp-operation.com/b2'])
Klik di sini untuk login
@endcomponent
<br>

Thanks,<br>

Admin B2 <br>
[Marketing Research Indonesia](http://www.mri-research-ind.com)
@endcomponent
