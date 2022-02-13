@extends('maingentelellatable')
@section('title', 'Tambah Team '. $project_jabatan->jabatan->jabatan) 
@section('title2','Proyek ' .  $project_jabatan->project_kota->project->nama . ' - ' . $project_jabatan->project_kota->kota->kota)

<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left"
method="POST" action="url('/project_teams/save_team') . '/' . $project_jabatan->id ">

@section('content')

@include('layouts.gentelella.table_top')
<thead>
    <tr>
        <th>Pilih</th>
        <th>Nama</th>
        <th>Gender</th>
        <th>HP</th>
        <th>Alamat</th>
        <th></th>
    </tr>
</thead>
<tbody>
    @foreach ($teams as $item)
    <tr>
            <th scope='row'>
                <input type="checkbox" id="available_team_id[]" name="available_team_id[]" class="flat" value="{{ $item->id }} "> {{ $item->id }}
            </th>
            <td>
                @if(isset($item->nama))
                    {{$item->nama}}
                @endif
            </td>
            <td>
                @if(isset($item->gender_id))
                    @if($item->gender_id=1)
                        Laki-laki
                    @else
                        Perempuan
                    @endif
                @endif
            </td>
            <td>{{ $item->hp }} </td>
            <td>{{ $item->alamat }} </td>
    </tr>
    @endforeach
</tbody>
@include('layouts.gentelella.table_bottom')

@endsection('content')
<div class="ln_solid"></div>
<div class="item form-group">
<div class="col-md-6 col-sm-6 offset-md-3">
    <a href="{{ url()->previous() }}" class="btn btn-primary" type="button">Cancel</a>
    <button class="btn btn-primary" type="reset">Reset</button>
    <button type="submit" class="btn btn-success">Save</button>
</div>
</div>
</form>
