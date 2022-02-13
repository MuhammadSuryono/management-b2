<input type="hidden" id="tipe_produk_id" name="tipe_produk_id" 
value="@if(isset($tipe_produk->id)) {{$tipe_produk->id}} @endif"
>

<input type="hidden" id="kategori_produk_id" name="kategori_produk_id" 
value="{{$kategori_produk->id}}"
>
{{-- tipe_produk --}}
@component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$tipe_produk,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Tipe Produk', 'input_id'=>'tipe_produk'])
@endcomponent

