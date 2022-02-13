<input type="hidden" id="nama_produk_id" name="nama_produk_id" 
value="@if(isset($nama_produk->id)) {{$nama_produk->id}}  @endif"
>
<input type="hidden" id="tipe_produk_id" name="tipe_produk_id" 
value="{{$tipe_produk->id}}"
>

    {{-- nama_produk --}}
    @component('components.common_input', ['for_create_edit'=> $for_create_edit, 'detail_table'=>$nama_produk,'data_type'=>'text', 'label_width1'=>'3','label_width2'=>'6','input_width1'=>'6', 'input_width2'=>'6','input_label'=>'Nama Produk', 'input_id'=>'nama_produk'])
    @endcomponent

